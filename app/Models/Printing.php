<?php

namespace App\Models;

use App\Models\CertificateCollectedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Printing extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'admission_id',
        'count',
        'approve_id',
        'status'
    ];

    public function admission()
    {
        return $this->hasOne(Admission::class, 'id', 'admission_id');
    }

    public function approve_id()
    {
        return $this->hasOne(User::class, 'id', 'approve_id');
    }

    public function collected()
    {
        return $this->hasOne(CertificateCollectedBy::class, 'printing_id');
    }
}
