<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPlacement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'number',
        'email',
        'city',
        'education',
        'file',
    ];

}
