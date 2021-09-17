<?php
namespace App\PayBackCount;

/**
 * 本息攤還
 */
class equalTotalPayment extends Common {

    /**
     * @var String|int|float $rate = 年利率
     * @var String|int $totalMonth = 總分期數 (月份)
     * @var String|int $amount = 貸款總金額
     * @var int|float $mounthRate = 月利率
     * @var int|float $powMonRate = (1+月利率)的分期數次方
     * @var int|float $amortizationRate = 攤還率
     */
    public $rate;
    public $totalMonth;
    public $amount;
    public $mounthRate;
    public $powMonRate;
    public $amortizationRate;
    /**
     *  建構子
     * @param String|int|float $rate = 年利率
     * @param String|int $totalMonth = 總分期數 (月份)
     * @param String|int $amount = 貸款總金額
     * @param String|int $mounthRate = 月利率
     * @param String|int $powMonRate = (1+月利率)的分期數次方
     * @param int|float $amortizationRate = 攤還率
     *
     */
    public function __construct($rate, $totalMonth, $amount)
    {
        $this->rate = $rate;
        $this->totalMonth = $totalMonth;
        $this->amount = $amount;
        $this->mounthRate = ($rate / 12) / 100;
        $this->powMonRate = pow(1+$this->mounthRate,$totalMonth);
        $this->amortizationRate = ($this->powMonRate * $this->mounthRate) / ($this->powMonRate -1);
        // dd($this->mounthRate);
    }
    // [(1＋月利率)^月數]
    /**
     * 自動跑本金攤還
     *
     * @return array
     * [
     *  'everyMonthPrincipal' => 每月應還本金陣列,
     *  'everyMonthPrincipalBalance' => 每月貸款餘額陣列,
     *  'everyMonthInterest' => 每月應還本息陣列,
     *  'everyMonthPaidTotal' => 每月應還本息合計陣列,
     * ]
     */
    public function run()
    {
        //每月 應還 本息合計
        $everyMonthPaidTotal = $this->everyMonthPaidTotal();

        $everyMonthResult = $this->countEveryMonth($everyMonthPaidTotal);
        $everyMonthResult['everyMonthPaidTotal'] = $everyMonthPaidTotal;
        return $everyMonthResult;
    }

    /**
     * 計算每月本息合計
     * 攤還率 * 貸款總金額
     * @return array 每個月 本息合計金額 小數點已加總至最後個月
     */
    public function everyMonthPaidTotal()
    {
        $average = round($this->amortizationRate * $this->amount);
        $averageArray = [];
        $a_m = round($this->amortizationRate * $this->amount * $this->totalMonth,0);//總反還總額
        for($x=0;$x<$this->totalMonth;$x++){
            IF($x==$this->totalMonth-1){
                $average=$a_m;
            }else{
                $a_m -=$average;
            }
            array_push($averageArray,$average);
        }
        $result = $this->sumToLastMonth($averageArray);
        return $result;
    }
    /**
     * 計算每個月的 利息 本金 貸款餘額
     */
    public function countEveryMonth($everyMonthPaidTotal)
    {
        $result = [
            'everyMonthInterest' => [],
            'everyMonthPrincipalBalance' => [],
            'everyMonthPrincipal' => [],
        ];
        //本息浮點數總和
        $interestTotal = 0;
        //貸款餘額
        $principalBalance = $this->amount;

        // $everyMonthPrincipal = '每月應還本金陣列';
        // $everyMonthPrincipalBalance = '每月貸款餘額陣列';
        // $everyMonthInterest = '每月應還本息陣列';


        $principalBalance = $this->amount;
        $r_m = round($this->amortizationRate * $this->amount,0); //總反還
        $a_m = round($this->amortizationRate * $this->amount * $this->totalMonth,0);//總反還總額
        $a_r = $a_m - $this->amount;//總利潤
        for($x=0;$x<$this->totalMonth;$x++){
            IF($x==$this->totalMonth-1){

                $interest   = $a_r;//當月利息
                $principal  =  $a_m - $a_r;//當月返還本金
                $principalBalance = $principal -$interest ;//剩餘本金

            }else{
                //每月本息 = 前月剩餘貸款金額 * 月利率
                $interest   = round($principalBalance * ($this->rate/12)*0.01);//當月利息
                $principal  = $r_m - $interest;//當月返還本金
                $principalBalance -= $principal ;//剩餘本金
                $a_m -= $r_m; //計算剩餘總反還
                $a_r -= $interest; //計算剩餘總利息
            }
            array_push($result['everyMonthInterest'] , $interest);
            array_push($result['everyMonthPrincipal'] , $principal);
            array_push($result['everyMonthPrincipalBalance'] , $principalBalance);
        }
        return $result;
    }
}
