<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'title', 'user_id', 'campus_id', 'status', 'primary_contact', 'cnic', 'email', 'dob', 'religion', 'gender', 'marital_status', 'postal_address', 'designation', 'basic_salary', 'hiring_date', 'employee_type', 'related_document', 'profile_picture'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id' , 'user_id');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id' , 'campus_id');
    }

}
