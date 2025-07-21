<?php

namespace App\Models;

use App\Models\Admission;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'program_type', 'title', 'course_code', 'diploma_code', 'certification_code', 'fee', 'duration', 'discount_limit', 'outline', 'prerequisite', 'remarks'
    ];

    public function admission()
    {
        return $this->hasMany(Admission::class, 'program_id');
    }

    public function lead()
    {
        return $this->hasMany(Lead::class, 'program_id');
    }
    public function discountLimits(){
        return $this->hasMany(DiscountLimit::class, 'program_id');
    }
}
