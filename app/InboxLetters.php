<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class InboxLetters extends Model
{
    //
    protected $table = 'inbox_letters';
    protected $primaryKey = 'inbox_letter_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * 使用者搜尋信件
     *
     * @param  mixed $query
     * @param  mixed $title
     * @param  mixed $ctx
     * @param  mixed $user_id
     * @return void
     */
    public function scopeUserMailSearch($query,$title,$ctx,$user_id)
    {
        $sql = $query->where('user_id',$user_id);
        if(isset($title) && isset($ctx)){
            return $sql->where(function($q) use($title,$ctx) {
                            $q->where('title','like','%'.$title.'%')
                            ->orWhere('content','like','%'.$ctx.'%');
                        })->get();
        }else if(isset($title) && !isset($ctx)){
            return $sql->where('title','like','%'.$title.'%')->get();
        }else if(!isset($title) && isset($ctx)){
            return $sql->where('content','like','%'.$ctx.'%')->get();
        }else{
            return $sql->get();
        }
    }
}
