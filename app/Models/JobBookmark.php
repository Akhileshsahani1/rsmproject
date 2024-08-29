<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBookmark extends Model
{
    use HasFactory;

    protected $table = "job_bookmarks";

    protected $fillable = [
        'job_id',
        'employee_id'
    ];

    public function employee(){

        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function job(){

        return $this->belongsTo(Job::class,'job_id');
    }

}
