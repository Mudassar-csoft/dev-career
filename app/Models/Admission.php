<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Registration;
use App\Models\FeeCollection;
use App\Models\CertificateCollectedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $dates = [
        'admission_date'
    ];

    protected $fillable = [
        'roll_number', 'user_id', 'registration_id', 'program_id', 'campus_id', 'batch_id', 'admission_date', 'fee_package', 'discount', 'status'
    ];

    public function registration()
    {
        return $this->hasOne(Registration::class, 'id' , 'registration_id');
    }

    public function program()
    {
        return $this->hasOne(Program::class, 'id' , 'program_id');
    }

    public function batch()
    {
        return $this->hasOne(Batch::class, 'id' , 'batch_id');
    }

    public function fee()
    {
        return $this->hasMany(FeeCollection::class, 'admission_id');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }

    public function collectedBy()
    {
        return $this->hasOne(CertificateCollectedBy::class, 'admission_id');
    }
}
