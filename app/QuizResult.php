<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $primaryKey = "id_qr";
    protected $table = "quiz_results";
    public $timestamps = false;

    public function student(){
        return $this->belongsTo('\App\User','student_id');
    }
    public function quiz(){
        return $this->belongsTo('\App\Quiz','quiz_id');
    }
    public function group(){
        return $this->belongsTo('\App\Group','group_id');
    }
}
