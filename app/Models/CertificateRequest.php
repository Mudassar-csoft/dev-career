<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'admission_id',
        'requested_id',
        'campus_id',
        'soft_copy',
        'hard_copy',
        'approve_id',
        'status',
        'email',
        'contact'
    ];

    public function admission()
    {
        return $this->hasOne(Admission::class, 'id' , 'admission_id');
    }
    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }
    public function approve_id()
    {
        return $this->hasOne(User::class, 'id', 'approve_id');
    }

}
