<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'email',
        'dialcode',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'zipcode',
        'state',
        'iso2',
        'website',
        'logo',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'google_play_link',
        'apple_store_link',
        'description'
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class)->orderBy('id', 'desc');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class)->orderBy('id', 'desc');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orderBy('id', 'desc');
    }
}
