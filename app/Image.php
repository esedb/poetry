<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id'];

    public function article(){
        $this->belongsTo('App\Article', 'image_id');
    }
}
