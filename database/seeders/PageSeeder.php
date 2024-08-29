<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'name'              => 'About Us', 
            'description'       => '<h2>About Us</h2><p>You can edit the content of this page from Admin > Pages.</p>', 
            'meta_title'        => 'Meta Title RSM', 
            'meta_description'  => 'Meta description RSM', 
            'meta_keywords'     => 'Meta Keywords RSM', 
        ]);

        Page::create([
            'name'              => 'Privacy Policy', 
            'description'       => '<h2>Privacy Policy</h2><p>You can edit the content of this page from Admin > Pages.</p>', 
            'meta_title'        => 'Meta Title RSM', 
            'meta_description'  => 'Meta description RSM', 
            'meta_keywords'     => 'Meta Keywords RSM', 
        ]);

        Page::create([
            'name'              => 'Terms & Conditions', 
            'description'       => '<h2>Terms & Conditions</h2><p>You can edit the content of this page from Admin > Pages.</p>', 
            'meta_title'        => 'Meta Title RSM', 
            'meta_description'  => 'Meta description RSM', 
            'meta_keywords'     => 'Meta Keywords RSM', 
        ]);
    }
}
