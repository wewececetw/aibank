<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letters extends Model
{
    protected $table = 'internal_letters';
    protected $primaryKey = "internal_letter_id";
    public $timestamps = false;
    protected $guarded = [];

    public function letters_user()
    {
        return $this->belongsTo('App\User','user_id');
    }

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
        $sql = $query->where('user_ids',$user_id);
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
    