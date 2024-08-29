<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\Employee\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'firstname',
        'lastname',
        'email',
        'dialcode',
        'phone',
        'password',
        'avatar',
        'nationality',
        'gender',
        'address',
        'city',
        'state',
        'zipcode',
        'iso2',
        'status',
        'classification_id',
        'sub_classification_id',
        'external_link',
        'highest_education',
        'job_skill',
        'description',
        'profile_visibility'
    ];

    protected $casts = [
        'job_skill' => 'array'
    ];
    public function getJobSkillAttribute($value)
    {
        return ($value)?json_decode($value):[];
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['firstname', 'lastname'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKey()
    {
        return $this->slug;
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function preferredclassification(){

        return $this->belongsTo(PreferredClassification::class,'classification_id');
    }
    public function preferredsubclassification(){

        return $this->belongsTo(PreferredSubClassification::class,'sub_classification_id');
    }


}
