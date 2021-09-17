<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankApiCtx extends Model
{
    protected $table = 'bank_api_ctx';
    protected $primaryKey = 'bank_api_ctx_id';
    protected $guards = [];

    public $needCheckRepeat = [
        'inacctno',
        'amt',
        'txdate',
        'txtime'
    ];

    /**
     * autoSave
     *
     * @param  mixed $reqAll
     * @param  mixed $ip
     * @return void
     */
    public function autoSave($reqAll)
    {
        $dataArray = $this->changeArray($reqAll);
        $checkRepeat = $this->checkRepeat($dataArray);
        if($checkRepeat === true){
            foreach ($dataArray as $key => $value) {
               $this->$key = $value;
            }
            $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = date('Y-m-d H:i:s');
            $this->save();
            return $this;
        }else{
            return false;
        }

    }

    /**
     * 將彰銀API的請求轉換成對應DB [欄位=>值] 的陣列
     *
     * @param  mixed $request_array
     * @return void
     */
    public function changeArray($request_array)
    {
        $ar = [];
        foreach ($request_array as $k => $value) {
            if ($k != '_token') {
                $col = strtolower($k);
                switch ($col) {
                    case 'entdate':
                    case 'txdate':
                        $date = date('Y-m-d', strtotime($value));
                        $ar[$col] = $date;
                        break;
                    default:
                        $ar[$col] = $value;
                        break;
                }
            }
        }
        return $ar;
    }

    /**
     * 檢查資料庫是否存在輸入資料
     *
     * @param  mixed $dataArray
     * @return void
     */
    public function checkRepeat($dataArray)
    {
        $whereAr = [];
        foreach ($this->needCheckRepeat as $col) {
            array_push($whereAr,[$col,$dataArray[$col]]);
        }
        $res = $this->where($whereAr)->get();
        if(count($res) > 0){
            return false;
        }else{
            return true;
        }
    }
}
