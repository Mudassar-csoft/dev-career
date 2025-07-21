<?php

namespace App\Models;

use App\Models\Campus;
use App\Models\Program;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $dates = ['start_date'];

    protected $fillable = [
        'user_id', 'program_id', 'campus_id', 'employee_id', 'start_date', 'end_date', 'session', 'start_time', 'end_time', 'lab', 'remarks'
    ];

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id' , 'campus_id');
    }

    public function program()
    {
        return $this->hasOne(Program::class, 'id' , 'program_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id' , 'employee_id');
    }
}
