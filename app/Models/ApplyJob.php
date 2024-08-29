<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'job_id',
        'status',
    ];

    public function employee(){

        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function job(){

        return $this->belongsTo(Job::class,'job_id');
    }

}
