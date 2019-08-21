<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    function user(){
        return $this->belongsTo("App\User", "user_id");
    }
}
