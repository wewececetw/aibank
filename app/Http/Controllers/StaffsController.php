<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\UsersRoles;

class StaffsController extends Controller
{
    public function index(){
        $datasets = User::where('isDisplay','=','1')->orderBy('user_id','asc')->get();

        return view('Back_End.users.staffs_panel',['datasets'=>$datasets]);

    }

    public function rowDetail(){

        $datasets = User::from('users as u')
                    ->leftJoin('users_roles as ur','ur.user_id','u.user_id')
                    ->select('u.*')
                    ->where('ur.role_id',2)
                    ->orderBy('user_id','asc')
                    ->get()
                    ->toArray();

        $res = ['data'=>$datasets];
        Log::debug(json_encode($res));
        return response()->json($res);
    }



    public function staff_create(User $user)
    {
        $data['row'] = $user;
        return view('Back_End.users.staffs_insert',$data);

    }
    public function staff_store(Request $request)
    {
        $staff = new User;
        $staff->member_number = $request->member_number;
        $staff->user_name = $request->user_name;
        $staff->email = $request->email;
        $staff->phone_number = $request->phone_number;
        // $staff->encrypted_password = $request->encrypted_password;
        $staff->encrypted_password = Hash::make($request->encrypted_password);
        $staff->user_type = $request->user_type;
        $staff->updated_at = date('Y-m-d H:i:s');
        $staff->save();

        $us = User::select('user_id')->where('email',$request->email)->where('user_name',$request->user_name)->where('phone_number',$request->phone_number)->orderBy('created_at','desc')->first()->user_id;
        $userRoles = new UsersRoles;
        $userRoles->user_id = $us;
        $userRoles->role_id = 2;
        $userRoles->save();
        $return_data['success'] = true;
        return response()->json($return_data);

    }

    public function staff_edit(User $user)
    {
        $data['row'] = $user;
        return view('Back_End.users.staffs_edit',$data);

    }
    public function staff_update(Request $request, User $user)
    {
        $user_id = $request->user_id;
        $check = User::where('user_id',$user_id)->first();

        $user->member_number = $request->member_number;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        if($check->encrypted_password == $request->encrypted_password){
            $user->encrypted_password = $request->encrypted_password;
        }
        else{
            $user->encrypted_password = Hash::make($request->encrypted_password);
        }

        // $user->encrypted_password = $request->encrypted_password;
        $user->encrypted_password = Hash::make($request->encrypted_password);
        $user->user_type = $request->user_type;
        $user->updated_at = date('Y-m-d H:i:s');

        $user->save();
        $return_data['success'] = true;
        return response()->json($return_data);

    }
    public function search(Request $req)
    {
        $model = new User;
        $model = $model->from('users as u')
                    ->leftJoin('users_roles as ur','ur.user_id','u.user_id')
                    ->select('u.*')
                    ->where('ur.role_id',2)
                    ->orderBy('user_id','asc');

        $search = [];
        // dd($req->all());
        foreach ($req->all() as $key => $value) {
            $search[$key] =$value;
            if(isset($value)){
                $model = $model->where($key,'like','%'.$value.'%');
            }
        }



        // $search['member_number'] = $req->all()['member_number'];
        // $search['user_name'] = $req->all()['user_name'];
        // $search['email'] = $req->all()['email'];
        // $search['phone_number'] =$req->all()['phone_number'];

        // $model = new User;
        // $model = $model->where('member_number', 'like','%'.$search['member_number'].'%');
        // $model = $model->where('user_name','like','%'.$search['user_name'].'%');
        // $model = $model->where('email', 'like','%'.$search['email'].'%');
        // $model = $model->where('phone_number', 'like','%'.$search['phone_number'].'%');

        $data = $model->get();


        $res['data'] = [];
        foreach($data as $k=> $v)
        {

            $ar = [];
            $ar['user_id'] = $v->user_id;
            $ar['member_number'] = $v->member_number;
            $ar['user_name'] = $v->user_name;
            $ar['email'] = $v->email;
            $ar['phone_number'] = $v->phone_number;

            array_push($res['data'],$ar);
        }
        Log::debug($res['data']);
        return response()->json($res['data']);

    }
    // public function staff_display(Request $request)
    // {
    //     $id = $request->id;
    //     $data['row'] = DB::table('users')->where('user_id',$id)->first();
    //     $row_data['isDisplay'] = !($data['row']->isDisplay);
    //     DB::table('users')->where('user_id',$id)->update($row_data);
    //     $return_data['success'] = true;

    //     return response()->json($return_data);

    // }
    public function staff_delete(User $user)
    {
        $user->delete();
        $return['success'] = true;

        return response()->json($return);
    }

}
