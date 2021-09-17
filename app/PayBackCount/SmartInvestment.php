<?php
namespace App\PayBackCount;

use App\Claim;
use DB;

class SmartInvestment
{
    public $amount;
    public $peroids;
    public $setting;
    public $risks;
    private $claim_state = 1;

    /**
     * __construct
     *
     * @param  int $amount 投資金額
     * @param  array $peroids
     * @param  mixed $investment_setting
     * @return void
     */
    public function __construct($amount, $peroids, $investment_setting)
    {

        $this->amount = $amount;
        $this->peroids = $peroids;
        $this->setting = $investment_setting;
        $this->risks = $this->getRisks();

    }

    /**
     * 試算 Main Function
     */
    public function getResult()
    {
        $result = [];
        $amountOverLoad = $this->checkAmountOverLoad();
        if ($amountOverLoad !== true) {
            return $amountOverLoad;
        }
        foreach ($this->setting as $k => $v) {
            // $k = risk_category
            $t = $this->getSql('oneRiskEachClaim', $k);
            $ar = $this->getArray($t);
            $amount = ((int) $v / 100) * $this->amount;

            $tender = $this->getTenderAmount($ar, $amount);
            if(count($result) == 0){
                $result = $tender;
            }else{
                foreach ($tender as  $value) {
                    array_push($result,$value);
                }
            }
        }

        foreach ($result as $key => $value) {
            if(!isset($value['throwAmount'])){
                unset($result[$key]);
            }
        }
        $result = [
            'success' => true,
            'result' => $result
        ];
        return $result;
    }


    /**
     * getRandomResult 隨機媒合
     *
     * @return void
     */
    public function getRandomResult()
    {
        $result = [];
        $sql = $this->getSql('randomClaim');
        $maxAmount = collect($sql)->sum('MAX');
        if($maxAmount == 0){
            return 'noClaim';
        }
        if($this->amount > $maxAmount){
            return 'amountOverLoad';
        }else{
            $sqlArray = $this->getArray($sql);
            $claimCount = count($sqlArray);
            $xlen = $this->amount / 1000;
            $remaining = $this->amount;
            for($x = 0; $x < $xlen ; $x++){
                for($y = 0; $y < $claimCount ; $y++){
                    if(!isset($sqlArray[$y]['throwAmount'])){
                        $sqlArray[$y]['throwAmount'] = 0;
                    }
                    if(!isset($sqlArray[$y]['max_amount'])){
                        $sqlArray[$y]['max_amount'] = $sqlArray[$y]['MAX'];
                    }
                    if($sqlArray[$y]['MAX'] != $sqlArray[$y]['throwAmount'] && $remaining != 0){
                        $test = $sqlArray[$y]['throwAmount'] + 1000;
                        if($test <= $sqlArray[$y]['MAX']){
                            $sqlArray[$y]['throwAmount'] += 1000;
                            $remaining -= 1000;
                        }

                    }
                }
            }
            $result["success"] = true;
            $result['result'] = $sqlArray;
            return $result;
        }
    }

    private function getTenderAmount($ar, $amount)
    {
        // dd($ar,$amount);
        $newAr = $ar;
        $x = $amount / 1000;
        $xlen = 0;

        $balance = $amount;
        //需求說要這樣算的
        for ($x; $x > $xlen; $x--) {

            $y = 0;
            $ylen = count($ar);
            for ($y; $y < $ylen; $y++) {

                if ($balance != 0) {
                    if (!isset($newAr[$y]['throwAmount'])) {
                        $newAr[$y]['throwAmount'] = 0;
                    }
                    if($newAr[$y]['throwAmount'] != $newAr[$y]['max_amount']){
                        $newAr[$y]['throwAmount'] += 1000;
                        $balance -= 1000;
                    }

                }
            }

        }
        return $newAr;
    }

    /**
     * 把DB::select 轉成陣列用類似 model->toArray()
     * 但DB好像沒有toArray()(應該吧)
     *
     * @param  mixed $collection
     * @return void
     */
    private function getArray($collection)
    {
        $res = [];
        foreach ($collection as $k => $v) {
            // if(isset($v->MAX) && $v->MAX != 0){
            //     array_push($res, (array) $v);
            // }
            if(isset($v->MAX)){
                if($v->MAX != 0){
                    array_push($res, (array) $v);
                }
            }else{
                array_push($res, (array) $v);
            }
        }
        return $res;
    }

