<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTags extends Model
{
    use HasFactory;
    protected $fillable = ['tags'];
    public $table='blogtags';
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
