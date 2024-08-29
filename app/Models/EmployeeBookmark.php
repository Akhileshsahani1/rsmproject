<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBookmark extends Model
{
    use HasFactory;

    protected $table = "employee_bookmarks";

    protected $fillable = [
        'employee_id',
        'user_id'
    ];

    public function employee(){

        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function employer(){

        return $this->belongsTo(USer::class,'user_id');
    }
}
