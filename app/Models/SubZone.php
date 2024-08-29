<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    use HasFactory;

    protected $table    = 'sub_zones';
    protected $fillable = [
        'name',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function jobs(){

        return $this->hasMany(Job::class,'sub_zone_id');
    }
    public function openjobs(){

        return $this->jobs()->where('open', '1')->where('status', 'approved')->count();
    }
}
