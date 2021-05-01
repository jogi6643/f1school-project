<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

    public function type()
    {
    	return $this->belongsTo('App\DocType','doc_types_id');
    }
    public function csm()
    {
    	return $this->belongsTo('App\CourseMaster','course_masters_id');
    }
}
