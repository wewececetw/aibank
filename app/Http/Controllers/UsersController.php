<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\User;
use App\UserBank;
use App\SystemVariables;
use App\Exports\UsersExport;
use App\CustomSettings;
use App\Http\Controllers\Controller;
use App\Mail\MailTo;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use Lang;
use App\InboxLetters;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{

    public function index(User $user){

        $data['row'] = $user;
        $data['stateArray'] = Lang::get('user_state');
        $data['identityArray'] = Lang::get('user_identity');

        return view('Back_End.users.users_panel',$data);

    }
    public function rowDetail(){
        $stateArray = Lang::get('user_state');
        $identityArray = Lang::get('user_identity');

        $users_count = User::from('users as u')
                        ->select('u.*')
                        ->groupBy('user_id')
                        ->orderBy('user_id','asc')
                        ->get();
        $page_count = ceil(count($users_count)/25);
        //
        // $datasets = User::orderBy('user_id','asc')->get()->toArray();
        $datasets = User::from('users as u')
                    ->select('u.*')
                    ->groupBy('user_id')
                    ->orderBy('user_id','asc')->skip(0)->take(25)
                    ->get()
                    ->toArray();
        foreach ($datasets as $key => $value) {
            if(isset($stateArray[$value['user_state']])){
                $datasets[$key]['user_state'] = $stateArray[$value['user_state']];
            }
            if(isset($identityArray[$value['user_identity']])){
                $datasets[$key]['user_identity'] = $identityArray[$value['user_identity']];
            }
            $datasets[$key]['btn'] = [
                'id' =>  $datasets[$key]['user_id'],
                'banned' => $datasets[$key]['banned']
            ];
        }
        $res = ['data'=>$datasets,'page_count'=>$page_count];

        return response()->json($res);
    }

    public function combineSQL($req)
    {
        $model = new User;
        $model = $model->from('users as u')
                    ->select('u.*')
                    ->leftJoin('company_user', 'u.user_id', '=', 'company_user.user_id')
                    ->groupBy('user_id');
        $search = [];
        foreach ($req as $key => $value) {
            $search[$key] = $value;
            if($value == true && $key == 'company_name'){
                $model = $model->where('company_name','is not',null);
            }elseif(isset($value) && $key != 'company_name'){
                $model = $model->where($key,'like','%'.$value.'%');
            }
        }
        return [
            'search' => $search,
            'model' => $model
        ];

    }

    public function search_export(Request $req)
    {
        $download = ((isset($req->download)))?true:false;

        //紀錄排序
        $sequence = $req->all()['sequence'];
        //紀錄一頁幾筆
        $number_page = $req->all()['number_page'];

        
        if(empty($number_page)){
            $number_page = 25;
        }

        $page = 0;
        if(!empty($req->all()['page'])){
            $page = $req->all()['page']-1;
            $page = $page * $number_page; 
        }

        $req_data =  $req->except(['sequence','number_page','page']);
        // $combine = $this->combineSQL($req_data);
        $req_count = 0;
        $sql_detail = '';
        foreach ($req_data as $k => $v){
            if(isset($v)){
                if($k != 'company_name'){
                    $sql_detail .= " and $k Like '%$v%'";
                }elseif($k == 'company_name' ){
                    $sql_detail .= " and (SELECT count(*) FROM company_user cu WHERE cu.user_id = u.user_id) = $v";
                }
                $req_count++;
                if($req_count == 1){
                    $sql_detail = str_replace("and","",$sql_detail); 
                 }
            }
            
        }

        
        // $model = $combine['model'];
        // $search = $combine['search'];
        

        //暫時存取查詢結果以記頁數
        // $page_sql = $model;
        // $page_count = DB;

        $identityArray = Lang::get('user_identity');
        $stateArray = Lang::get('user_state');
        // $data = $model->get();
        if(empty($sequence)){
            $order_data = 'ORDER BY user_id asc';
        }elseif($sequence == 1){
            $order_data = 'ORDER BY member_number asc';
        }elseif($sequence == -1){
            $order_data = 'ORDER BY member_number desc';
        }elseif($sequence == 2){
            $order_data = 'ORDER BY user_name asc';
        }elseif($sequence == -2){
            $order_data = 'ORDER BY user_name desc';
        }elseif($sequence == 3){
            $order_data = 'ORDER BY id_card_number asc';
        }elseif($sequence == -3){
            $order_data = 'ORDER BY id_card_number desc';
        }elseif($sequence == 4){
            $order_data = 'ORDER BY is_alert asc';
        }elseif($sequence == -4){
            $order_data = 'ORDER BY is_alert desc';
        }elseif($sequence == 5){
            $order_data = 'ORDER BY user_identity asc';
        }elseif($sequence == -5){
            $order_data = 'ORDER BY user_identity desc';
        }elseif($sequence == 6){
            $order_data = 'ORDER BY science_professionals asc';
        }elseif($sequence == -6){
            $order_data = 'ORDER BY science_professionals desc';
        }elseif($sequence == 7){
            $order_data = 'ORDER BY user_state asc';
        }elseif($sequence == -7){
            $order_data = 'ORDER BY user_state desc';
        }
        if(!empty($sql_detail)) {
            $sql_detail = 'WHERE '.$sql_detail;
        }
        $page_count = DB::select("SELECT * FROM users u $sql_detail");
        if($download){
            //下載
            $users_export = $this->excelData($page_count);
            $myFile = Excel::download( new UsersExport($users_export), '匯出會員資料_'.date('Y-m-d').'.csv');

            return $myFile;
        }else{
            // return $sql_detail;
            $data = DB::select("SELECT * FROM users u $sql_detail limit $page,$number_page");
            //搜尋
            $res['data'] = [];
            foreach($data as $k=> $v)
            {
                if($v->is_alert==0){
                    $is_alert = '否';
                }else{
                    $is_alert = '是';
                }
                $ar = [];
                $ar['email'] = $v->email;
                $ar['sign_in_count'] = $v->sign_in_count;
                $ar['current_sign_in_at'] = $v->current_sign_in_at;
                $ar['contact_country'] = $v->contact_country;
                $ar['contact_district'] = $v->contact_district;
                $ar['contact_address'] = $v->contact_address;
                $ar['residence_country'] = $v->residence_country;
                $ar['residence_district'] = $v->residence_district;
                $ar['residence_address'] = $v->residence_address;
                $ar['birthday'] = $v->birthday;
                $ar['member_number'] = $v->member_number;
                $ar['user_id'] = $v->user_id;
                $ar['user_name'] = $v->user_name;
                $ar['user_type'] = $v->user_type;
                $ar['id_card_number'] = $v->id_card_number;
                $ar['phone_number'] = $v->phone_number;
                $ar['passport_number'] = $v->passport_number;
                $ar['approved_at'] = $v->approved_at;
                $ar['is_alert'] = $is_alert;
                $ar['user_identity'] = (isset($identityArray[$v->user_identity])) ? $identityArray[$v->user_identity] : $v->user_identity;
                $ar['science_professionals'] = $v->science_professionals;
                $ar['user_state'] = (isset($stateArray[$v->user_state])) ? $stateArray[$v->user_state] : $v->user_state;
                $ar['is_user_id_check'] = $v->is_user_id_check;
                $ar['btn'] = [
                    'id' => $v->user_id,
                    'banned' => $v->banned,
                ];

                array_push($res['data'],$ar);
            }
            //計算頁數
            $res{'count'} = ceil(count($page_count)/$number_page) ;
            //  dd($res);

            return response()->json($res);
        }
    }

    public function excelData($users)
    {
        $users_export = [
            ['會員編號',
             '姓名',
             '會員類型',
             '身分證字號',
             '護照號碼',
             '開通日',
             '個資審核',
             '銀行帳戶審核',
             'Email',
             '登入次數',
             '現在登入狀態開始於',
             '通訊地址',
             '戶籍地址',
             '電話',
             '出生日期'
             ]
        ];
        foreach($users as $row)
        {
            $contact_address = $row->contact_address;
            $contact_district = $row->contact_district;
            $contact_country = $row->contact_country;
            $residence_address = $row->residence_address;
            $residence_district = $row->residence_district;
            $residence_country = $row->residence_country;
            $contact = $contact_country.$contact_district. $contact_address;
            $residence = $residence_country.$residence_district. $residence_address;

            $ar = [$row->member_number,
                   $row->user_name,
                   $row->user_type,
                   $row->id_card_number,
                   $row->passport_number,
                   $row->approved_at,
                   $row->is_user_id_check,
                   $row->is_user_id_check,
                   $row->email,
                   $row->sign_in_count,
                   $row->current_sign_in_at,
                   $contact,
                   $residence,
                   "'".$row->phone_number,
                   $row->birthday
                ];
            array_push($users_export,$ar);

        }
        return $users_export;
    }
    public function user_bank_confirm(Request $req)
    {
        try {
            $model = UserBank::find($req->user_bank_id);
            $model->state = $req->state;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail'
            ]);
        }

    }
    public function users_details(User $user )
    {
        $data['row'] = $user;
        $user_id = $user->user_id;
        $data['asd'] = User::where('user_id',$user_id)->get();

        $data['company_user'] = DB::select('SELECT * FROM company_user WHERE user_id = ?',[$user_id]);

        $data['userBank'] = DB::table('user_bank')
                ->from('user_bank as ub')
                ->leftJoin('bank_lists as bl','bl.bank_id','=','ub.bank_id')
                ->where('ub.user_id',$user_id)
                ->get()
                ->toArray();

        $cfit = $user->come_from_info_text;

        if(isset($cfit)){

            $data['recommend'] = User::select('member_number','user_name')
                                ->from('users as u')
                                ->where('u.recommendation_code',$cfit )
                                ->first();
        }

        $re_code = $user->recommendation_code;

        if(isset($re_code)){

            $data['recommend_count']= DB::select('
            SELECT
                count(user_id) as c
            FROM
                users
            WHERE
                come_from_info_text =(
            SELECT
                recommendation_code
            FROM
                users
            WHERE
                user_id = '.$user_id.')
            ');
        }
        $check = CustomSettings::where('user_id', $user_id)->get();
        if(count($check)>0){
            $check = CustomSettings::where('user_id', $user_id)->first()->toArray();
            $roi_setting_id = $check['roi_setting_id'];
            $state = ['1'=>'穩重謹慎型',
                    '2'=>'積極進取型',
                    '3'=>'穩健平衡型',
                    '4'=>'穩健積極型',
                    '5'=>'足智多謀型',
                ];
            $data['roi_setting_id'] = $state[$roi_setting_id];  
        }
        

        $data['invest_info'] = (new User)->countUserMoneyInfo($user_id);
        $invest_info = $data['invest_info'];

        $total_invest = str_replace(',','',(string)$invest_info['total_invest']);
        $total_income = str_replace(',','',(string)$invest_info['total_income']);
        $data['invest_info']['total'] = number_format((float)$total_invest+(float)$total_income);

        // if(count($data['total_amount']) == 0){
        //     $data['total_amount'] = [['total_amount' => 0]];
        // }
        // if(count($data['total_impleintrest']) == 0){
        //     $data['total_impleintrest']['total_impleintrest']=0;
        // }
        // if(count($data['total_import']) == 0){
        //     $data['total_import'] =  [['total_import' => 0]];
        // }

        return view('Back_End.users.user_details',$data);
    }

    public function users_edit(User $user)
    {
        $data['row'] = $user;
        return view('Back_End.users.user_edit',$data);
    }

    public function users_update(User $user, Request $request)
    {
        $user->user_id = $request->user_id;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->id_card_number = $request->id_card_number;
        $user->passport_number = $request->passport_number;
        $user->contact_address = $request->contact_address;
        $user->contact_country = $request->contact_country;
        $user->contact_district = $request->contact_district;
        $user->residence_address = $request->residence_address;
        $user->residence_district = $request->residence_district;
        $user->residence_country = $request->residence_country;
        $user->birthday = $request->birthday;
        $user->phone_number = $request->phone_number;
        $user->note = $request->note;
        $user->updated_at = date('Y-m-d H:i:s');

        if(isset($request->id_front_file_name)){
            $user->id_front_file_name  = $this->StoreImg($request, 'id_front_file_name', $user->user_id);
        }

        if(isset($request->id_back_file_name)){
            $user->id_back_file_name  = $this->StoreImg($request, 'id_back_file_name', $user->user_id);
        }


        $user->save();
        $return_data['success'] = true;
        return response()->json($return_data);
    }

    //存圖片
    public function StoreImg($req, $file , $id)
    {
        
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

    // //存正面圖片
    // public function front_StoreImg($req, $file,$user_id)
    // {   
    //     $file = $this->get_file_data($user_id);
    //     for($i=0;$i<1000;$i++){
    //         count(glob(public_path("uploads/User_Id_Photo/$file_page").'/*.*'));
    //     }
    //     if(\File::isDirectory(public_path("uploads/User_Id_Photo/"))){

    //     }
    //     $fileName = $this->Del_deputy_file_name($req->file($file)->getClientOriginalName());
    //     $path = Storage::disk('public_uploads')->putFileAs('User_Id_Photo/' . date("Ymd"), new File($req->file($file)), $fileName);
    //     $FilePath = 'uploads/User_Id_Photo/' .date("Ymd") . '/' . $fileName;
    //     return $FilePath;
    // }

    // //存圖片
    // public function back_StoreImg($req, $file,$user_id)
    // {
    //     /*
    //     $fileName = $this->Del_deputy_file_name($req->file($file)->getClientOriginalName());
    //     $path = Storage::disk('public_uploads')->putFileAs('User_Id_Photo/' . date("Ymd"), new File($req->file($file)), $fileName);
    //     $FilePath = 'uploads/User_Id_Photo/' .date("Ymd") . '/' . $fileName;
    //     */
    //     $id = Auth::user()->user_id;
    //     $FilePath = 'uploads/User_Id_Photo'.$req.'/id_'.$id. '.jpg';
    //     //$path = Storage::disk('public_uploads')->putFileAs('User_Id_Photo/id_'.$id.'.jpg');

    //     $fileName = 'id_'.$id.'.jpg';
        
    //     //$path = Storage::disk('public_uploads')->put('User_Id_Photo/'.$file.'/'.$fileName,$file);
    //     $path = Storage::disk('public_uploads')->putFileAs('User_Id_Photo/'.$file, new File($req->file($file)),  $fileName);

    //     return $FilePath;
    // }

    public function get_file_data($user_id){

        $int_user_id = (int)$user_id;
        $st_user_id = (string)$user_id;
        if(strlen($st_user_id) < 4){
            
            $file['file_page'] = '000';

        }elseif(strlen($st_user_id) < 5 && strlen($st_user_id) == 4){

            $file['file_page'] = '00'.substr($st_user_id, 1);

        }elseif(strlen($st_user_id) < 6 && strlen($st_user_id) == 5){

            $file['file_page'] = '0'.substr($st_user_id, 2);

        }elseif(strlen($st_user_id) < 7 && strlen($st_user_id) == 6){

            $file['file_page'] = substr($st_user_id, 3);

        }


        if(strlen($st_user_id) < 4){
            
            $file['file_name'] = str_pad($st_user_id, 3, "0", STR_PAD_LEFT);

        }else{

            $file['file_name'] = substr($st_user_id, -3);

        }
        if(strlen($st_user_id) < 7){
            $file['file_top_name'] = '000';
        }
        return $file; 
    }

    //去副檔名 並且 重新命名
    public function Del_deputy_file_name($file)
    {
        $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
        $fileName = $num . $file;
        $secondFileName = explode('.',$fileName)[1];

        $fileName = md5($fileName).'.'.$secondFileName;
        return $fileName;
    }





    public function users_banned(Request $request)
    {
        $id = $request->id;
        $data['row'] = DB::table('users')->where('user_id',$id)->first();
        $row_data['banned'] = !($data['row']->banned);
        DB::table('users')->where('user_id',$id)->update($row_data);
        $return_data['success'] = true;

        return response()->json($return_data);
    }

    public function users_is_alert(Request $request)
    {
        $id = $request->id;
        $data['row'] = DB::table('users')->where('user_id',$id)->first();
        $row_data['is_alert'] = !($data['row']->is_alert);
        DB::table('users')->where('user_id',$id)->update($row_data);
        $return_data['success'] = true;

        return response()->json($return_data);
    }

    public function users_super_pusher(Request $request)
    {
        $id = $request->id;
        $data['row'] = DB::table('users')->where('user_id',$id)->first();
        $row_data['is_super_pusher'] = !($data['row']->is_super_pusher);
        DB::table('users')->where('user_id',$id)->update($row_data);
        $return_data['success'] = true;

        return response()->json($return_data);
    }

    public function users_user_state(Request $request)
    {

        $id = $request->id;
        $user = User::find($id);
        $approved_at = $user->approved_at;
        $member_number = $user->member_number;

        $checkCustomSet = CustomSettings::where('user_id',$user->user_id)->get();

        $row_data['user_state'] =  $request->state;

            // 如果user_state狀態是1時
            if($request->state == 1){

                $m = new MailTo;
                $m->pp_member_review($user->user_id);

                if(!isset($approved_at)){
                    if(isset($member_number)){

                        // 虛擬帳戶
                        $member_number_t = ltrim($member_number,'P');
                        $virtual_account  = '61607000'.$member_number_t;
                    
                    }else{
                        $current_member_num = SystemVariables::where('variable_name','current_member_number')->first();
                        $current_mem_num  = $current_member_num->value;

                        // 限制member_ntmber字長 用substr取需要的長度範圍
                        $m = '00000'.$current_mem_num;

                        $current_m = substr($m, -6);
                        $member_num = 'P'.$current_m ;

                        // 虛擬帳戶
                        $virtual_account  = '61607000'.$current_m;

                        $row_data['member_number'] = $member_num;

                        $current_num['value'] = $current_mem_num+1;
                        SystemVariables::where('variable_name','current_member_number')->update($current_num);

                    }


                    $row_data['virtual_account'] = $virtual_account;
                    $row_data['approved_at'] = date('Y-m-d H:i:s');                    

                }

                if(count($checkCustomSet) == 0){
                    /* ========= 2020-03-19 18:05:25 change by Jason ========= */
                    (new CustomSettings)->createUserDefaultSettings($user->user_id);
                }


                $this->id_front_watermark($id);
                $this->id_back_watermark($id);

                


            }elseif($request->state < 0){

                if($request->state == -4){
                    //寄駁回信給使用者
                    $this->sendConfirmFailMailToUser($id,$request->state,$request->other);
                }else{
                    //寄駁回信給使用者
                    $this->sendConfirmFailMailToUser($id,$request->state);
                }
                    

            }

        // 更新user_state狀態
        $user->update($row_data);

        $return_data['success'] = true;

        return response()->json($return_data);
    }


    public function id_front_watermark($id){

        $this->watermark("../images/id_front_file_name/id_$id.jpg",'images/check_id.png',"../images/id_front_watermark/id_$id.jpg");

    }

    public function id_back_watermark($id){

        $this->watermark("../images/id_back_file_name/id_$id.jpg",'images/check_id.png',"../images/id_back_watermark/id_$id.jpg");


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

    public function watermark($from_filename, $watermark_filename, $save_filename)
    {
        $allow_format = array('jpeg', 'png', 'gif');
        $sub_name = $t = '';

        // 原圖
        $img_info = getimagesize($from_filename);
        $width    = $img_info['0'];
        $height   = $img_info['1'];
        $mime     = $img_info['mime'];

        list($t, $sub_name) = explode('/', $mime);
        if ($sub_name == 'jpg') {
            $sub_name = 'jpeg';
        }

        if (!in_array($sub_name, $allow_format)) {
            return false;
        }

        $function_name = 'imagecreatefrom' . $sub_name;
        $image     = $function_name($from_filename);

        // 浮水印
        $img_info = getimagesize($watermark_filename);
        $w_width  = $img_info['0'];
        $w_height = $img_info['1'];
        $w_mime   = $img_info['mime'];

        list($t, $sub_name) = explode('/', $w_mime);
        if (!in_array($sub_name, $allow_format)) {
            return false;
        }

        $function_name = 'imagecreatefrom' . $sub_name;
        $watermark = $function_name($watermark_filename);
    
   
        $watermark_pos_x = ($width/2)  ;
    
        // if (($height/2)<$w_height) {
        //     $watermark_pos_y = $height - ($w_height/2);
        // }else{
        $watermark_pos_y = ($height/2);
        // $watermark_pos_y = ($height/2) - ($w_height/2);
        // }
    

        // imagecopymerge($image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, $w_width, $w_height, 100);

        // 浮水印的圖若是透明背景、透明底圖, 需要用下述兩行
        imagesetbrush($image, $watermark);
        imageline($image, $watermark_pos_x, $watermark_pos_y, $watermark_pos_x, $watermark_pos_y, IMG_COLOR_BRUSHED);

        return imagejpeg($image, $save_filename);
    }

    //使用者 提交審核 寄信給所有PP Admin人員
    public function sendConfirmFailMailToUser($user_id,$state,$other='')
    {
        $user = User::find($user_id);
        $st = (isset(Lang::get('user_state')[$state])) ? Lang::get('user_state')[$state] : '神秘的原因';
        
        if(strlen($other) > 0){ $st=''; }
        
        if(isset($user->email)){
            $user_name = (isset($user->user_name))? $user->user_name : '';
            $from = false;
            $title = 'PPonline-通知';
/*
            $ctx = ['親愛的'.$user_name.'會員，您好',
                    '您的個人真實資訊審核未通過，因'.$st.$other.'未審核通過，請您至「會員中心」修改。',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://testphp.pponline.com.tw'>點擊前往官方網站</a>"
                    // '因'.$st.'未審核通過，',
                    // '請您至「會員中心」修改。',
                    ];
*/
            $ctx = ['親愛的'.$user_name.'會員，您好',
                    '您的個人真實資訊審核未通過，因'.$st.$other.'未審核通過，請您至「會員中心」修改。',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                    // '因'.$st.'未審核通過，',
                    // '請您至「會員中心」修改。',
                    ];
            $ctx2 = [
                    '您的個人真實資訊審核未通過，因'.$st.$other.'未審核通過，請您至「會員中心」修改。'
                    ];
            $mailTo = [$user];
            foreach ($mailTo as $v) {
                $canMail = $this->checkUserCanReciveMail($v->email);
                if($canMail){
                    // Mail::to(trim($v->email))->send(new SampleMail($ctx,$from,$title));
                    $m = new MailTo;
                    $m->send_template($v->email, $title, $ctx);
                    $this->saveInbox($v->user_id,$title,$ctx);

                    $m = new MailTo;
                    $content = '';
                    
                    foreach ($ctx2 as $k){
                        $content .= "<p>".$k."</p>";
                    }
                    $m->send_inside_mail_for_log($v->user_id, $title, $content);//站內信
                    
                }
            }
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

    //更改 接收郵件狀態
    public function letterChange(Request $req ,User $user)
    {
        try {
            if ($user->is_receive_letter_type == 1) {

                return response()->json(['status'=>'type_error']);

            } else {

                $user->is_receive_letter = $req->letter;
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
                return response()->json(['status'=>'success']);

            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error']);
        }
    }

    //更改 不接收訊息狀態
    public function letter_type_Change(Request $req ,User $user)
    {
        try {
            $user->is_receive_letter_type = $req->letter_type;
            if ($req->letter_type == 1){
                $user->is_receive_letter = 0;
            }
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();
            return response()->json(['status'=>'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>'error']);
        }
    }

    public function update_cfit(Request $req){

        $id = $req->id;
        $user = User::find($id);


        $data['come_from_info_text'] = $req->cfit;
        $data['come_from_info_text_created_at'] = date('Y-m-d H:i:s');


        $user->update($data);


        $return_data['success'] = true;
        return response()->json($return_data);

    }

    public function update_s_p(Request $req){

        $id = $req->id;
        $user = User::find($id);


        $data['science_professionals'] = $req->s_p;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $user->update($data);


        $return_data['success'] = true;
        return response()->json($return_data);

    }

    public function update_u_id(Request $req){

        $id = $req->id;
        $user = User::find($id);


        $data['user_identity'] = $req->u_id;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $user->update($data);


        $return_data['success'] = true;
        return response()->json($return_data);

    }

    public function update_cn(Request $req){

        $id = $req->id;
        $user = User::find($id);

        DB::insert('INSERT INTO `company_user`(`user_id`, `company_name`, `create_at`) VALUES (?,?,?)',[$user->user_id,$user->user_name,date('Y-m-d H:i:s')]);

        $return_data['success'] = true;
        return response()->json($return_data);

    }

    public function user_discount_download(){

        $file = public_path() . "/downloadable/手續費優惠範例.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );

        return response()->download($file, '手續費優惠範例.xlsx', $headers);
    }

    public function user_discount_import(Request $request){
        $fileTypeName = $request->file('select_file')->getClientOriginalExtension();
        if ($fileTypeName != 'xlsx' && $fileTypeName != 'xls') {
            return Redirect::back()->withErrors(['您所匯入的檔案格式錯誤']);
        }
        $toArray = Excel::toArray(new UsersImport, request()->file('select_file'));
        DB::beginTransaction();
        try
        {
            foreach ($toArray[0] as $k => $v) {
                if ($k != 0) {
                    if($v[0] != '' && $v[1] !== '' && $v[2] != '' && $v[3] != ''){
                        if( $v[1] <= 1 ){
                            if ($v[1] >= 0) {
                                $discount_start = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[2]));
                                $discount_close = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($v[3]));
                                $update = DB::update('UPDATE users SET discount = ? , discount_start = ? , discount_close = ? WHERE member_number = ?', [$v[1],$discount_start,$discount_close,$v[0]]);
                                $users = User::where('member_number', $v[0])->first();
                                if (!empty($update)) {
                                    DB::insert('INSERT INTO `log_user_discount`(`user_id`, `discount`, `discount_start`, `discount_close`, `insert_date`) VALUES (?,?,?,?,?)', [$users->user_id,$v[1],$discount_start,$discount_close,date('Y-m-d H:i:s')]);
                                }
                            }else{
                                DB::rollback();
                                return Redirect::back()->withErrors(['手續費優惠比例不可低於0%']);
                            }
                        }else{
                            DB::rollback();
                            return Redirect::back()->withErrors(['手續費優惠比例不可超過100%']);
                        }
                    }else{
                        DB::rollback();
                        return Redirect::back()->withErrors(['有欄位為空白']);
                    }
                }
            }
            DB::commit();
        return redirect('/admin/users')->with('import_success');
        } catch (\Throwable $th) {
            $this->logg('Error',["ERROR MSG" => $th]);
            DB::rollback();
            return Redirect::back()->withErrors(['會員'.$v[0].'內容有誤']);
        }


    }
    // public function update_d_c(Request $req){

    //     $id = $req->id;
    //     $user = User::find($id);

    //     DB::update('UPDATE users SET discount = ? WHERE user_id = ? ',[$req->d_c,$req->id]);

    //     $return_data['success'] = true;
    //     return response()->json($return_data);

    // }

}
