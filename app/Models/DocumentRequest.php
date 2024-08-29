<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
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
}
