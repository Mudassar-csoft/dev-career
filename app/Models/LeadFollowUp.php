<?php

namespace App\Models;

use App\Models\Lead;
use App\Models\Campus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadFollowUp extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'lead_id', 'follow_up_method', 'status', 'next_follow_up', 'remarks', 'probability'
    ];

    public function lead()
    {
        return $this->hasOne(Lead::class, 'id', 'lead_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id' , 'user_id');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id' , 'campus_id');
    }
}
