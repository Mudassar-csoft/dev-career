<?php

namespace App\Models\WebsiteAdmin;

use App\Models\WebsiteAdmin\Faq;
use App\Models\WebsiteAdmin\WebBatch;
use App\Models\WebsiteAdmin\Curriculam;
    use App\Models\CourseCategory;
    use App\Models\CourseWeek;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebsiteCourse extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'title',
        'program',
        'lecture',
        'duration',
        'session',
        'pdffile',
        'feature',
        'type',
        'second_image',
        'alt_1',
        'description',
        'course_categoryy', // Adjusted to match the column in your database
        'seo_title',
        'seo_discription',
        'classtype',
        'key_highlights',
        'achievements',
        'prerequisite'
    ];

    public function webbatch()
    {
        return $this->hasOne(WebBatch::class, 'website_course_id');
    }

    public function faq()
    {
        return $this->hasMany(Faq::class, 'website_course_id');
    }

    public function curriculam()
    {
        return $this->hasMany(Curriculam::class, 'course_id');
    }
    public function coursecat()
    {
        return $this->belongsTo(CourseCategory::class, 'course_categoryy', 'id');
    }
    public function courseWeeks()
    {
        return $this->hasMany(CourseWeek::class, 'course_id');
    }


}