<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module_context extends Model
{
    protected $primaryKey = "id_mc";
    public $timestamps = false;

    public function module(){
        return $this->belongsTo('\App\Module','module_id','id_mc');
    }

}
