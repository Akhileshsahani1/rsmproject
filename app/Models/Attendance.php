<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'job_id',
        'date',
        'clock_in',
        'clock_out',
        'status'
    ];

    public function job(){
        return $this->hasOne(Job::class,'id','job_id');
    }
    public function employer(){
        return $this->hasOne(User::class,'id','employer_id');
    }
}
