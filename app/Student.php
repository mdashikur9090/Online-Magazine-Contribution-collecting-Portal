<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function facultyInfo(){
    	return $this->belongsTo('App\Faculty', 'faculty_id', 'id');
    }
}
