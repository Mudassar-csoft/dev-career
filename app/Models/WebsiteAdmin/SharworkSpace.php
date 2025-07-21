<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharworkSpace extends Model
{
    use HasFactory;
    protected $dates = ['dob'];
    protected $fillable = [
        'name',
        'number',
        'email',
        'location',
        'type',
        'dob',
    ];
}
