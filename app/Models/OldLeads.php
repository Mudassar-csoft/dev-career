<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campus;
use App\Models\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OldLeads extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'program_id', 'campus_id', 'name', 'status', 'primary_contact', 'email'
    ];

    public function program()
    {
        return $this->hasOne(Program::class, 'id' , 'program_id');
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