    /**
     * 判斷投資金額是否超過目前可用債權總額
     *
     * @return string
     */
    public function checkAmountOverLoad()
    {
        //剩餘可投總金額 和 可投資債權數量
        $remaining_claimCount = $this->getSql('amount_remaining')[0];
        if ($remaining_claimCount->countClaim > 0 && $this->amount <= (int) $remaining_claimCount->amount_remaining) {
            //判斷 投資設定的%數會不會超過
            $setAmountOverLoad = [];
            foreach ($this->setting as $k => $v) {
                //這次投資金額 * (risk = A)50%
                $thisThrow = ((int) $v / 100) * (int) $this->amount;

                $canThrowMax = (int) $this->getSql('amount_remaining', $k)[0]->amount_remaining;
                if ($thisThrow > $canThrowMax) {
                    $risk = (new Claim)->getRiskCategoryAttribute($k);
                    array_push($setAmountOverLoad, $risk);
                }
            }

            if (count($setAmountOverLoad) > 0) {
                return $setAmountOverLoad;
            } else {
                return true;
            }
        } else {
            if ($remaining_claimCount->countClaim == 0) {
                return 'noClaim';
            } else {
                return 'amountOverLoad';
            }
        }
    }

    /**
     * getSql 取得SQL 或是直接取得結果
     *
     * @param  mixed $type
     * @return void
     */
    public function getSql($type, $var1 = false)
    {
        switch ($type) {
            case 'amount_remaining':
                if ($var1 === false) {
                    $riskStringArray = $this->getRisks(true);
                } else {
                    $riskStringArray = $var1;
                }
                $claimState = $this->claim_state;
                $peroids = implode(',', $this->peroids);

                $setStatement = sprintf("SET @risk := '%s',
                @claimState = '%d',
                @remaining_periods = '%s'", $riskStringArray, $claimState, $peroids);
                DB::statement(DB::raw($setStatement));
                $sql = DB::select(DB::raw("SELECT
                        COUNT(claim_id) AS countClaim,
                        SUM(staging_amount) - IFNULL(
                            (
                            SELECT
                                SUM(td.amount)
                            FROM
                                claims AS c
                            INNER JOIN tender_documents AS td
                            ON
                                td.claim_id = c.claim_id
                            WHERE
                                FIND_IN_SET(c.risk_category, @risk) AND c.claim_state = @claimState AND FIND_IN_SET(
                                    c.remaining_periods,
                                    @remaining_periods
                                )
                        ),
                        0
                        ) AS amount_remaining
                    FROM
                        claims
                    WHERE
                        FIND_IN_SET(risk_category, @risk) AND claim_state = @claimState AND FIND_IN_SET(
                            remaining_periods,
                            @remaining_periods
                )"));
                return $sql;
                break;

            case 'oneRiskEachClaim':
                //取每種 risk_category的claim id 和 最大金額 並依最容易滿的排序
                $riskStringArray = $var1;
                $claimState = $this->claim_state;
                $peroids = implode(',', $this->peroids);

                $setStatement = sprintf("SET @risk := '%s',
                @claimState = '%d',
                @remaining_periods = '%s'", $riskStringArray, $claimState, $peroids);
                DB::statement(DB::raw($setStatement));
                $sql = DB::select(DB::raw("SELECT * FROM
                                            (SELECT
                                                c.claim_id,
                                                c.staging_amount - IFNULL(SUM(td.amount) ,
                                                0) AS max_amount,
                                                IFNULL((SUM(td.amount) / staging_amount),0) * 100 AS progress
                                            FROM
                                                claims AS c
                                            LEFT JOIN tender_documents AS td
                                            ON
                                                td.claim_id = c.claim_id
                                            WHERE
                                                FIND_IN_SET(c.risk_category, @risk) AND c.claim_state = @claimState AND FIND_IN_SET(
                                                    c.remaining_periods,
                                                    @remaining_periods
                                                )
                                            GROUP BY
                                                c.claim_id
                                            ORDER BY
                                            max_amount ASC) AS result
                                            WHERE result.max_amount != 0"));
                return $sql;
                break;
            case 'maxPeriods':
                $sql = Claim::select(DB::raw('MAX(remaining_periods) as maxPeriods'))->where('claim_state',$this->claim_state)->first()->maxPeriods;
                dd($sql);
                $result = [];
                for($x=1;$x<$sql+1;$x++){
                    array_push($result,$x);
                }
                return $result;
            break;
            case 'randomClaim':
                $setStatement = sprintf("SET @risk := '%s',
                            @claimState = '%d'", '0,1,2,3,4', $this->claim_state);
                DB::statement(DB::raw($setStatement));
                $sql = DB::select(DB::raw("SELECT
                        c.claim_id,
                            (c.risk_category),
                            c.staging_amount - IFNULL(SUM(td.amount),
                            0) AS MAX,
                            IFNULL((SUM(td.amount) / staging_amount),0) * 100 AS progress
                        FROM
                            claims AS c
                        LEFT JOIN tender_documents AS td
                        ON
                            td.claim_id = c.claim_id
                        WHERE
                            c.claim_state = @claimState AND FIND_IN_SET(c.risk_category, @risk)
                        GROUP BY
                            c.claim_id
                        order by progress DESC"));
                        return $sql;
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * 取得用到的risk_category陣列
     *
     * @return void
     */
    public function getRisks($str = false)
    {
        if ($str == true) {
            $result = array_keys($this->setting);
            return implode(',', $result);
        } else {
            $result = array_keys($this->setting);
            return $result;
        }
    }




}
