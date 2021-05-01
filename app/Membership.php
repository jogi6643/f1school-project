<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
   protected $table='memberships';

      protected $fillable = [
        'name','fee_per_student','course_list'
    ];
}
