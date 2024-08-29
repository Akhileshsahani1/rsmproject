<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PreferredClassification;

class PreferredClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = ['Accounting',
        'Administration & Office Support',
        'Advertising, Arts & Media',
        'Banking & Financial Services',
        'Call Centre & Customer Service',
        'CEO & General Management',
        'Community Services & Development',
        'Construction',
        'Consulting & Strategy',
        'Design & Architecture',
        'Education & Training',
        'Engineering',
        'Farming, Animals & Conservation',
        'Government & Defence',
        'Healthcare & Medical',
        'Hospitality & Tourism',
        'Human Resources & Recruitment',
        'Information & Communication Technology',
        'Insurance & Superannuation',
        'Legal',
        'Manufacturing, Transport & Logistics',
        'Marketing & Communications',
        'Mining, Resources & Energy',
        'Real Estate & Property',
        'Retail & Consumer Products',
        'Sales',
        'Science & Technology',
        'Self Employment',
        'Sport & Recreation',
        'Trades & Services',
    ];

    foreach($values as $value){
        PreferredClassification::create([
            'classification' => $value
        ]);
    }
        
    }
}
