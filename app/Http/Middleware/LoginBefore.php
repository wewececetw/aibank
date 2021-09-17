<?php

namespace App\Http\Middleware;

use Closure;
Use DB;
Use Auth;
use \Illuminate\Validation\ValidationException;

class LoginBefore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))
            $IP = $_SERVER["HTTP_CLIENT_IP"];
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            $IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else
            $IP = $_SERVER["REMOTE_ADDR"];
        $Time = date("Y-m-d H:i:s");
        $sql = "SELECT * 
                from login_lock
                where ? between lock_time and unlock_time
                    and user_email = ?
                    and lock_ip = ? ";
        $Rs = DB::select( $sql , [ $Time , $request["email"] , $IP ]);
        if(!$Rs)
            return $next($request);
        
        echo "<script>alert('此帳號已被鎖，請聯絡IT解除');location.href='/'</script>";
        
    }
}
