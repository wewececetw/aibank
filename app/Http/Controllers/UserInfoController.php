<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\InboxLetters;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\UsersRoles;
use App\Sms\sendSMS;
use Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailTo;
use App\Mail\SampleMail;

class UserInfoController extends Controller
{

     public function index(){

        $user_id = Auth::user()->user_id;
        $data['user'] = User::where('user_id',$user_id)->first();

        //20200304 Jason 修改
        if($data['user']->user_state <= 0 || $data['user']->user_state == 3){
            $data['userPictureAttr'] = 'required';
        }else{
            $data['userPictureAttr'] = 'disabled';
        }

        return view('Front_End.user_manage.users_info.users_info_panel',$data);


    }

    public function isUserNeedCheckPhoneToken($user,$newPhone)
    {
        $result = false;
        if($user->user_state == 0){
            $result = false;
            // $result = true;
        }else{
            if($user->phone_number == $newPhone){
                $result = true;
            }else{
                $result = false;
            }
        }
        return $result;
    }

    public function userInfo(Request $request)
    {
        $reqData = $request->all();
        unset($reqData['_token']);
        $user_id = Auth::user()->user_id;
        $mobile_check_token = Auth::user()->mobile_check_token;

        $user_form_send_time = date('Y-m-d H:i:s');
        $mobile_token_send_time = Auth::user()->mobile_check_token_sent_at;

        $check_time = (strtotime($user_form_send_time) - strtotime($mobile_token_send_time)) ;

        $needCheckToken = $this->isUserNeedCheckPhoneToken(Auth::user(),$request->phone_number);

        if( Auth::user()->user_state != 1){
            $checkIdCard = User::where('id_card_number',$reqData['id_card_number'])->where('user_id','!=',$user_id)->count();
            if($checkIdCard > 0){
                //身分證重複
                return redirect('/users')->with('id_card_error', true);
            }
        }
        if( $request->check_token != $mobile_check_token){
            //驗證碼錯誤
            return redirect('/users')->with('check_token', 'Profile updated!');
        }else if( $check_time > 300){
            //驗證碼過期
            return redirect('/users')->with('check_time', 'Profile updated!');
        }else{
            $user_model = User::find($user_id);

            if(Auth::user()->user_state != 1){
                $max = config('fileSizeLimit.users_info_id_file') * 1024;
                $rules = [
                    'id_front_file_name' => 'mimes:jpeg,jpg,png|required|max:'.$max,
                    'id_back_file_name' => 'mimes:jpeg,jpg,png|required|max:'.$max,
                ];
                $messages = [
                    'id_front_file_name.required' => '照片必填',
                    'id_back_file_name.required' => '照片必填',
                    'id_front_file_name.mimes' => '照片格式錯誤',
                    'id_back_file_name.mimes' => '照片格式錯誤',
                ];
                $validator = Validator::make($request->all(),$rules,$messages);

                if($validator->fails()){

                    $data['user'] = User::where('user_id',$user_id)->first();
                    if($data['user']->user_state <= 0 || $data['user']->user_state == 3){
                        $data['userPictureAttr'] = 'required';
                    }else{
                        $data['userPictureAttr'] = 'disabled';
                    }
                    $data['id_fail'] = true;
                    // return view('Front_End.user_manage.users_info.users_info_panel',$data);
                    return redirect('/users')->with('photoError',true);
                }

                $row_data['user_name'] = $request->user_name;
                $row_data['id_card_number'] = $request->id_card_number;
                $row_data['birthday'] = $request->birthday;

                $row_data['residence_country'] = $request->residence_country;
                $row_data['residence_district'] = $request->residence_district;
                $row_data['residence_address'] = $request->residence_address;
                $row_data['phone_number'] = $request->phone_number;

                $row_data['user_state'] = '2';
                $row_data['id_front_file_name']  = $this->StoreImg($request, 'id_front_file_name');
                $row_data['id_back_file_name']  = $this->StoreImg($request, 'id_back_file_name');
                $row_data['id_front_updated_at'] = date('Y-m-d H:i:s');
                $row_data['id_back_updated_at'] = date('Y-m-d H:i:s');

                $row_data['phone_number'] = $request->phone_number;
                $row_data['contact_country'] = $request->contact_country;
                $row_data['contact_district'] = $request->contact_district;
                $row_data['contact_address'] = $request->contact_address;
                $row_data['confirmation_sent_at'] = $user_form_send_time;

                $row_data['updated_at'] = date('Y-m-d H:i:s');

                $user_model->update($row_data);
                $data['add_success'] = true;
                $this->sendUserConfirmMailToAdmin($row_data['user_name']);
            }else{
                
                $row_data['phone_number'] = $request->phone_number;
                $row_data['contact_country'] = $request->contact_country;
                $row_data['contact_district'] = $request->contact_district;
                $row_data['contact_address'] = $request->contact_address;
                $row_data['confirmation_sent_at'] = $user_form_send_time;
                $row_data['updated_at'] = date('Y-m-d H:i:s');
                $user_model->update($row_data);
                $data['add_success'] = true;
            }
            
        }

        //20200304 Jason 修改

        $data['user'] = User::where('user_id',$user_id)->first();
        if($data['user']->user_state <= 0 || $data['user']->user_state == 3){
            $data['userPictureAttr'] = 'required';
        }else{
            $data['userPictureAttr'] = 'disabled';
        }

        return redirect('/users')->with('submitSuccess', true);
        // return view('Front_End.user_manage.users_info.users_info_panel',$data);
    }

