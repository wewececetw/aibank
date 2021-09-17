<?php
namespace App\MainFlow;
use PDF;
use App\User;
use App\Claim;
use App\Tenders;
use App\PayBackCount\equalPrincipalPayment;
use App\PayBackCount\equalTotalPayment;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\PayBackCount\Common;

class ClaimPdf{

    public $User;
    public $Claim;
    public $Payment;
    public $Amount;
    public $managmentFee;
    public $timeArray;
    public $pdf ;
    public $ClaimArray;
    public $thirdPartyManagmentFeeArray;
    /**
     * 建構子
     * @param string|int $user_id 使用者ID
     * @param string|int $claim_id 債權ID
     * @param string|int $amount 投資金額
     * @param string $claim_certificate_number 債權憑證號
     *
     * @return bool 如果出錯回傳false
     */
    public function __construct($user_id,$claim_id,$amount,$claim_certificate_number=false)
    {
        try {
            $this->User = User::find($user_id);
            $this->Claim = Claim::find($claim_id);
            $this->Amount = $amount;
            if($this->Claim && $this->User){
                if($this->Claim->repayment_method == '0' || $this->Claim->repayment_method == '先息後本'){
                    $payment = new equalPrincipalPayment($this->Claim->annual_interest_rate,$this->Claim->remaining_periods,$amount);
                    $this->Payment = $payment->run();

                }else{
                    $payment = new equalTotalPayment($this->Claim->annual_interest_rate,$this->Claim->remaining_periods,$amount);
                    $this->Payment = $payment->run();
                }
                $this->timeArray = $payment->getPeriodsTimeArrayNew($this->Claim->remaining_periods,$this->Claim->value_date);

                //計算服務費 看起來應該是 每月利息 * managment_fee_rate百分比後 四捨五入
                $managmentFee = [];
                foreach ($this->Payment['everyMonthInterest'] as $k => $v) {
                    $fee = round($v * $this->Claim->management_fee_rate * 0.01);
                    array_push($managmentFee , $fee);
                }
                $this->managmentFee = $managmentFee;
                $this->ClaimArray = $this->claimChangeNull();
                
                if(!empty($claim_certificate_number)){
                    $tender = Tenders::where('claim_certificate_number', $claim_certificate_number)->first();
                    $created_at = strtotime($tender->created_at);
                    
                    if (strtotime($this->User->discount_start) <= $created_at && strtotime($this->User->discount_close) >= $created_at) {
                        $this->thirdPartyManagmentFeeArray = $this->thirdPartyManagmentFee($this->Payment['everyMonthInterest'],$this->Claim->management_fee_rate * $this->User->discount);
                    }else{
                        $this->thirdPartyManagmentFeeArray = $this->thirdPartyManagmentFee($this->Payment['everyMonthInterest'],$this->Claim->management_fee_rate);
                    }    
                }else{
                    $this->thirdPartyManagmentFeeArray = $this->thirdPartyManagmentFee($this->Payment['everyMonthInterest'],$this->Claim->management_fee_rate);
                }
                
                //$this->thirdPartyManagmentFeeArray = $managmentFee;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    /**
     *計算丙方平台服務費 = (甲方利息*10%)四捨五入後 均分於每期 每期將小數位取出只留整數，將小數位總和加至最後一期
     */
    public function thirdPartyManagmentFee($everyMonthArray,$fee_rate)
    {

        $total = array_sum($everyMonthArray);

        // $total = (int)round(0.1 * $total);
        $all_total = round($total * $fee_rate) / 100;
        
        //$avg = $total/count($everyMonthArray);

        $ar = [];
        
        // foreach ($everyMonthArray as $key) {
        for($i = 0;$i < count($everyMonthArray);$i ++){
            if ($all_total >= 0 && $i == count($everyMonthArray)-1) {
                $br = round($all_total);
            }elseif($all_total <= 0){
                if($fee_rate == '0'){
                    $ar[-1] = -1;
                }
                if($all_total <= 0 && $ar[$i-1] > 0){
                    $ar[$i-1] = round($ar[$i-1] + $all_total);
                }
                $br = 0;
            }else{

                $brr = ($everyMonthArray[$i] * $fee_rate) / 100;
                $br = round($brr);
                $all_total =  $all_total - $br;
            }
            
            array_push($ar, $br);
        }
        unset($ar[-1]);

        $common = new Common;
        $res = $common->sumToLastMonth($ar);
        return $res;
    }
    /**
     * 將Null轉為空值並塞入判斷顯示債權憑證編號
     */
    public function claimChangeNull()
    {
        $c = [];
        foreach ($this->Claim->toArray() as $key => $value) {
            if(isset($value)){
                $c[$key] = $value;
            }else{
                $c[$key] = '';
            }
        }
        $showClaimNum = ( $c['claim_state'] == 2 || $c['claim_state'] == '結標繳款')?true:false;
        $c['showClaimNum'] = $showClaimNum;
        return $c;
    }

    /**
     * 頁面顯示PDF
     * @return bool|PDF 出錯回傳false 否則 PDF 實例
     */
    public function stream()
    {
        try {
            $firstPartyTotal = array_sum($this->Payment['everyMonthPrincipal']) + array_sum($this->Payment['everyMonthInterest']);
            $pdf = PDF::loadView('pdf.sample',[
                'user' => $this->User,//
                'claim' => $this->ClaimArray,//
                'amount' => $this->Amount,//
                'money' => $this->Payment,//
                'managmentFee' => $this->managmentFee,//
                'timeArray' => $this->timeArray,//
                'thirdPartyManagmentFeeArray' => $this->thirdPartyManagmentFeeArray,//
                'thirdPartyManagmentFeeTotal' => array_sum($this->thirdPartyManagmentFeeArray),//
                'firstPartyTotal' => $firstPartyTotal,
                'all_everyMonthPrincipal' => array_sum($this->Payment['everyMonthPrincipal']),//
                'all_everyMonthInterest' => array_sum($this->Payment['everyMonthInterest'])//
            ]);
            
            return $pdf->stream('sample.pdf');
        } catch (\Throwable $th) {
            return false;
        }
    }
    /**
     * 回傳PDF下載
     */
    public function download()
    {
        try {
            $pdf = PDF::loadView('pdf.sample',[
                'user' => $this->User,
                'claim' => $this->ClaimArray,
                'amount' => $this->Amount,
                'money' => $this->Payment,
                'managmentFee' => $this->managmentFee,
                'timeArray' =>  $this->timeArray,
                'thirdPartyManagmentFeeArray' => $this->thirdPartyManagmentFeeArray,
                'thirdPartyManagmentFeeTotal' => array_sum($this->thirdPartyManagmentFeeArray)
            ]);
            return $pdf->download('sample.pdf');

        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }

    /**
     * 儲存所有的債權憑證
     * @param string|int $id tender_id
     */
    public function saveClaimTendersPdf($id,$claim_certificate_number)
    {
        try {
            $pdf = PDF::loadView('pdf.realpay',[
                'user' => $this->User,
                'claim' => $this->ClaimArray,
                'amount' => $this->Amount,
                'money' => $this->Payment,
                'managmentFee' => $this->managmentFee,
                'timeArray' =>  $this->timeArray,
                'thirdPartyManagmentFeeArray' => $this->thirdPartyManagmentFeeArray,
                'thirdPartyManagmentFeeTotal' => array_sum($this->thirdPartyManagmentFeeArray),
                'claim_certificate_number' => $claim_certificate_number,
                'all_everyMonthPrincipal' => array_sum($this->Payment['everyMonthPrincipal']),
                'all_everyMonthInterest' => array_sum($this->Payment['everyMonthInterest'])
            ]);
            $fileName = $id.'_tender.pdf';
            $path = $this->StorePDF($fileName,$pdf->output());
            $tender = Tenders::find($id);
            $tender->claim_pdf_path = $path;
            $tender->updated_at = date('Y-m-d H:i:s');
            $tender->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }

    }


    //存圖片
    public function StorePDF($fileName, $file)
    {
        Storage::disk('public_uploads')->put('ClaimTenderPDF/' .$fileName, $file);
        $FilePath = 'uploads/ClaimTenderPDF/' . $fileName;
        return $FilePath;
    }


    // //重新命名
    // public function Del_deputy_file_name($file)
    // {
    //     $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
    //     $fileName = $num . $file;
    //     $secondFileName = explode('.',$fileName)[1];

    //     $fileName = md5($fileName).'.'.$secondFileName;
    //     return $fileName;
    // }


}
