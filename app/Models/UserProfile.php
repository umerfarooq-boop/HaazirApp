<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'full_name',
        'short_bio',
        'location',
        'contact_number',
        'user_image'
    ];    
}
