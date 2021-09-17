<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTables;

class Loan extends Model
{
    use DataTables;
    protected $table = 'loans';
    protected $primaryKey = "loan_id";
    public $timestamps = false;

    public function getTableColumns() 
    {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }


    public function getLoanTypeAttribute($v){
        switch ($v) {
            case "0":
                return '個人信用貸款';
                break;
            case "1" : 
                return "個人抵押貸(車貸)";
                break;
            case "2" :
                return "商業貸";
                break;
            default:
                return $v;
                break;
        }
    }
    public function getIsContactAttribute($v){
        switch ($v) {
            case "0":
                return '未聯繫';
                break;
            case "1" : 
                return "已聯繫";
                break;
            
            default:
                return $v;
                break;
        }
    }
}
