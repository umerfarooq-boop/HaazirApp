<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectricianAppointment extends Model
{
    protected $fillabel = ['electrician_p_id','user_p_id','e_problem_image','description','status','created_by'];
}
