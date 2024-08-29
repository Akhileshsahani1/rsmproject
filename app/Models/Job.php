<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'position_name',
        'classification_id',
        'sub_classification_id',
        'location',
        'region_id',
        'area_id',
        'sub_zone_id',
        'latitude',
        'longitude',
        'no_of_position',
        'description',
        'benefits',
        'postion_type',
        'shift_type',
        'career_level',
        'gender',
        'contract_days',
        'salary_type',
        'start',
        'end',
        'education',
        'skills_required',
        'working_days',
        'working_hours',
        'salary_from',
        'salary_upto',
        'status',
        'open',
        'hide_salary'
    ];

    protected $casts = [
        'skills_required' => 'array',
        'working_days'    => 'array',
        'working_hours'   => 'array',
    ];

    public function employer(){

        return $this->belongsTo(User::class,'employer_id');
    }

    public function region(){

        return $this->belongsTo(Region::class,'region_id');
    }

    public function area(){

        return $this->belongsTo(Area::class,'area_id');
    }
 
    public function subzone(){

        return $this->belongsTo(SubZone::class,'sub_zone_id');
    }
    public function preferredclassification(){

        return $this->belongsTo(PreferredClassification::class,'classification_id');
    }
    public function preferredsubclassification(){

        return $this->belongsTo(PreferredSubClassification::class,'sub_classification_id');
    }
    public function appliedjobs(){

        return $this->hasMany(ApplyJob::class,'job_id');
    }
    public function employeeexist(){
        if(Auth::guard('employee')->user()){
         return $this->appliedjobs()->where('employee_id', Auth::guard('employee')->user()->id)->first();
        }
        return [];
    }

    public function bookmarks(){
        return $this->hasMany(JobBookmarks::class,'job_id');
    }


    public function applies(){
        return $this->hasMany(ApplyJob::class,'job_id','id');
    }
}
