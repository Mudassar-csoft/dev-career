<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Admission;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeCollection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $dates = [
        'pay_date', 'admission_date', 'due_date',
    ];

    protected $fillable = [
        'registration_id', 'admission_id', 'user_id', 'campus_id', 'admission_date', 'installment_number', 'due_date', 'total_amount', 'registration_amount', 'paid_amount', 'pay_date', 'status', 'receipt_number', 'fee_type'
    ];

    public function registration()
    {
        return $this->hasOne(Registration::class, 'id' , 'registration_id');
    }
    public function admission()
    {
        return $this->hasOne(Admission::class, 'id' , 'admission_id');
    }
    public function campus()
    {
        return $this->hasOne(Campus::class, 'id' , 'campus_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id' , 'user_id');
    }
}
