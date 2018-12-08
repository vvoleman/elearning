<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model{
    public $timestamps = false;
    protected $primaryKey = "id_c";

    public function owner(){
        return $this->belongsTo('App\User',"owner_id");
    }
}
