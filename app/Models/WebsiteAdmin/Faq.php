<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Model;
use App\Models\WebsiteAdmin\WebsiteCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'website_course_id',
    ];

    public function course()
    {
        return $this->hasOne(WebsiteCourse::class, 'id', 'website_course_id');
    }
}
