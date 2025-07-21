<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Model;
use App\Models\WebsiteAdmin\WebsiteCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curriculam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title', 
        'duration',
        'tool',
        'description',
    ];

    public function course()
    {
        return $this->hasOne(WebsiteCourse::class, 'id', 'course_id');
    }

}
