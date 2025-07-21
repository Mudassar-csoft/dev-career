<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRefferenceNumber extends Model
{
    use HasFactory;
    protected $fillable=[
        'number','campus_id'
    ];
    public function campus(){
        return $this->hasOne(Campus::class,'id','campus_id');
    }
}
