<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambassador extends Model
{
    use HasFactory;
    protected $table = 'ambassador';
    protected $fillable = [
        'name',
        'contact',
        'email',
        'linkedin',
        'city',
        'organization',
        'file',
        'education',
    ];
}
