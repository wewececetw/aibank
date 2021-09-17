<?php

include_once("common/Common.php");
/**
 *先息後本
 */
class equalPrincipalPayment extends Common {

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
        $result['everyMonthInterest'] = $this->everyMonthInterest();
        $result['everyMonthPrincipal'] = $this->everyMonthPrincipal();
        // $result['everyMonthInterest'] = $this->everyMonthInterest();
        $result['everyMonthPrincipalBalance'] = $this->everyMonthPrincipalBalance();
        $result['everyMonthPaidTotal'] = $this->everyMonthPaidTotal($result['everyMonthPrincipal'], $result['everyMonthInterest']);
        return $result;
    }


    /**
     * 每月本息合計
     *
     * @return void
     */
    public function everyMonthPaidTotal($principalArray , $interestArray)
    {
        $ar = [];
        foreach($interestArray as $k => $v){
            $value = $v + $principalArray[$k];
            $ar[$k] = $value;
        }
        return $ar;
    }

    /**
     * 每月利息
     *
     * @return void
     */
    public function everyMonthInterest()
    {
        $ar = [];
        //$totalInterest = round(((int)$this->amount / 100) * (int)$this->rate) ;
        $totalInterest = round(((int)$this->amount / 100) * $this->rate) ;
        $avgInterest = $totalInterest / 12;
        $total = round($avgInterest*$this->totalMonth);
        //總應返還
        // $amortizationRate_total = $this->amortizationRate*$this->totalMonth*$this->amount;
        //每月利息(去小數)
        $everyInterst = round($avgInterest);
        //最後一其利息
        // $total = 0;
        //$lastInterst = round($avgInterest*($this->totalMonth-1));
        // echo $lastInterst;
        // exit;
        for($x =0;$x < $this->totalMonth; $x++){
            if($x == $this->totalMonth-1){
                $ar[$x] = $total;
            }else{
                $ar[$x] = $everyInterst;
                $total = $total - $everyInterst;
            }

        }
        // echo $lastInterst.'<br>'. $total;
        // exit;
        return $ar;
    }

    /**
     * 每月本金
     *
     * @return void
     */
    public function everyMonthPrincipal()
    {
        $ar = [];
        for($x =0;$x < $this->totalMonth; $x++){
            if($x == $this->totalMonth-1){
                $ar[$x] = (int)$this->amount;
            }else{
                $ar[$x] = 0;
            }
        }
        return $ar;
    }
    /**
     * 每月剩餘
     *
     * @return void
     */
    public function everyMonthPrincipalBalance()
    {
        $ar = [];
        for($x =0;$x < $this->totalMonth; $x++){
            if($x == $this->totalMonth-1){
                $ar[$x] = 0;
            }else{
                $ar[$x] = (int)$this->amount;
            }
        }
        return $ar;
    }

    // /**
    //  * 計算每月本息合計
    //  * 攤還率 * 貸款總金額
    //  * @return array 每個月 本息合計金額 小數點已加總至最後個月
    //  */
    // public function everyMonthPaidTotal()
    // {
    //     $average = $this->amortizationRate * $this->amount;
    //     $averageArray = [];
    //     for($x=0;$x<$this->totalMonth;$x++){
    //         array_push($averageArray,$average);
    //     }

    //     $result = $this->sumToLastMonth($averageArray);
    //     return $result;
    // }
    // /**
    //  * 計算每個月的 利息 本金 貸款餘額
    //  */
    // public function countEveryMonth($everyMonthPaidTotal)
    // {
    //     $result = [
    //         'everyMonthInterest' => [],
    //         'everyMonthPrincipalBalance' => [],
    //         'everyMonthPrincipal' => [],
    //     ];
    //     //本息浮點數總和
    //     $interestTotal = 0;
    //     //貸款餘額
    //     $principalBalance = $this->amount;

    //     // $everyMonthPrincipal = '每月應還本金陣列';
    //     // $everyMonthPrincipalBalance = '每月貸款餘額陣列';
    //     // $everyMonthInterest = '每月應還本息陣列';

    //     for($x=0;$x<$this->totalMonth;$x++){
    //         //每月本息 = 前月剩餘貸款金額 * 月利率
    //         $interestWithFloat = $principalBalance *  $this->mounthRate;
    //         $interestWithFloat = $this->getIntAndFloat($interestWithFloat);
    //         $interest = (int)$interestWithFloat['integer'];
    //         $interestTotal = $interestTotal + $interestWithFloat['decimalPoint'];
    //         //每月本金 = 每月本息合計 - 每月本息
    //         $principal = $everyMonthPaidTotal[$x] - $interest;

    //         $principalBalance = $principalBalance - $principal;
    //         array_push($result['everyMonthInterest'] , $interest);
    //         array_push($result['everyMonthPrincipal'] , $principal);
    //         array_push($result['everyMonthPrincipalBalance'] , $principalBalance);
    //     }
    //     // dd($result,$interestTotal,$everyMonthPaidTotal,$this->mounthRate);
    //     //處理最後一個月
    //     $lastMonth = $this->totalMonth - 1;
    //     // $lastInterest = ($everyMonthPaidTotal[$lastMonth] * $this->mounthRate ) + $interestTotal;
    //     $beforeLastPrincipalBalance =  $result['everyMonthPrincipalBalance'][$lastMonth -1];
    //     $lastInterest = $everyMonthPaidTotal[$lastMonth] - $beforeLastPrincipalBalance;
    //     $lastInterest = round($lastInterest,0);
    //     $result['everyMonthInterest'][$lastMonth] = $lastInterest;
    //     $result['everyMonthPrincipal'][$lastMonth] =  $beforeLastPrincipalBalance ;
    //     // $result['everyMonthPrincipal'][$lastMonth] =  $everyMonthPaidTotal[$lastMonth] - $lastInterest ;
    //     $result['everyMonthPrincipalBalance'][$lastMonth] = $result['everyMonthPrincipalBalance'][$lastMonth-1] -$result['everyMonthPrincipal'][$lastMonth] ;
    //     return $result;
    // }
}

