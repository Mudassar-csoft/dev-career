<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyAbroad extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'study',
        'number',
        'eamil',
        'city',
        'degree',

    ];
}
