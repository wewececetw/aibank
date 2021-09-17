<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\InboxLetters;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use App\Mail\MailTo;
use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\UsersRoles;



use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    // protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('Front_End.sign_in_panel');
    }


    public function username()
    {
        return 'email';

    }


    protected function authenticated(Request $request)
    {
        try {
            $user_role = UsersRoles::where('user_id',Auth::user()->user_id)->first()->role_id;
        } catch (\Throwable $th) {
            $user_role = false;
        }


        if(isset(Auth::user()->confirmed_at) || $user_role == 2){
                        // if(Auth::user()->user_state ==0){
            //     echo'<script>
            //     alert("請先至信箱點擊驗證信");
            //     </script>';
            // }
            // else{
                session_start();
                $_SESSION['loggedIn'] = true;

            // 取得登入次數
            $sign_in_count = Auth::user()->sign_in_count;
            // 取得登入者id
            $user_id = Auth::user()->user_id;
            $user_ip = request()->ip();

            $current_login_ip =  DB::table('users')->where('user_id',$user_id)->first('current_sign_in_ip');
            $current = get_object_vars($current_login_ip);

            $current_login_time = DB::table('users')->where('user_id',$user_id)->first('current_sign_in_at');
            $current_time = get_object_vars($current_login_time);

            if(!isset($current_time['current_sign_in_at'])){
                $row_data['current_sign_in_at'] =date('Y-m-d H:i:s');
            }
            else{
                $row_data['last_sign_in_at'] =$current_time['current_sign_in_at'];
                $row_data['current_sign_in_at'] =date('Y-m-d H:i:s');
            }


            if(!isset($current['current_sign_in_ip'])){
                $row_data['current_sign_in_ip'] =$user_ip;
            }
            else{
                $row_data['last_sign_in_ip'] =$current['current_sign_in_ip'];
                $row_data['current_sign_in_ip'] =$user_ip;
            }

            $new_sign_in_count =  $sign_in_count + 1;
            $row_data['sign_in_count'] = $new_sign_in_count;

            DB::table('users')->where('user_id',$user_id)->update($row_data);
            if($sign_in_count == 0){
                return redirect('/users');
            }else{
                return redirect('/');
            }
        }else{
            $this->guard()->logout();

            $request->session()->invalidate();

            session_start();
            session_destroy();

            return $this->loggedOut($request) ?: redirect('/users/sign_in')->with('emailConfirm', true);
            // return redirect('/users/sign_in')->with('emailConfirm', true);
            // dd('eee');
        }

    // }
    }

    public function resent_validation()
    {
        return view('Front_End.mail_confirmation_panel');

    }
    public function resent_confirmation(Request $request)
    {
        $email = $request->email;
        $account = User::where('email',$email)->first();

        if(isset($account) == true && $account->user_state ==0)
        {

            // $content = 'confirmation_token='.$account->confirmation_token;
            // $encode = $this->tokenEncode($content);
            $encode_e = base64_encode($account->email);
            $encode_t = base64_encode($account->confirmation_token);

            $from = false;
            $title = '驗證信重發，帳號驗證步驟';
/*
            $ctx = ['親愛的'.$account->user_name.'會員，您好',
                    '已重新發送您的驗證信件，請點擊下方連接開通您的帳號：',
                    'https://testphp.pponline.com.tw/users/confirmation?t='.$encode,
                    '請您繼續至會員專區完成「身份認證」、「銀行帳戶」，即可開始體驗債權投資的魅力。',
                    '如有任何問題，請洽客服專員 02-55629111，我們竭誠為您服務。',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://testphp.pponline.com.tw'>點擊前往官方網站</a>"
                ];
*/
            $ctx = ['親愛的'.$account->user_name.'會員，您好',
                    '已重新發送您的驗證信件，<a href = "https://www.pponline.com.tw/users/confirmation?t='.$encode_t.'&q='.$encode_e.'">點我</a>開通您的帳號。',
                    '若無法點擊，請複製以下網址至google瀏覽器進行認證',
                    'https://www.pponline.com.tw/users/confirmation?t='.$encode_t.'&q='.$encode_e,
                    '請您繼續至會員專區完成「身份認證」、「銀行帳戶」，即可開始體驗債權投資的魅力。',
                    '如有任何問題，請洽客服專員 02-55629111，我們竭誠為您服務。',
                    "<br>",
                    "--",
                    "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                    "客服專線 : (02)5562-9111",
                    "客服信箱 : service@pponline.com.tw",
                    "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                    "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                    "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                ];
            $mailTo = [$account];
            foreach ($mailTo as $v) {

                $m = new MailTo;
                $m->send_template($v->email, $title, $ctx);
                // Mail::to($v->email)->send(new SampleMail($ctx,$from,$title));
                $this->saveInbox($v->user_id,$title,$ctx);
                $row_data['confirmation_sent_at'] = date('Y-m-d H:i:s');
                DB::table('users')->where('email',$email)->update($row_data);

                $return_data['success'] = true;
            }

        }
        else{
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


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        session_start();
        session_destroy();

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function forget_password(Request $request)
    {
        $email = $request->email;
        $account = User::where('email',$email)->first();

        if(isset($account) == true)
        {
            if($account->user_state ==1 || $account->user_state ==3){
                $row_data['reset_password_token'] = Str::random(20);
                $row_data['reset_password_sent_at'] =date('Y-m-d H:i:s');
                $reset_token = $row_data['reset_password_token'];

                DB::table('users')->where('email',$email)->update($row_data);
                // dd($this->tokenEn)
                $from = false;
                $title = '密碼重設步驟';
/*
                $ctx = ['親愛的'.$account->user_name.'會員，您好',
                        '你經我們網站要求重設密碼，請點擊以下連結重設密碼',
                        '<a href="https://testphp.pponline.com.tw/users/newpassword_setting?reset_password_token='.$this->tokenEncode($row_data['reset_password_token']).'">更改密碼</a>',
                        '如果您並沒有想要重設密碼，請不要理會這封郵件，密碼依然維持不變。密碼重設的連結將在 24 小時後過期。',
                        '如有任何問題，請洽客服專員 02-55629111，我們竭誠為您服務。',
                        "<br>",
                        "--",
                        "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                        "客服專線 : (02)5562-9111",
                        "客服信箱 : service@pponline.com.tw",
                        "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                        "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                        "豬豬在線官網 : <a href='https://testphp.pponline.com.tw'>點擊前往官方網站</a>"
                    ];
*/
                $ctx = ['親愛的'.$account->user_name.'會員，您好',
                        '你經我們網站要求重設密碼，請點擊以下連結重設密碼',
                        '<a href="https://www.pponline.com.tw/users/newpassword_setting?reset_password_token='.$this->tokenEncode($row_data['reset_password_token']).'">更改密碼</a>',
                        '如果您並沒有想要重設密碼，請不要理會這封郵件，密碼依然維持不變。密碼重設的連結將在 24 小時後過期。',
                        '如有任何問題，請洽客服專員 02-55629111，我們竭誠為您服務。',
                        "<br>",
                        "--",
                        "<span style='font-weight:bold;'>亞太普惠金融科技股份有限公司 / 信任豬股份有限公司</span>",
                        "客服專線 : (02)5562-9111",
                        "客服信箱 : service@pponline.com.tw",
                        "官方LINE : <a href='https://line.me/R/ti/p/%40sub9431m'>點擊前往</a>",
                        "FB粉專 : <a href='https://www.facebook.com/pponline888'>點擊前往粉絲專頁</a>",
                        "豬豬在線官網 : <a href='https://www.pponline.com.tw'>點擊前往官方網站</a>"
                    ];

                $mailTo = [$account];
                foreach ($mailTo as $v) {
                    $m = new MailTo;
                    $m->send_template($v->email, $title, $ctx);
                    // Mail::to($v->email)->send(new SampleMail($ctx,$from,$title));
                    $this->saveInbox($v->user_id,$title,$ctx);
                }

                $return_data['success'] = true;
            }else if($account->user_state == 0) {
                $return_data['email_confirm_first'] = true;
            }else{
                $return_data['notuser'] = true;
            }

        }
        else if(isset($account) == true && $account->user_state ==0){
            $return_data['revalid'] = true;
        }
        else{
            $return_data['notuser'] = true;
        }
        return response()->json($return_data);

    }
    public function newpassword_setting(Request $request)
    {
        $token = $this->tokenDecode($request->reset_password_token);
        $data['row'] = DB::table('users')->where('reset_password_token',$token)->first();
        if($data['row']==null){
            return redirect()->action('FrontEndController@index')->with('TokenExpired',true);
        }
        return view('Front_End.reset_password_panel',$data);
    }

    public function newpassword_confirmation(Request $request)
    {
        $token = $request->reset_password_token;
        $password = $request->encrypted_password;
        $data['row'] = DB::table('users')->where('reset_password_token',$token)->first();

        $row_data['encrypted_password'] = Hash::make($password);
        $row_data['updated_at'] = date('Y-m-d H:i:s');
        $row_data['reset_password_token'] = null;

        DB::table('users')->where('reset_password_token',$token)->update($row_data);

        $return_data['success'] = true;

        return response()->json($return_data);
    }
}
