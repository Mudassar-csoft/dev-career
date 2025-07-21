<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityBills extends Model
{
    use HasFactory;
    protected $fillable=[
        'issuedate','duedate',	'month','payableamountwithinduedate',	'fine',	'payableamount',	'paymentmethode',	'paymentrefferencenumber',	'remarks','billtype','bill_refference_number','campus_id'
    ];
  public  function campus()
    {
        return $this->hasOne(Campus::class,'id','campus_id');
    }
  public  function refferencenumber()
    {
        return $this->hasOne(RefferenceNumber::class,'id','bill_refference_number');
    }
  public  function billtyp()
    {
        return $this->hasOne(BillType::class,'id','billtype');
    }
}