    //使用者 提交審核 寄信給所有PP Admin人員
    public function sendUserConfirmMailToAdmin($user_name)
    {
        $data = DB::SELECT("SELECT u.email,u.user_id FROM admin_lv_log a_l_l , users u WHERE u.user_id = a_l_l.user_id  and a_l_l.a_l_l_seq = 5 and u.user_id = 1");
        foreach ($data as $key => $value) {
            
            $title = 'PPonline-使用者審核提交通知';
            $ctx = ['親愛的系統管理員',
                '會員'.$user_name.'先生/女士，已完成個人真實資料，請速至系統審核。'
                ];
                
            $m = new MailTo;
            $m->send_template($value->email, $title, $ctx);
            // Mail::to(trim($v->email))->send(new SampleMail($ctx, $from, $title));
            $this->saveInbox($value->user_id, $title, $ctx);
                    
                
        }

    }

    public function saveInbox($user_id,$title,$ctx)
    {
        $InboxLetters = new InboxLetters;
        $InboxLetters->user_id = $user_id;
        $InboxLetters->title = $title;
        $content = '';
        foreach($ctx as $v){
            $content .= $v;
        }
        $InboxLetters->content = $content;
        $InboxLetters->created_at = date('Y-m-d H:i:s');
        $InboxLetters->updated_at = date('Y-m-d H:i:s');
        $InboxLetters->save();
    }

    //存圖片
    public function StoreImg($req, $file)
    {
        $id = Auth::user()->user_id;
       
        $fileName = 'id_'.$id.'.jpg';

        list($width, $height) = getimagesize($req->file($file));
        $new_width = 1400 ;
        $new_height = $height * ($new_width/$width) ;
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = $this->convertImage($req->file($file));
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagejpeg($image_p,'../images/'.$file.'/'.$fileName);
        
        $FilePath = 'uploads/User_Id_Photo/id_'.$id. '.jpg';
        
        return $FilePath;
    }

    public function convertImage($originalImage)
    {
        // jpg, png, gif or bmp?
        // $exploded = explode('.', $originalImage);
        // $ext = $exploded[count($exploded) - 1];

        $info = getimagesize($originalImage);
        $ext = $info['mime'];

        if (preg_match('/jpg|jpeg/i', $ext)) {
            $imageTmp=imagecreatefromjpeg($originalImage);
        } elseif (preg_match('/png/i', $ext)) {
            $imageTmp=imagecreatefrompng($originalImage);
        } elseif (preg_match('/gif/i', $ext)) {
            $imageTmp=imagecreatefromgif($originalImage);
        } elseif (preg_match('/bmp/i', $ext)) {
            $imageTmp=imagecreatefrombmp($originalImage);
        } else {
            return 0;
        }

        // // quality is a value from 0 (worst) to 100 (best)

        // imagejpeg($imageTmp, $outputImage, $quality);
        // imagedestroy($imageTmp);

        return $imageTmp;
    }
/*
    //去副檔名 並且 重新命名
    public function Del_deputy_file_name($file)
    {
        $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
        $fileName = $num . $file;
        $secondFileName = explode('.',$fileName)[1];

        $fileName = md5($fileName).'.'.$secondFileName;
        return $fileName;
    }
*/

    public function sendPhoneMsg(Request $request)
    {
        //搜尋時間離現在24小時以內的發送次數
        //搜尋時間離現在五分鐘以內的發送次數
        //當離現在五分鐘以內發送次數在兩次以內(不包含兩次)且離現在24小時以內的發送次數在10次以內(不包含10次)
        //上述幾點綁user_id/created_at sms_count=>phone_number
        $log_sms = DB::select("select * from `log_sms` where user_id = '".Auth::user()->user_id."' and created_at >= ADDDATE('".date("Y-m-d H:i:s")."',INTERVAL -24 hour) ");

        $log_sms2 = DB::select("select * from `log_sms` where user_id = '".Auth::user()->user_id."' and created_at >= ADDDATE('".date("Y-m-d H:i:s")."',INTERVAL -5 minute) ");
        //t => 0  初始值 ,t => 1 正常流程 
        $t = 0;

        if(count($log_sms2) < 2 && count($log_sms) < 10){
            DB::insert("INSERT INTO `log_sms` (user_id,user_ip,phone_number,created_at,updated_at) VALUES (?,?,?,?,?)",[Auth::user()->user_id,$request->ip(),$request->phone_number,date('Y-m-d H:i:s'),date('Y-m-d H:i:s')]);
            $t = 1;
        }
        if($t == 1){
            $seed = array(0,1,2,3,4,5,6,7,8,9);
            $str = '';
    
            for($i=0;$i<6;$i++) {
                $rand = rand(0,count($seed)-1);
                $temp = $seed[$rand];
                $str .= $temp;
                unset($seed[$rand]);
                $seed = array_values($seed);
            }
    
    
            $config = [
                [
                    'phone'=> $request->phone_number,
                    'ctx' => '您好，豬豬在線手機驗證碼為：'.$str.'，請輸入後再行提交，謝謝。'
                ]
            ];
    
            $sms = (new sendSMS($config))->run();
        }else{
            $sms = false;
        }
        

        if($sms){

            $user_id = Auth::user()->user_id;

            $row_data['mobile_check_token'] = $str;
            $row_data['mobile_check_token_sent_at'] = date('Y-m-d H:i:s');

            DB::table('users')->where('user_id',$user_id)->update($row_data);

            $return_data['success'] = true;

        }else{

            $return_data['error'] = true;
        }
        return response()->json($return_data);
    }


}
