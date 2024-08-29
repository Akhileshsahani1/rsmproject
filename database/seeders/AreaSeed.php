<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Area;



class AreaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Areas = [
                   1=> [
                            'Bishan',
                            'Bukit Merah',
                            'Bukit Timah',
                            'Downtown Core',
                            'Geylang', 
                            'Kallang',
                            'Marina East',
                            'Marina South',
                            'Marine Parade',
                            'Museum',
                            'Newton',
                            'Novena',
                            'Orchard',
                            'Outram',
                            'Queenstown',
                            'River Valley',
                            'Rochor',
                            'Singapore River',
                            'Southern Islands',
                            'Straits View',
                            'Tanglin',
                            'Toa Payoh',
                        ],
                    2=> [
                            'Bedok',
                            'Changi',
                            'Changi Bay',
                            'Pasir Ris',
                            'Paya Lebar',
                            'Tampines'
                        ],                   
                    3=> [
                            'Lim Chu Kang',
                            'Central Water Catchment',
                            'Mandai',
                            'Sembawang',
                            'Simpang',
                            'Sungei Kadut',
                            'Woodlands',
                            'Yishun',
                        ],
                    4=> [
                            'Ang Mo Kio',
                            'Hougang',
                            'North-Eastern Islands',
                            'Punggol',
                            'Seletar',
                            'Sengkang',
                            'Serangoon',
                            
                        ],
                    5=> [
                            'Boon Lay',
                            'Bukit Batok',
                            'Bukit Panjang',
                            'Choa Chu Kang',
                            'Clementi',
                            'Jurong East',
                            'Jurong West',
                            'Pioneer',
                            'Tengah',
                            'Tuas',
                            'Western Islands',
                            'Western Water Catchment'
                            
                        ],
                   

           ];

          $Regions = Region::get();

           foreach ($Regions as $Region) {
            $RegionId = $Region->id;
        
            if (isset($Areas[$RegionId])) {
                $AreasDatas = $Areas[$RegionId];
        
                foreach ($AreasDatas as $AreasData) {
                    Area::create([
                        'region_id' => $RegionId,
                        'name' => $AreasData,
                    ]);
                }
            }
        }
    }
}
