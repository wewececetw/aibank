<?php

namespace App\Http\Middleware\UserRole;

use Closure;
use Auth;
use App\UsersRoles;

class front
{
    /**
     * 使用者後台
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user_id = Auth::user()->user_id;
            $role_id = UsersRoles::where('user_id',$user_id)->first()->role_id;

            if($role_id == 1){
                return $next($request);
            }else{
                return redirect('/');
            }

        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/');

        }
    }
}
