<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $primaryKey = "id_qr";
    protected $dates = ["started_at","submitted_at"];
    protected $table = "quiz_results";
    public $timestamps = false;

    public function student(){
        return $this->belongsTo('\App\User','student_id');
    }
    public function quiz(){
        return $this->belongsTo('\App\QuizOpen','open_id');
    }
    public function answers(){
        return $this->belongsToMany('App\Option','res_opt','qr_id','option_id');
    }

}
