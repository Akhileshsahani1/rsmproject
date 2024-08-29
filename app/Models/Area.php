<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table    = 'areas';
    protected $fillable = [
        'name',
        'region_id',
    ];

    public function subzones()
    {
        return $this->hasMany(SubZone::class);
    }

    public function jobs(){

        return $this->hasMany(Job::class,'area_id');
    }
    public function openjobs(){

        return $this->jobs()->where('open', '1')->where('status', 'approved')->count();
    }


}
