<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    public function order_tenders()
    {
        return $this->belongsTo('App\Tenders','order_id');
    }
    public function order_user()
    {
        return $this->belongsTo('App\User',
                                'App\Tenders',
                                'user_id',
                                'user_id',
                                'order_id',
                                'order_id');
    }

    public function getUserOrder($user_id)
    {
        /*
        $data = DB::select("SELECT
                                o.*,
                                (
                                    select count(tender_documents_id) from tender_documents where order_id = o.order_id
                                ) as tenders_count
                            FROM
                                orders AS o
                            LEFT JOIN users AS u
                            ON
                                u.virtual_account = o.virtual_account
                            WHERE
                                u.user_id = $user_id");
        $ar = [];
        foreach ($data as $d) {
           $a = [];
           foreach ($d as $key => $value) {
               $a[$key] = $value;
           }
           array_push($ar,$a);
        }
        */
        /*
        $data = DB::select("SELECT 
                        sum(o.expected_amount) expected_amount , sum(o.actual_amount) actual_amount , count(*) tenders_count , t.paid_at,o.order_id
                    FROM
                        users u,tender_documents t ,orders o
                    WHERE
                        t.user_id = u.user_id and t.order_id = o.order_id and u.user_id = '".$user_id."' and tender_document_state in(1,2,4,5) group by t.paid_at ");
*/
        $data = DB::select("SELECT 
            o.*, 1 tenders_count
        FROM
            users u,tender_documents t ,orders o
        WHERE
            t.user_id = u.user_id and t.order_id = o.order_id and u.user_id = '".$user_id."' and o.virtual_account > 0 order by DATE_FORMAT(o.created_at, '%Y-%m-%d') desc");
        $ar = [];
        foreach ($data as $d) {
           $a = [];
           foreach ($d as $key => $value) {
               $a[$key] = $value;
           }
           array_push($ar,$a);
        }
        return $ar;
    }
}
