<?php

namespace App\Models;

use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'campus_title', 'campus_code', 'country', 'state', 'city', 'city_abbreviation', 'campus_landline_number', 'campus_mobile_number', 'campus_email_address', 'campus_address', 'labs_in_campus', 'status', 'campus_type', 'owner_cnic', 'rent_deed', 'building_map', 'electricity_bill', 'building_front', 'building_right_side', 'building_left_side', 'remarks'
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'campus_id');
    }
    public function lead()
    {
        return $this->hasMany(User::class, 'id', 'campus_id');
    }

}
