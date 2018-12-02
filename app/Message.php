<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = "id_m";

    public function receivers(){
        return $this->belongsToMany('App\User','mes_use','message_id','user_id')->withPivot('seen');
    }
}
