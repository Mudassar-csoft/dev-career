<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'campus_id',
        'name',
    ];

    function user()
    {
        return $this->hasOne(User::class,'id','user_id');

    }
    function campus()
    {
        return $this->hasOne(Campus::class,'id','campus_id');
    }
}
