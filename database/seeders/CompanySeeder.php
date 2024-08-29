<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use App\Models\Quickbook;
use App\Models\Service;
use App\Models\SubService;
use App\Models\TaxRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        CompanySetting::create([
            'company'           => 'RSM Pte. Ltd.',
            'email'             => 'enquiry@rsm.n2rdev.in',
            'dialcode'          => '+65',
            'phone'             => '63841151',
            'address_line_1'    => '160 Paya Lebar Rd #03-07',  
            'address_line_2'    => 'Orion@Payalebar',             
            'city'              => 'Payalebar',
            'zipcode'           => '409022',
            'state'             => 'East Region',
            'iso2'              => 'sg',
            'website'           => 'http://rsm.n2rdev.in/',
            'logo'              => Null,
            'facebook_link'     => 'https://www.facebook.com/',
            'instagram_link'    => 'https://instagram.com/',
            'twitter_link'      => 'https://twitter.com/',
            'linkedin_link'     => 'https://www.linkedin.com/',
            'google_play_link'  => 'https://play.google.com/store/apps',
            'apple_store_link'    => 'https://www.apple.com/in/app-store/',
            'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        ]);
    }
}
