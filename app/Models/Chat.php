<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'employee_id',
        'user_id',
        'active'
    ];

    public function messages(){

        return $this->hasMany(Message::class,'chat_id');
    }
    public function employee(){

        return $this->belongsTo(Employee::class,'employee_id');
    }
    public function employer(){

        return $this->belongsTo(User::class, 'user_id');
    }
    public function job(){

        return $this->belongsTo(Job::class,'job_id');
    }
    
    public function recentmessage(){

        return $this->hasOne(Message::class, 'chat_id')->latestOfMany();
    }
   

}
