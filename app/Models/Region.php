<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table    = 'regions';
    protected $fillable = ['name'];

    public function jobs(){

        return $this->hasMany(Job::class,'region_id');
    }
    public function openjobs(){

        return $this->jobs()->where('open', '1')->where('status', 'approved')->count();
    }
}
