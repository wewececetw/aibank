<?php

namespace App;

use App\Web_contents_photos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
class Web_contents extends Model
{
    protected $table = 'web_contents';
    protected $primaryKey = 'web_contents_id';
    public $timestamps = false;
    protected $guarded  = [];

    public function news_photo()
    {
        return $this->hasMany('App\Web_contents_photos','web_contents_id');
    }

    public function photo() {
        // return $this->hasMany('App\Web_contents_photos','web_contents_id')->limit(1);
        return $this->hasOne('App\Web_contents_photos','web_contents_id')->oldest();
    }

    public function scopeBannerUrlList($query,$category)
    {
        // return $query->with('news_photo')->where('category',1)->where('is_active',1)->get()->toArray();
        $list = [];
        try {
            $data = $query->with('news_photo')->where('category',$category)->where('is_active',1)->orderBy('sort','asc')->get()->toArray();
            foreach ($data as $v) {
                $url = $v['news_photo'][0]['image'];
                if(isset($url) && !is_null($url));
                array_push($list,url($url));
            }
        } catch (\Throwable $th) {
            return $list;
        }

        return $list;
    }

    /**
     * 取得 首頁 違約率表格 清單列表資料
     *
     * @return void
     */
    public function getDefaultRateIndexViewData()
    {
        $ar = [];
        $d = $this->with('photo')->where('category',15)->where('is_active',1)->orderBy('sort','asc')->get()->toArray();
        foreach ($d as $v) {
            $a = [
                'web_contents_id' => $v['web_contents_id'],
                'name' => $v['name'],
                'content' => $v['content'],
                'title' => $v['title'],
                'photo_path' => $v['photo']['image'],
            ];
            array_push($ar,$a);
        }
        return $ar;
    }

    /**
     * 取得分類所有內容資料
     *
     * @param  mixed $category = 分類ID
     * @return void
     */
    public static function cateGoryAll($category)
    {
        return self::where('category',$category)->orderBy('is_active','desc')->orderBy('sort','asc')->get();
    }

    public function cateGoryLastSort($category)
    {
        $last_sort = $this->select('sort')->where('category',$category)->where('is_active',1)->orderBy('sort','desc')->first();
        if(isset($last_sort)){
            return $last_sort->sort+1;
        }else{
            return 1;
        }
    }

    /**
     * 取得分類名稱
     *
     * @param  mixed $query
     * @param  mixed $category
     * @return void
     */
    public function scopeCategoryDistincName($query,$category)
    {
        $result = [];
        $d = $query->select('name')->where('category',$category)->orderBy('is_active','desc')->orderBy('sort','asc')->distinct('name')->get();
        foreach ($d as $v) {
            array_push($result,$v->name);
        }
        return $result;
    }

    /**
     * 儲存Banner
     *
     * @param  mixed $req = request
     * @return void
     */
    public function storeIndexBanner($req,$category_name)
    {
        $now = date("Y-m-d H:i:s");
        $img_path = $this->StoreImg($req, 'image',$category_name);
        $this->name = $req->name;
        $this->title = $req->title;
        $this->is_active = $req->is_active;
        $this->category = $req->category;
        $this->launch_at = date('Y-m-d H:i:s',strtotime($req->launch_at));
        $this->sort = $this->cateGoryLastSort($req->category);
        $this->created_at = $now;
        $this->updated_at = $now;
        $this->save();
        (new Web_contents_photos)->storeNew($this->web_contents_id,$img_path);
        return $this;
    }
    /**
     * 儲存一般的文章
     *
     * @param  mixed $req
     * @return void
     */
    public function storeNormalArtical($req,$category_name)
    {
        $now = date("Y-m-d H:i:s");
        if (isset($req->image)) {
            $img_path = $this->StoreImg($req, 'image', $category_name);
        }
        $this->name = $req->name;
        $this->remark = $req->remark;
        $this->title = $req->title;
        $this->is_active = $req->is_active;
        $this->category = $req->category;
        $this->launch_at = date('Y-m-d H:i:s',strtotime($req->launch_at));
        $this->content = $req->content;
        $this->sort = $this->cateGoryLastSort($req->category);
        $this->created_at = $now;
        $this->updated_at = $now;
        $this->save();
        if (isset($req->image)) {
            (new Web_contents_photos)->storeNew($this->web_contents_id, $img_path);
        }
        return $this;
    }

   /**
     * 更新首頁Banner
     *
     * @param  mixed $req = request
     * @return void
     */
    public function updateIndexBanner($req,$category_name)
    {
        $now = date("Y-m-d H:i:s");
        if(isset($req->image)){
            $img_path = $this->StoreImg($req, 'image',$category_name);
        }
        $this->name = $req->name;
        $this->title = $req->title;
        $this->is_active = $req->is_active;
        $this->launch_at = date('Y-m-d H:i:s',strtotime($req->launch_at));
        $this->updated_at = $now;
        $this->save();
        if(isset($req->image)){
            $wcp = Web_contents_photos::where('web_contents_id',$this->web_contents_id)->first();
            if($wcp){
                $this->deleteImg($wcp->image);
                $wcp->update([
                    'image' => $img_path,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }else{
                (new Web_contents_photos)->storeNew($this->web_contents_id,$img_path);
            }

        }
        return $this;
    }
   /**
     * 更新一般文章
     *
     * @param  mixed $req = request
     * @return void
     */
    public function updateNormalArtical($req,$category_name)
    {
        $now = date("Y-m-d H:i:s");
        if(isset($req->image)){
            $img_path = $this->StoreImg($req, 'image',$category_name);
        }
        $this->name = $req->name;
        $this->title = $req->title;
        $this->remark = $req->remark;
        $this->is_active = $req->is_active;
        $this->content = $req->content;
        $this->launch_at = date('Y-m-d H:i:s',strtotime($req->launch_at));
        $this->updated_at = $now;
        $this->save();
        if(isset($req->image)){
            $wcp = Web_contents_photos::where('web_contents_id',$this->web_contents_id)->first();

            if($wcp){
                $this->deleteImg($wcp->image);
                $wcp->update([
                    'image' => $img_path,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }else{
                (new Web_contents_photos)->storeNew($this->web_contents_id,$img_path);
            }

        }
        return $this;
    }
    //存圖片
    public function StoreImg($req, $file, $dir)
    {
        $fileName = $req->file($file)->getClientOriginalName();
        // $fileName = $this->Del_deputy_file_name($req->file($file)->getClientOriginalName());
        $path = Storage::disk('public_uploads')->putFileAs('/'.$dir.'/' . date("Ymd"), new File($req->file($file)), $fileName);
        $FilePath = 'uploads/'.$dir.'/' . date("Ymd") . '/' . $fileName;
        return $FilePath;
    }

    //亂數重新命名用
    public function Del_deputy_file_name($file)
    {
        $num = rand(0, 9) . rand(0, 9) . rand(0, 9) . time();
        $fileName = $num . $file;
        $secondFileName = explode('.', $fileName)[1];
        $fileName = md5($fileName) . '.' . $secondFileName;
        return $fileName;
    }


    public function deleteImg($path)
    {
        $path = explode('uploads', $path)[1];
        Storage::disk('public_uploads')->delete($path);
    }
}
