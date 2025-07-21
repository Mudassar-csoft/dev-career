<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $table="blog";
    use HasFactory;
    protected $fillable = ['title', 'catid', 'discription', 'fimage', 'tagid'];
    public function tags()
    {
        return $this->hasMany(BlogTags::class,'tagid');
    }
    
     public function blogcate()
    {
        return $this->belongsTo(BlogCategory::class, 'catid', 'id');
    }
      public function blogTag()
    {
        return $this->belongsTo(BlogTags::class, 'tagid', 'id');
    }
    
 
}
