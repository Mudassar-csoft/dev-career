<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoworkingSpace extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',       // Be cautious with mass-assigning 'id'
        'name',
        'email',
        'contact',
        'city',
        'space',
        'no_of_persons',
    ];
    
}
