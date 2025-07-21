<?php

namespace App\Models\WebsiteAdmin;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $dates = ['event_date', 'event_time'];
    protected $filable= [
        'title',
        'campus_id',
        'event_date',
        'event_time',
        'event_days',
        'first_image',
        'second_image',
        'description',
    ];


    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }
}
