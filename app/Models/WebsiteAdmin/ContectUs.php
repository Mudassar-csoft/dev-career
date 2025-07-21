<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContectUs extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'email',
        'subject',
        'number',
        'remaks',
    ];
}
