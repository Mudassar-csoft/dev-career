<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateCollectedBy extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'contact',
        'remarks',
        'user_id',
        'admission_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id' , 'user_id');
    }
}
