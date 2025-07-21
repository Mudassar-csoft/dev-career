<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'company',
        'email',
        'code',
        'number',
        'status',
    ];
}
