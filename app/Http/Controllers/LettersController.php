<?php

namespace App\Http\Controllers;
use App\Letters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendgridMail;
use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use App\User;
use App\log_outside_letters;
use Lang;
use App\Mail\MailTo;



class LettersController extends Controller
{
    use SendGrid;
    public function index()
    {
        $letters_count = DB::select('select * from internal_letters where isDisplay = 1');

        $page_count = ceil(count($letters_count)/5);

        $datasets = Letters::where('isDisplay', '=', '1')->orderBy('created_at', 'desc')->skip(0)->take(5)->get();
        
        $identityArray = Lang::get('user_ids');

        $row_data = [];
        foreach ($datasets as $dataset){
            $user_name = User::where('user_id',$dataset->user_ids)->first();

            if($dataset->user_ids > 0){

                $row_data[$dataset->user_ids] = $user_name->email;
            }else{
                
                $row_data[$dataset->user_ids] = $identityArray[$dataset->user_ids];
                
            }
            
        }
        return view('Back_End.letters.letters_panel', ['datasets'=>$datasets,'row_data'=>$row_data,'identityArray'=>$identityArray,'page_count'=>$page_count]);
    }

    public function outside_letters()
    {
        $letters_count = DB::select('select * from log_outside_letters');

        $page_count = ceil(count($letters_count)/5);

        $datasets = log_outside_letters::orderBy('send_time', 'desc')->skip(0)->take(5)->get();
        
        $identityArray = Lang::get('user_ids');

        $row_data = [];
        foreach ($datasets as $dataset){
            $user_name = User::where('user_id',$dataset->user_id)->first();

            if($dataset->user_id > 0){

                $row_data[$dataset->user_id] = $user_name->email;
            }else{
                
                $row_data[$dataset->user_id] = $identityArray[$dataset->user_id];
                
            }
            
        }
        return view('Back_End.letters.outside_letters_panel', ['datasets'=>$datasets,'row_data'=>$row_data,'identityArray'=>$identityArray,'page_count'=>$page_count]);
    }

    public function letters_create()
    {
        $data['identityArray'] = Lang::get('user_ids');
        return view('Back_End.letters.insert_letters', $data);
    }

    public function letters_store(Request $request)
    {
        if(!empty($request->user_email)){

            $id = User::where('email',$request->user_email)->first();
            $letters = new Letters;
            $letters->user_id =  Auth::user()->user_id;
            $letters->title = $request->title;
            $letters->content = $request->ckeditor;
            $letters->user_ids = $id->user_id;
            $letters->created_at = date('Y-m-d H:i:s');
            $letters->updated_at = date('Y-m-d H:i:s');
            $letters->save();

        }
        if (isset($request->user_ids)) {

            $user_ids = $request->user_ids;
        
            $letters2 = new Letters;

            $letters2->user_id =  Auth::user()->user_id;
            $letters2->title = $request->title;
            $letters2->content = $request->ckeditor;
            $letters2->user_ids = $user_ids;
            $letters2->created_at = date('Y-m-d H:i:s');
            $letters2->updated_at = date('Y-m-d H:i:s');
            $letters2->save();
            
        }
        
        $return['success'] = true;
        return response()->json($return);
    }

    public function inbox_letters_create()
    {
        $data['identityArray'] = Lang::get('user_ids');
        return view('Back_End.letters.insert_inbox_letters', $data);
    }

    public function inbox_letters_store(Request $request)
    {
        $m = new MailTo;
        if(!empty($request->user_email)){

            $id = User::where('email',$request->user_email)->first();

            $m->send_outbox_mail($id->user_id,$request->title,$request->ckeditor);

            $user_idss = $id->user_id;
            
            
        }
        if (isset($request->user_ids)) {



            $m->send_outbox_mail_for_class($request->user_ids,$request->title,$request->ckeditor);
            $user_idss = $request->user_ids;

        }
        $letters = new log_outside_letters;

        $letters->admin_id =  Auth::user()->user_id;
        $letters->title = $request->title;
        $letters->content = $request->ckeditor;
        $letters->user_id = $user_idss;
        $letters->send_time = date('Y-m-d H:i:s');
        $letters->admin_ip = $request->ip();;
        $letters->save();

        // $letters2 = new Letters;
        // $letters2->user_id =  Auth::user()->user_id;
        // $letters2->title = $request->title;
        // $letters2->content = $request->ckeditor;
        // if (!empty($request->user_email)) {
        //     $letters2->user_ids = $id->user_id;
        // }elseif(isset($request->user_ids)){
        //     $letters2->user_id = $user_idss;
        // }
        // $letters2->created_at = date('Y-m-d H:i:s');
        // $letters2->updated_at = date('Y-m-d H:i:s');
        // $letters2->save();

        
        $return['success'] = true;
        return response()->json($return);
    }

