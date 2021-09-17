<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Web_contents_photos extends Model
{
    protected $table = 'web_contents_photos';
    protected $primaryKey = 'web_contents_photos_id';
    public $timestamps = false;
    protected $guarded  = [];

    public function storeNew($web_contents_id,$image_path)
    {
        $now = date('Y-m-d H:i:s');
        $this->web_contents_id = $web_contents_id;
        $this->image = $image_path;
        $this->created_at = $now;
        $this->updated_at = $now;
        $this->save();
    }

}
