<?php namespace App\MainFlow;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use PDF;
use DB;
use App\User;
use Auth;
class PaymentNoticePdf2 {
    
    public function __construct($pay_day,$user_number)
    {
        $this->pay_day = $pay_day;
        $this->user_number = $user_number;
    }

    public function savePdf()
    {
        if (isset(Auth::user()->role_id) && Auth::user()->role_id == '2'){

                $account = User::where('member_number',$this->user_number)->first();
                $user_id =  $account->user_id ;
                $user = DB::select("
                SELECT 
                    * FROM users u,tender_documents t ,orders o ,claims c
                WHERE
                    t.user_id = u.user_id 
                and 
                    t.order_id = o.order_id 
                and 
                    u.user_id = '".$user_id."' 
                and 
                    o.virtual_account > 0 
                and
                    c.claim_id = t.claim_id
                and 
                    DATE_FORMAT(o.created_at, '%Y-%m-%d') = '".$this->pay_day."'
                ");
                // print_r($user);exit;
                $user = json_decode(json_encode($user),true);
                $total = [];
                $nid ='';
                foreach($user as $k=>$v){
                    //$totalAmount = $user[$k]['actual_amount'];
                    if( $nid <> $user[$k]['order_id']){
                        $totalAmount = $user[$k]['amount'];
                        array_push($total,$totalAmount);
                    }
                }
                $pdf = PDF::loadView('pdf.paymentNotice',[
                    'user' => $user[0],
                    'tenders' => $user,
                    'totalAmount' => array_sum($total)
                ]);

                return $pdf->stream($user[0]['order_id'].'_繳款通知書.pdf');
            
        }else{
            session()->flash('pdferror', '123');
            return redirect('/');
            
        }
        
        
        // return $pdf->stream('paymentNotice.pdf');
        // $fileName = $order_id.'_繳款通知書.pdf';
        // $path = $this->StorePDF($fileName,$pdf->output());
       
    }

    private function StorePDF($fileName, $file)
    {
        Storage::disk('public_uploads')->put('PaymentNoticePdf/' . date("Ymd").'/' .$fileName, $file);
        $FilePath = 'uploads/PaymentNoticePdf/' .date("Ymd") . '/' . $fileName;
        return $FilePath;
    }
}