    public function letters_update(Request $request)
    {
        $search['letter_id'] = $request->all()['letter_id'];

        $Letters = Letters::find($search['letter_id']);

        $Letters->title = $request->all()['title'];
        $Letters->content = $request->all()['ckeditor'];
        $Letters->updated_at = date('Y-m-d H:i:s');

        $Letters->save();
        
        $return['success'] = true;
        return response()->json($return);
    }
   

    public function letters_details(Letters $letters)
    {
        if($letters->isDisplay != 0){
            $data['row'] = $letters;
            $identityArray = Lang::get('user_ids');
            if ($letters->user_ids > 0) {
                $user_name = User::where('user_id', $letters->user_ids)->first();
                $data['user_email'] = $user_name->email;
            }else{
                $data['user_email'] = $identityArray[$letters->user_ids];
            }
            
            return view('Back_End.letters.letter_details', $data);
        }else{
            return redirect()->back();
        }
        
    }
    public function outside_letters_details(log_outside_letters $letters)
    {
        
        $data['row'] = $letters;
        $identityArray = Lang::get('user_ids');
        if ($letters->user_id > 0) {
            $user_name = User::where('user_id', $letters->user_id)->first();
            $data['user_email'] = $user_name->email;
        }else{
            $data['user_email'] = $identityArray[$letters->user_id];
        }
        
        return view('Back_End.letters.outside_letter_details', $data);
        
        
    }
    public function search(Request $req)
    {
        $search['title'] = $req->all()['title'];
        // $search['content'] = $req->all()['content'];
        $search['email'] = $req->all()['email'];
        $search['id_search'] = $req->all()['id_search'];
        $search['sequence'] = $req->all()['sequence'];
        $search['page'] = 0;
        if(!empty($req->all()['page'])){
            $search['page'] = $req->all()['page']-1;
            $search['page'] = $search['page'] * 5; 
        }
        
        
        $model = new Letters;
        $model = $model->where('isDisplay','=',1);
        $identityArray = Lang::get('user_ids');

        if (!empty($search['title'])) {

            $model = $model->where('title', 'like', '%'.$search['title'].'%');
        }
        // if (!empty($search['content'])) {
        //     $model = $model->where('content', 'like', '%'.$search['content'].'%');
        // }
        if(!empty($search['email'])){

            $id = User::where('email',$search['email'])->first();
            $model = $model->where('user_ids', '=', $id->user_id);
        }
        if(isset($search['id_search'])){

            $model = $model->where('user_ids','=',$search['id_search']);
        }
        //暫時存取查詢結果以記頁數
        $page_sql = $model;
        $page_count = $page_sql->get();
        if(empty($search['sequence'])){
            $data = $model->orderBy('created_at', 'desc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == 1){
            $data = $model->orderBy('user_ids', 'asc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == -1){
            $data = $model->orderBy('user_ids', 'desc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == 2){
            $data = $model->orderBy('title', 'asc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == -2){
            $data = $model->orderBy('title', 'desc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == 3){
            $data = $model->orderBy('created_at', 'asc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == -3){
            $data = $model->orderBy('created_at', 'desc')->skip($search['page'])->take(5)->get();
        }
        
        
        $res = [];
        $count = 0;
        $res['data']= [];
        foreach ($data as $v) {

            $ar = [];
            if($v->user_ids > 0){
                
                $user_name = User::where('user_id',$v->user_ids)->first();
                $res['data'][$count]['email'] = $user_name->email;
            }else{

                $res['data'][$count]['email'] = $identityArray[$v->user_ids];
                
            }
            $res['data'][$count]['title'] = $v->title;
            $res['data'][$count]['created_at'] = $v->created_at;
            $res['data'][$count]['button'] = "<div class='btn-group'>
            <a class='btn btn-info' href='/admin/internal_letters_details/".$v->internal_letter_id."'><i class='fa fa-eye'></i></a>
            <button class='btn btn-danger' name='changeValue' onClick='isDisplay_letter($v->internal_letter_id)' ><i class='fa fa-trash-o'></i></button>
            </div>";
            
            $count++;
        }
        //計算頁數
        $res{'count'} = ceil(count($page_count)/5) ;
        return response()->json($res);
    }

    public function outside_letters_search(Request $req)
    {
        $search['title'] = $req->all()['title'];
        // $search['content'] = $req->all()['content'];
        $search['email'] = $req->all()['email'];
        $search['id_search'] = $req->all()['id_search'];
        $search['sequence'] = $req->all()['sequence'];
        $search['page'] = 0;
        if(!empty($req->all()['page'])){
            $search['page'] = $req->all()['page']-1;
            $search['page'] = $search['page'] * 5; 
        }
        
        
        $model = new log_outside_letters;
        $identityArray = Lang::get('user_ids');

        if (!empty($search['title'])) {

            $model = $model->where('title', 'like', '%'.$search['title'].'%');
        }
        // if (!empty($search['content'])) {
        //     $model = $model->where('content', 'like', '%'.$search['content'].'%');
        // }
        if(!empty($search['email'])){

            $id = User::where('email',$search['email'])->first();
            $model = $model->where('user_id', '=', $id->user_id);
        }
        if(isset($search['id_search'])){

            $model = $model->where('user_id','=',$search['id_search']);
        }
        //暫時存取查詢結果以記頁數
        $page_sql = $model;
        $page_count = $page_sql->get();
        if(empty($search['sequence'])){
            $data = $model->orderBy('send_time', 'desc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == 1){
            $data = $model->orderBy('user_id', 'asc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == -1){
            $data = $model->orderBy('user_id', 'desc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == 2){
            $data = $model->orderBy('title', 'asc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == -2){
            $data = $model->orderBy('title', 'desc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == 3){
            $data = $model->orderBy('send_time', 'asc')->skip($search['page'])->take(5)->get();
        }elseif($search['sequence'] == -3){
            $data = $model->orderBy('send_time', 'desc')->skip($search['page'])->take(5)->get();
        }
        
        
        $res = [];
        $count = 0;
        $res['data']= [];
        foreach ($data as $v) {

            $ar = [];
            if($v->user_id > 0){
                
                $user_name = User::where('user_id',$v->user_id)->first();
                $res['data'][$count]['email'] = $user_name->email;
            }else{

                $res['data'][$count]['email'] = $identityArray[$v->user_id];
                
            }
            $res['data'][$count]['title'] = $v->title;
            $res['data'][$count]['send_time'] = $v->send_time;
            $res['data'][$count]['button'] = "<div class='btn-group'>
            <a class='btn btn-info' href='/admin/outside_letters_details/".$v->log_o_letter_id."'><i class='fa fa-eye'></i></a>
            </div>";
            
            $count++;
        }
        //計算頁數
        $res{'count'} = ceil(count($page_count)/5) ;
        return response()->json($res);
    }
    // public function letters_delete(Letters $letters)
    // {
    //     $letters->delete();
    //     $return['success'] = true;

    //     return response()->json($return);
    // }

    public function letters_display(Request $request)
    {
        $id = $request->id;
        $data['row'] = DB::table('internal_letters')->where('internal_letter_id', $id)->first();
        $row_data['isDisplay'] = !($data['row']->isDisplay);
        DB::table('internal_letters')->where('internal_letter_id', $id)->update($row_data);
        $return_data['success'] = true;

        return response()->json($return_data);
    }
    public function sendMail()
    {
        Mail::to('momorrrr8188@gmail.com')->send(new SendgridMail());
        dd('Mail sent');
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $date = date("YmdHis");

            $filename = $request->file('upload')->getClientOriginalName();

            $filename = $this->myTrim($filename);

            $filenametostore = $date.'_'.$filename;

            $path = Storage::disk('public_uploads')->putFileAs('common/', new File($request->file('upload')), $filenametostore);

            // $request->file('upload')->storeAs('public/uploads/letters', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/common/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    public function myTrim($str)
    {
    $search = array(" ","　","\n","\r","\t");
    $replace = array("","","","","");
    return str_replace($search, $replace, $str);
    }

    public function browse(Request $request)
    {
        $paths = \glob(public_path('uploads/common/*'));
        $fileNames = [];
        foreach($paths as $path){
            array_push($fileNames,\basename($path));
        }
        return view('Back_End.common.browse', ['fileNames'=>$fileNames,'request'=>$request->input('CKEditorFuncNum')]);
    }
}
