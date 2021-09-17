<?php

class Common {
    /**
     * 年利率換算 總利率%
     *
     * @param String|int rate = 輸入年利率
     * @param String|int totalMonth = 總分期數(月)
     * @return int|float 總年利率%
     */

    public function countTotalRate($rate, $totalMonth)
    {
        $ratePercent = (int) $rate / 100;
        $year = (int) $totalMonth / 12;
        $totalRate = $ratePercent * $year;
        return $totalRate;
    }

    /**
     * 判斷數字是否含有小數
     * 有的話將小數取出
     * @param String|Int|Float $number = 要判斷的數字
     * @return array
     *  [
     *    'integer' => 整數部分,
     *    'decimalPoint' => 小數點部分
     *  ]
     */
    public function getIntAndFloat($number)
    {
        if(is_int($number)){
            $flo = 0.0;
            $integer = $number;
        }else{
            $integer = (int)floor($number);
            $flo = $number-$integer;
        }
        $result = [
            'integer' => $integer,
            'decimalPoint' => $flo
        ];
        return $result;
    }
    /**
     * 計算每月貸款餘額
     * (總貸款金額 - 已付本金)
     *
     * @param array everyMonthPrincipal = 每月本金
     */
    public function countEveryMonthPrincipalBalance($everyMonthPrincipal)
    {
        /**
         * @var int paidTotal = 已付本金
         */
        $result = [];
        $paidTotal = 0;
        foreach ($everyMonthPrincipal as $month => $principal) {
            $paidTotal = $paidTotal +  $principal;
            $principalBalance = $this->amount - $paidTotal;
            array_push($result,$principalBalance);
        }
        return $result;
    }



    /**
     * 將小數點數字總和至最後一個月並4捨5入取整數
     *
     * @param array amountArray [n月金額,n+1月金額,...]
     */
    public function sumToLastMonth($amountArray)
    {
        $result = [];
        $amountLength = count($amountArray);
        $floatTotal = 0;
        for($y=0;$y<$amountLength;$y++){
            $interestObj = $this->getIntAndFloat($amountArray[$y]);
            $floatTotal = $floatTotal + $interestObj['decimalPoint'];
            if($y!= ($amountLength -1 )){
                array_push($result,$interestObj['integer']);
            }else{
                $floatTotal = round( $floatTotal,0);
                $total = $interestObj['integer'] + $floatTotal;
                array_push($result,(int)$total);
            }
        }
        return $result;
    }

    /**
     * 取得分期日期陣列 起息日+1個月開始
     */
    public function getPeriodsTimeArrayNew($periods,$startDay)
    {
        $result = [];
        if($periods == 'NotSet'){
            return $result;
        }else{
            $now = strtotime(date('Y-m-d',strtotime($startDay)));
            $i=1;
            $ilength = (int)$periods + 1;
            for($i;$i<$ilength;$i++){
                array_push($result,date('Y-m-d',strtotime("+".$i." month",$now)));
            }
            return $result;
        }
    }
}
