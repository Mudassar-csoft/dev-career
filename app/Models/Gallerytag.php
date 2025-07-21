<?php

namespace App\Models;

use App\Models\WebsiteAdmin\Gallery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallerytag extends Model
{
    public $table='gallery_tags';
    use HasFactory;
      public function galleries(){
        return $this->hasMany(Gallery::class, 'catagory', 'id');
    }
    
}
