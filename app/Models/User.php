<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable // Employer
{
    use HasApiTokens, HasFactory, Notifiable, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'owner_name',
        'email',
        'dialcode',
        'phone',
        'password',
        'avatar',
        'address',
        'city',
        'state',
        'zipcode',
        'iso2',
        'status',
        'website',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('company_name')
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

    public function chats()
    {

        return $this->hasMany(Chat::class, 'user_id');
    }


    public function jobs()
    {

        return $this->hasMany(Job::class, 'employer_id')->where(['status' => 'approved']);
    }

    public function openjobs()
    {

        return $this->hasMany(Job::class, 'employer_id')->where(['open' => true, 'status' => 'approved']);
    }

    public function closejobs()
    {

        return $this->hasMany(Job::class, 'employer_id')->where(['open' => false]);
    }
}
