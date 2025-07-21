<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAndCareer extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'company',
        'workplace',
        'location',
        'job_type',
        'experience',
        'education',
        'deadline',
        'description',
        'duties',
        'requirements',
        'status'
    ];
}
