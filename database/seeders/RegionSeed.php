<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;


class RegionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Regions = [
             'Central Region',
             'East Region',
             'North Region',
             'North-East Region',
             'West Region',
        ];

       foreach($Regions as $Region)
        {
            Region::create([
                'name'=>$Region
            ]);

        }
    }
}
