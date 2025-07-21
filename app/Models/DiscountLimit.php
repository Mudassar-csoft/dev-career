<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountLimit extends Model
{
    use HasFactory;

    public function program(){
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

