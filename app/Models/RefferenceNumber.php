<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefferenceNumber extends Model
{
    use HasFactory;
    protected $fillable=['refferencenumber','campus_id','billtype_id'];
    public function billType(){
        return $this->hasOne(BillType::class,'id','billtype_id');
    }
    public function campus(){
        return $this->hasOne(Campus::class,'id','campus_id');
    }
}
