<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    public function studentInfo(){
    	return $this->belongsTo('App\Student', 'student_id', 'user_id');
    }
}
