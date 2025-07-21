<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldAdmission extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'roll_number', 'cnic', 'email', 'course', 'primary_contact', 'batch', 'campus', 'status'
    ];
}
