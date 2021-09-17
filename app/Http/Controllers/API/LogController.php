<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;

class LogController extends Controller
{
    //
    public function upduserreadtime(Request $request){
        $Response["result"] = false;
        $Response["message"] = "";
        $Update["log_readtime"] = date("Y-m-d H:i:s"); 
        $Rs = DB::table('users') -> where('user_id',Auth::user()->user_id)->update($Update);
        if($Rs){
            $Response["result"] = true;
        }else{
            $Response["message"] .= "更新失敗";
        }
        return response()->json($Response);
    }
}
