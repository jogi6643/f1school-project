<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
     public function students()
    {
        return $this->hasMany('App\Model\Student');
    }
}
