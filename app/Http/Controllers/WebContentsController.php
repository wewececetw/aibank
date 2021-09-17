<?php

namespace App\Http\Controllers;

use App\Web_contents;
use App\Web_contents_photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
class WebContentsController extends Controller
{
    private $category;
    private $category_name;
    private $category_ch_name;
    private $category_base_url;
    private $cateGoryIndexView = 'Back_End.web_contents.categoryIndex';

    public function __construct(Request $req)
    {
        $this->category_name = $req->category_name;
        $baseParams = $this->getBaseParams($this->category_name);
        $this->category_ch_name = $baseParams['category_ch_name'];
        $this->category_base_url = $baseParams['category_base_url'];
        $this->category = $baseParams['category'];
    }

    public function getBaseParams($categoryName)
    {
        switch ($categoryName) {
            case 'IndexBanner':
                return [
                    'category' => 1,
                    'category_ch_name' => '首頁Banner',
                    'category_base_url' => '/web_contents/IndexBanner/contents',
                ];
                break;
            case 'financial':
                return [
                    'category' => 3,
                    'category_ch_name' => '財經專欄',
                    'category_base_url' => '/web_contents/financial/contents',
                ];
                break;
            case 'team':
                return [
                    'category' => 4,
                    'category_ch_name' => '團隊成員',
                    'category_base_url' => '/web_contents/team/contents',
                ];
                break;
            case 'qa':
                return [
                    'category' => 6,
                    'category_ch_name' => '常見問題文案',
                    'category_base_url' => '/web_contents/qa/contents',
                ];
                break;
            case 'defaultRate':
                return [
                    'category' => 15,
                    'category_ch_name' => '違約率表格',
                    'category_base_url' => '/web_contents/defaultRate/contents',
                ];
            break;
            default:
                # code...
                break;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Web_contents::cateGoryAll($this->category);
        $sortData = [];
        foreach ($data as $k => $value) {
            $ar = [
                'item_num' => $k,
                'web_contents_id' => $value->web_contents_id,
                'sort' => $value->sort
            ];
            array_push($sortData,$ar);
        }
        return view($this->cateGoryIndexView, [
            'category_ch_name' => $this->category_ch_name,
            'thisBaseUrl' => $this->category_base_url,
            'data' => $data,
            'sortData' => json_encode($sortData)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nameList = Web_contents::categoryDistincName($this->category);
        if ($this->category == 1 || $this->category == 4) {
            //首頁Banner
            return view('Back_End.web_contents.create_banner', [
                'category' => $this->category,
                'category_ch_name' => $this->category_ch_name,
                'thisBaseUrl' => $this->category_base_url,
            ]);
        } else {
            return view('Back_End.web_contents.create_artical', [
                'category_ch_name' => $this->category_ch_name,
                'category' => $this->category,
                'thisBaseUrl' => $this->category_base_url,
                'nameList' => json_encode($nameList)
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            // $validatedData = $req->validate([
            //     'image' => 'required',
            // ]);
            if ($this->category == 1 || $this->category == 4) {
                $webContents = (new Web_contents)->storeIndexBanner($req,$this->category_name);
                return response()->json([
                    'status' => 'success',
                ]);
            } else {

                $webContents = (new Web_contents)->storeNormalArtical($req,$this->category_name);
                return response()->json([
                    'status' => 'success',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category_name, $id)
    {
        $nameList = Web_contents::categoryDistincName($this->category);
        $data = Web_contents::with('news_photo')->find($id)->toJson();
        if ($this->category == 1 || $this->category == 4) {
            //首頁Banner
            return view('Back_End.web_contents.create_banner', [
                'category_ch_name' => $this->category_ch_name,
                'category' => $this->category,
                'thisBaseUrl' => $this->category_base_url,
                'edit' => true,
                'data' => $data,
            ]);
        }else{
            return view('Back_End.web_contents.create_artical', [
                'category_ch_name' => $this->category_ch_name,
                'thisBaseUrl' => $this->category_base_url,
                'category' => $this->category,
                'edit' => true,
                'data' => $data,
                'nameList' => json_encode($nameList)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $category_name, $id)
    {
        try {
            if ($this->category == 1 || $this->category == 4) {
                $model = Web_contents::find($id);
                $model->updateIndexBanner($req,$this->category_name);
            }else{
                $model = Web_contents::find($id);
                $model->updateNormalArtical($req,$this->category_name);
            }
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($category_name, $id)
    {
        try {
            // Storage::disk('public_uploads')->delete('IndexBanner/20200410/77650.jpg');
            Web_contents::find($id)->delete();
            $photo_model = Web_contents_photos::where('web_contents_id', $id);
            $this->deleteImg($photo_model);
            $photo_model->delete();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    /**
     * 重新排序
     *
     * @param  mixed $req
     * @return void
     */
    public function resort(Request $req)
    {
        try {
            $data = json_decode($req->all()['data'],true);
            $ids = [];
            $update_array = [];
            $time = date('Y-m-d H:i:s');
            foreach ($data as $v) {
                // array_push($ids,$v['web_contents_id']);
                // array_push($update_array,[
                //     'sort' => $v['sort'],
                //     'updated_at' => $time
                // ]);
                Web_contents::find($v['web_contents_id'])->update([
                    'sort' => $v['sort'],
                    'updated_at' => $time
                ]);
            }
            // DB::table('web_contents')->whereIn('web_contents_id',$ids)->update($update_array);
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'status' => 'fail'
            ]);
        }

    }

    public function deleteImg($webContentsPhoto)
    {
        $imgs = $webContentsPhoto->get();
        foreach ($imgs as $img) {
            $path = explode('uploads', $img->image)[1];
            Storage::disk('public_uploads')->delete($path);
        }
    }
}
