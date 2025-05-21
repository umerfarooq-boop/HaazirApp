<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlumberAppointment extends Model
{
    protected $fillable = [
        'plumber_p_id',
        'user_p_id',
        'p_problem_image',
        'description',
        'status',
        'created_by',
    ];    
}
