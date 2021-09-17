<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Web_contents;
use App\Web_contents_photos;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{

    public function index()
    {

        $data['news'] = Web_contents::Where('category','=','10')->get();

        return view('Back_End.web_contents.news.news_panel',$data);

    }

    public function news_insert(Request $req){

        // dd($req->all());
        $news = new Web_contents;


        $news->title = $req->title;
        $news->remark = $req->remark;
        $news->name = $req->name;
        $news->content = $req->content;
        $news->is_active = $req->is_active;
        
        if(isset($req->launch_at)){
            $news->launch_at = $req->launch_at;
        }else{
            $news->launch_at = date('Y-m-d H:i:s');
        }

        $news->created_at = date('Y-m-d H:i:s');
        $news->category = 10;

        $news->save();
        
        if(isset($req->image)){

            $news_photo = new Web_contents_photos;

            $news_photo->image = $this->StoreImg($req, 'image');
            $news_photo->created_at = date('Y-m-d H:i:s');

            $news->news_photo()->save($news_photo);
        }

            



        $return_data['success'] = true;
        return response()->json($return_data);

    }


    public function news_edit(Web_contents $news){

             $data['news'] = $news;

             return view('Back_End.web_contents.news.news_edit',$data);
       
    }



    public function news_update(Request $req, Web_contents $news){


        $news->title = $req->title;
        $news->remark = $req->remark;
        $news->name = $req->name;
        $news->content = $req->content;
        $news->is_active = $req->is_active;

        if(isset($req->launch_at)){
            $news->launch_at = $req->launch_at;
        }else{
            $news->launch_at = date('Y-m-d H:i:s');
        }

        $news->updated_at = date('Y-m-d H:i:s');
        
        $news->save();


        if(isset($req->image)){
            $news->news_photo()->delete();

            $news_photo = new Web_contents_photos;

            $news_photo->image = $this->StoreImg($req, 'image');
            $news_photo->created_at = date('Y-m-d H:i:s');

            $news->news_photo()->save($news_photo);
        }


        $return_data['success'] = true;
        return response()->json($return_data);
    }

    //存圖片
    public function StoreImg($req, $file)
    {
        $fileName = $this->Del_deputy_file_name($req->file($file)->getClientOriginalName());
        $path = Storage::disk('public_uploads')->putFileAs('News_Photo/' . date("Ymd"), new File($req->file($file)), $fileName);
        $FilePath = 'uploads/News_Photo/' .date("Ymd") . '/' . $fileName;
        return $FilePath;
    }


    //重新命名
    public function Del_deputy_file_name($file)
    {
        $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
        $fileName = $num . $file;
        $secondFileName = explode('.',$fileName)[1];

        $fileName = md5($fileName).'.'.$secondFileName;
        return $fileName;
    }



    public function news_delete(Web_contents $news){

        $news->news_photo()->delete();
        $news->delete();

        $return_data['success'] = true;
        return response()->json($return_data);

    }



}