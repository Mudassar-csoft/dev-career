<?php

namespace App\Models\WebsiteAdmin;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Model;
use App\Models\WebsiteAdmin\WebsiteCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebBatch extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $dates = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    protected $fillable = [
        'status',
        'website_course_id',
        'start_date',
        'end_date',
        'session',
        'start_time',
        'end_time',
        'campus_id',
    ];

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }

    public function webcourse()
    {
        return $this->hasOne(WebsiteCourse::class, 'id', 'website_course_id');
    }
}
