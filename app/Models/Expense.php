<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $dates = ['payment_date'];
    protected $fillable = [
        'payee_id',
        'expense_type_id',
        'payment_date',
        'payment_method',
        'user_id',
        'campus_id',
        'ref_no',
        'amount',
        'remarks',
    ];
    function payee()
    {
        return $this->hasOne(Payee::class,'id','payee_id');
    }
    function expensetype()
    {
        return $this->hasOne(ExpenseType::class,'id','expense_type_id');
    }
}
