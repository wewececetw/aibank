<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use App\UsersRoles;
use App\User;
use DB;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * 判斷使用者能否接收郵件
     * @return bool
     */
    public function checkUserCanReciveMail($email)
    {
        try {
            $sql = $this->whereEmailSql($email);

            $data = DB::select($sql);
            $role = $data[0]->role_id;
            $receiveLetter = $data[0]->is_receive_letter;
            if($role == 1 && $receiveLetter == 1){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
    /**
     * 取得所有能接收信件的使用者email
     */
    public function getCanReciveMailUserEmailAll()
    {
        $sql = $this->whereAllEmailSql();
        $data = DB::select($sql);
        $ar = [];
        foreach($data as $k => $v){
            array_push($ar,$v->email);
        }
        return $ar;
    }

    public function whereEmailSql($email)
    {
        $sql = "SELECT
                    ur.role_id,
                    u.is_receive_letter
                FROM
                    users AS u
                LEFT JOIN users_roles AS ur
                ON
                    ur.user_id = u.user_id
                WHERE
                    u.email = '".$email."'";
        return $sql;
    }
    public function whereAllEmailSql()
    {
        $sql = "SELECT
                    u.email
                FROM
                    users AS u
                LEFT JOIN users_roles AS ur
                ON
                    ur.user_id = u.user_id
                WHERE
                    ur.role_id IS NOT NULL AND u.is_receive_letter IS NOT NULL AND ur.role_id = 1 AND u.is_receive_letter = 1";
        return $sql;
    }

    public static function NowPosition()
    {
        // dd(request()->route()->getAction());
        $NowPath = request()->route()->getAction()['controller'];
        $NowPath = str_replace("App\Http\\", "", $NowPath);
        $NowPath = str_replace("\\", "/", $NowPath);
        $NowPath = str_replace("@", "/", $NowPath);
        // dd($NowPath);
        return $NowPath;
    }


    public function logg($msg,$ctxArray)
    {
        $path = self::NowPosition();
        $logpath = 'logs/' . $path . '.log';
        $log = new Logger('pponline');
        $log->pushHandler(new StreamHandler(storage_path($logpath)), Logger::DEBUG);
        $log->debug($msg, $ctxArray);

    }


    public function tokenDecode($content){
        $token = '1234567891234567';
        $iv = substr(md5($token),8,16);
        $result = openssl_decrypt(
            str_replace(" ","+",$content),
            "AES-256-CBC",
            $token,
            0,
            $iv
        );
        return $result;        
     }

    public function tokenEncode($content){
        $token = '1234567891234567';
        $iv = substr(md5($token),8,16);
        return openssl_encrypt(
             $content,
             "AES-256-CBC",
             $token,
             0,
             $iv
         );
    }
}
