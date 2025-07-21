<?php

namespace App\Models;

use App\Models\User;
use App\Models\State;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Program;
use App\Models\LeadFollowUp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $dates = [
        'next_follow_up'
    ];

 protected $fillable = [
        'user_id', 'status', 'name', 'program_id', 'primary_contact', 'guardian_contact', 'email', 'gender', 'country_id', 'city', 'area', 'marketing_source', 'campus_id', 'next_follow_up', 'probability', 'remarks'
    ];
    public function program()
    {
        return $this->hasOne(Program::class, 'id' , 'program_id');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id' , 'campus_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id' , 'country_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id' , 'state_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id' , 'user_id');
    }

    public function leadFollowUp()
    {
        return $this->hasMany(LeadFollowUp::class, 'lead_id');
    }
}
