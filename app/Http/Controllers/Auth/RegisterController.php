<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;
use App\SystemVariables;
use App\User;
use App\InboxLetters;
use App\Match;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use App\Mail\MailTo;
use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Support\Str;
use DB;
use Log;
use App\UsersRoles;
use App\Web_contents;
use Carbon\Carbon;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(isset($data['come_from_info_text'])){
            return User::create([
                'email' => $data['email'],
                'user_name' => $data['user_name'],
                'phone_number' => $data['phone'],
                'confirmation_token' => Str::random(20),
                'encrypted_password' => Hash::make($data['encrypted_password']),
                'come_from_info' => $data['come_from_info'],
                'come_from_info_text' => $data['come_from_info_text'],
            ]);
        }else{
            return User::create([
                'email' => $data['email'],
                'user_name' => $data['user_name'],
                'phone_number' => $data['phone'],
                'confirmation_token' => Str::random(20),
                'encrypted_password' => Hash::make($data['encrypted_password']),
                'come_from_info' => $data['come_from_info'],
            ]);
        }

    }

/*
    public function tokenDecode($content){
       $token = '1234567891234567';
       $iv = substr($token, 0, 16);
        if(!empty($content)){
            return openssl_decrypt(
                str_replace("","+",$content),
                "AES-256-CBC",
                $token,
                0,
                $iv
            );
        }
    }
   public function tokenEncode($content){
       $token = '1234567891234567';
        $iv = substr($token, 0, 16);
        return openssl_encrypt(
            $content,
            "AES-256-CBC",
            $token,
            0,
            $iv
        );
   }
*/

    public function postRegistration(Request $request)
    {
        $data = $request->all();
        $data = $this->comeFromInfoCheck($data);
        $email = $data['email'];
        $confirm = User::where('email',$email)->get();
        if($data['comeFromCheck'] === true){
            unset($data['comeFromCheck'] );
        }else if($data['comeFromCheck'] === 'NoCode'){
            return response()->json(['NoCode' => true]);
        }else{
            return response()->json(['PPcodeError' => true]);
        }
        if((count($confirm)>0) == true){
            $return_data['duplicate'] = true;
        }
        else{
            $check = $this->create($data);
/*
            $content = 'confirmation_token='.$check->confirmation_token;
            $encode = $this->tokenEncode($content);
*/            
            $encode_e = base64_encode($check->email);
            $encode_t = base64_encode($check->confirmation_token);

            $from = false;
            $title = '??????????????????';
/*
            $ctx = ['?????????'.$check->user_name.'???????????????',
                    '??????????????????????????????????????????????????????????????????????????????',
                    'https://www.pponline.com.tw/users/confirmation?t='.$encode,
                    '?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????',
                    '??????????????????????????????????????? 02-55629111??????????????????????????????',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>?????????????????????????????????????????? / ???????????????????????????</span>",
                    "???????????? : (02)5562-9111",
                    "???????????? : service@pponline.com.tw",
                    "??????LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>????????????</a>",
                    "FB?????? : <a href='https://www.facebook.com/pponline888'>????????????????????????</a>",
                    "?????????????????? : <a href='https://www.pponline.com.tw'>????????????????????????</a>"
                ];
*/
                $ctx = ['?????????'.$check->user_name.'???????????????',
                    '???????????????????????????GoldenPiggyBank???????????????????????????????????????????????????<a href = "https://www.pponline.com.tw/users/confirmation?t='.$encode_t.'&q='.$encode_e.'">??????</a>??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????',
                    '??????????????????????????????????????????google?????????????????????',
                    'https://www.pponline.com.tw/users/confirmation?t='.$encode_t.'&q='.$encode_e,
                    '??????????????????????????????????????? 02-55629111??????????????????????????????',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>?????????????????????????????????????????? / ???????????????????????????</span>",
                    "???????????? : (02)5562-9111",
                    "???????????? : service@pponline.com.tw",
                    "??????LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>????????????</a>",
                    "FB?????? : <a href='https://www.facebook.com/pponline888'>????????????????????????</a>",
                    "?????????????????? : <a href='https://www.pponline.com.tw'>????????????????????????</a>"
                ];
            $mailTo = [$check];
            foreach ($mailTo as $v) {
                $user = User::where('email',$v->email)->first();
                $m = new MailTo;
                $m->send_template($v->email, $title, $ctx);
                // Mail::to($v->email)->send(new SampleMail($ctx,$from,$title));
                $this->saveInbox($user->user_id,$title,$ctx);
            }

            $row_data['confirmation_sent_at'] = date('Y-m-d H:i:s');
            DB::table('users')->where('email',$email)->update($row_data);
            $return_data['register'] = true;
        }
        return response()->json($return_data);
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

    public function comeFromInfoCheck($data)
    {
        $come_from_info = $data['come_from_info'];
        switch ($come_from_info) {
            case '0':
            case '1':
                $data['comeFromCheck'] = true;
                break;
            case '2':
            case '3':
            case '4':
            case '5':
                if(!isset($data['come_from_info_text']) && empty($data['come_from_info_text'])){
                    $data['comeFromCheck'] = true;
                }else{
                    $reg = '/^R+([0-9]+\.?[0-9]+\.?[0-9]+\.?[0-9])+PP$/';
                    preg_match($reg,$data['come_from_info_text'],$t);
                    if(count($t) > 0){
                        $data['comeFromCheck'] = true;
                    }else{
                        $data['comeFromCheck'] = false;
                    }
                }
            break;
            default:
                $data['comeFromCheck'] = false;
                break;
        }

        if($data['comeFromCheck'] == true){
            if(!isset($data['come_from_info_text']) && empty($data['come_from_info_text'])){

                if($come_from_info == '0' || $come_from_info == '1'){
                    unset($data['come_from_info_text']);
                }
            }else{
                //????????????
                $c = User::where('recommendation_code',$data['come_from_info_text'])->count();
                if($c == 0){
                    $data['comeFromCheck'] = 'NoCode';
                }
            }

        }
        return $data;
        // if($data['come'])
    }

    public function mailConfirmation(Request $request)
    {
        // try {
        try {
            /*
            $q = str_replace(" ","+" ,$request->all()['t']);
            $decode = $this->tokenDecode($q);
            $token = str_replace('confirmation_token=','',$decode);
            $data['row'] = DB::table('users')->where('confirmation_token',$token)->where('user_state',0)->first();
            */

            $t =base64_decode($request->t);
            $q =base64_decode($request->q);
            $data['row'] = DB::select("select * from users where confirmation_token = '" .$t. "' and email =  '" .$q. "'");
            
            if(isset($data['row'])){
                $d = true;
            }else{
                $d = false;
            }
            if(!empty($data['row'][0]->confirmed_at)){
                $d = false;
            }
            if($d == true){
                
                $current_member_num = SystemVariables::where('variable_name','current_member_number')->first();
                $current_mem_num  = $current_member_num->value;

                // ??????member_ntmber?????? ???substr????????????????????????
                $m = '00000'.$current_mem_num;

                $current_m = substr($m, -6);
                $member_num = 'P'.$current_m ;
                $row_data['member_number'] = $member_num;
                $row_data['user_state'] = 3;
                $row_data['confirmed_at'] = date('Y-m-d H:i:s');
                $row_data['updated_at'] = date('Y-m-d H:i:s');
                DB::table('users')->where('confirmation_token',$t)->where('email',$q)->update($row_data);

                // ????????????????????? current_member_number??????
                $current_num['value'] = $current_mem_num+1;
                SystemVariables::where('variable_name','current_member_number')->update($current_num);
            }

            //??????user_role
            $userData = $this->tokenFindUid($t,$q);
            $userRoleCount = UsersRoles::where('user_id',$userData['user_id'])->count();
            if($userRoleCount > 0){
                // return false;
            }else{
                $this->newUserRole($userData['user_id'],1);
            }


            $datas = Match::where('value_type','=','frontShow')->get();
            $result = array();
            foreach($datas as $data)
            {
                if($data->value_name == 'annualBenefitsRate')
                {
                    $result['annualBenefitsRate'] = $data->value;
                }
                else if($data->value_name == 'memberBenefits')
                {
                    $result['memberBenefits'] = $data->value;
                }
                else if ($data->value_name == 'totalInvestAmount')
                {
                    $result['totalInvestAmount'] = $data->value;
                }
            }
            if($d){$result['emailConfirmSuccess'] = $d;}else{$result['emailConfirmError'] = true;}
            

            $result['news'] = Web_contents::Where(['category' => '10', 'is_active' => '1'])->Orderby('created_at', 'asc')->get();

            $banner = Web_contents::bannerUrlList(1);
            $result['banner'] = [
                url('/banner/img/1.jpg'),
            ];
            $result['banner'] = array_merge($result['banner'],$banner);

            $result['defaultRate_name'] =  Web_contents::categoryDistincName(15);
            $result['defaultRate_data'] = (new Web_contents)->getDefaultRateIndexViewData();

            return view('Front_End.home.panel',$data,$result);
        } catch (\Throwable $th) {
            throw $th;
            $datas = Match::where('value_type','=','frontShow')->get();
            $result = array();
            foreach($datas as $data)
            {
                if($data->value_name == 'annualBenefitsRate')
                {
                    $result['annualBenefitsRate'] = $data->value;
                }
                else if($data->value_name == 'memberBenefits')
                {
                    $result['memberBenefits'] = $data->value;
                }
                else if ($data->value_name == 'totalInvestAmount')
                {
                    $result['totalInvestAmount'] = $data->value;
                }
            }
            $result['emailConfirmSuccess'] = false;

            $banner = Web_contents::bannerUrlList(1);
            $result['banner'] = [
                url('/banner/img/1.jpg'),
            ];
            $result['banner'] = array_merge($result['banner'],$banner);

            $result['defaultRate_name'] =  Web_contents::categoryDistincName(15);
            $result['defaultRate_data'] = (new Web_contents)->getDefaultRateIndexViewData();
            return view('Front_End.home.panel',$data,$result);
        }
    }

    public function tokenFindUid($t,$q)
    {
        $users = User::where('confirmation_token',$t)->where('email',$q)->get()->toArray();
        if(count($users) == 0){
            return false;
        }else{
            return $users[0];
        }
    }

    public function newUserRole($user_id,$role_id)
    {
        $userRole = new UsersRoles;
        $userRole->role_id = $role_id;
        $userRole->user_id = $user_id;
        $userRole->save();
    }
}
