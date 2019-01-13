<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $primaryKey = "id_r";
    public $timestamps = false;

    public function module(){
        return $this->belongsTo('\App\Module');
    }
}
