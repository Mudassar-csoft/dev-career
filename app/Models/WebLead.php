<?php

namespace App\Models;

use App\Models\State;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebLead extends Model
{
    use HasFactory;
    protected $table="web_leads";
    protected $dates = ["dob"];
    protected $guarded = ['id'];
    protected $fillabe=[
        'id',
        'name',
        'course',
        'primary_contact',
        'campus_id',
        'gender',
        'email',
        'country_id',
        'state_id',
        'city',
        'dob',
        'status',
        'type',
        'education',
        'question_or_comment',
        'guardian_name',
        'guardian_contact',
        'postal_address',
        'remarks',
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



}

