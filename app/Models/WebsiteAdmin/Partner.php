<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
   use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'email',
        'city',
        'discription', // Add 'discription' if you are storing it in the database
    ];


}
