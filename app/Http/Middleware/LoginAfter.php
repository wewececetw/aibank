<?php

namespace App\Http\Middleware;

use Closure;
Use DB;
Use Auth;

class LoginAfter
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
        $response = $next($request);
        // 優惠卷20210803
        // if(Auth::check()){
        //     $role_check = DB::select("SELECT * FROM `users_roles` WHERE user_id = ? and role_id = 1",[Auth::user()->user_id]);
        //     if (!empty($role_check)) {
        //         $data = DB::select("SELECT coupon_discount , coupon_seq , coupon_date FROM coupon_list WHERE coupon_seq = 1");
        //         $coupon_check = DB::select("SELECT u.user_id FROM users u , coupon_list cli , coupon_log clo WHERE u.user_id = ? and clo.coupon_seq = cli.coupon_seq and u.user_id = clo.user_id and clo.coupon_seq = 1 and clo.usage_time >= ? and date_format(u.birthday,'%m') = ?", [Auth::user()->user_id,date("Y-m-d H:i:s"),date("m")]);
        //         $birthday = Auth::user()->birthday;
            
        //         if (empty($coupon_check) && !empty($birthday) && date("m",strtotime($birthday)) == date("m")) {
        //             $coupon_discount = $data[0]->coupon_discount;
        //             $coupon_seq = $data[0]->coupon_seq;
        //             $coupon_date = $data[0]->coupon_date;
        //             $user_id = Auth::user()->user_id;
        //             $usage_time_before = date("Y-m-1 00:00:00", strtotime('now'));
        //             $usage_time = date("Y-m-t 23:59:59", strtotime('now'));
        //             $expire_date_before = date("Y-m-d H:i:s");
        //             $expire_date = date("Y-m-d 23:59:59", strtotime("$coupon_date"));
        //             DB::insert("INSERT INTO `coupon_log`(`coupon_seq`, `user_id`, `coupon_discount`,`usage_time_before`, `usage_time`,`expire_date_before`, `expire_date`) VALUES (?,?,?,?,?,?,?)", [$coupon_seq,$user_id,$coupon_discount,$usage_time_before,$usage_time,$expire_date_before,$expire_date]);
        //         }
        //     }
        // }
        // login log
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))
            $IP = $_SERVER["HTTP_CLIENT_IP"];
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            $IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else
            $IP = $_SERVER["REMOTE_ADDR"];
        
        $State = Auth::check() ? 1 : 2;
        $Time = date("Y-m-d H:i:s");
        $sql = "INSERT into login_log (
                    user_email,
                    login_ip,
                    login_time,
                    login_type
                ) values ( ? , ? , ? , ? )";
        $Rs = DB::insert($sql,[ $request["email"] , $IP , $Time , $State]);
        // check lock or not
        $TimeSub30m = date("Y-m-d H:i:s" , strtotime($Time."-30minutes"));
        $sql = "SELECT ll.login_type 
                from login_log ll,users u,users_roles ur
                where ll.user_email = u.email 
                    and u.user_id = ur.user_id
                    and ur.role_id = 2
                    and ll.user_email = ?
                    and ll.login_ip = ?
                    and ll.login_time between ? and ?
                order by ll.login_time desc
                limit 5";
        $LoginLog = DB::select($sql,[ $request["email"] , $IP , $TimeSub30m , $Time]);
        if(!empty($LoginLog)){
            foreach($LoginLog as $LoginType){
                !empty($LoginResult[$LoginType->login_type]) ? $LoginResult[$LoginType->login_type]++ : $LoginResult[$LoginType->login_type] = 1;
            }
            //login error
            if(!empty($LoginResult[2]) && $LoginResult[2]>=5){
                $TimeAdd30m = date("Y-m-d H:i:s" , strtotime($Time."+30minutes"));
                $sql = "INSERT into login_lock(
                            user_email,
                            lock_ip,
                            lock_time,
                            unlock_time,
                            lock_reason
                        ) values ( ? , ? , ? , ? , ? )";
                $LoginLog = DB::insert($sql,[ $request["email"] , $IP , $Time , $TimeAdd30m , "登入失敗五次"]);
            }
        }

        return $response;
    }
}
