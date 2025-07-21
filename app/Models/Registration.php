<?php

namespace App\Models;

use App\Models\Campus;
use App\Models\Admission;
use App\Models\FeeCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $dates = ['dob', 'created_at'];

    protected $fillable = [
        'name', 'user_id', 'registration_number', 'primary_contact', 'guardian_name', 'guardian_contact', 'cnic', 'email', 'address', 'dob', 'gender', 'education', 'remarks'
    ];

    public function admission()
    {
        return $this->hasMany(Admission::class, 'registration_id');
    }
    public function fee()
    {
        return $this->hasMany(FeeCollection::class, 'registration_id');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }
}
