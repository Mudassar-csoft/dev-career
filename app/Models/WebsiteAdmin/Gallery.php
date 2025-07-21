<?php

namespace App\Models\WebsiteAdmin;

use App\Models\Campus;
use App\Models\Gallerytag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
     protected $fillable = [
        'cumpus_id',
        'title',
        'Catagory',
        'description',
        'images',
        ''
    ];


    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }
    public function tags(){
        return $this->hasOne(Gallerytag::class,'id','category');
    }
   
}
