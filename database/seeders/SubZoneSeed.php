<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\SubZone;



class SubZoneSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $SubZoneDatas = [
                        1=>[
                            1=>[
                                'Bishan East',
                                'Marymount',
                                'Upper Thomson'
                               ],
                            2=>[
                                'Alexandra Hill',
                                'Alexandra North',
                                'Bukit Ho Swee',
                                'Bukit Merah',
                                'City Terminals',
                                'Depot Road',
                                'Everton Park',
                                'Henderson Hill',
                                'Kampong Tiong Bahru',
                                'Maritime Square',
                                'Redhill',
                                'Singapore General Hospital	',
                                'Telok Blangah Drive',
                                'Telok Blangah Rise	',
                                'Telok Blangah Way',
                                'Tiong Bahru',
                                'Tiong Bahru Station',
                            ],
                            3=>[
                                'Anak Bukit	',
                                'Coronation Road',
                                'Farrer Court',
                                'Hillcrest',
                                'Holland Road',
                                'Leedon Park',
                                'Swiss Club	',
                                'Ulu Pandan',
                            ],
                            4=>[
                                'Anson',
                                'Bayfront Subzone',
                                'Bugis',
                                'Cecil',
                                'Central Subzone',
                                'City Hall',
                                'Clifford Pier',
                                'Marina Centre',
                                'Maxwell',
                                'Nicoll	',
                                'Phillip',
                                'Raffles Place',
                                'Tanjong Pagar',
                            ],
                            5=>[
                                "Aljunied",
                                "Geylang East",
                                "Kallang Way",
                                "Kampong Ubi",
                                "MacPherson",
                            ],
                            6=>[
                                "Bendemeer",
                                "Boon Keng",
                                "Crawford",
                                "Geylang Bahru",
                                "Kallang Bahru",
                                "Kampong Bugis",
                                "Kampong Java",
                                "Lavender",
                                "Tanjong Rhu",
                            ],
                            7=>[
                                'Marina East'
                            ],
                            8=>[
                                'Marina South'
                            ],
                            9=>[
                                "East Coast",
                                "Katong",
                                "Marina East",
                                "Marine Parade",
                                "Mountbatten",
                            ],
                            10=>[
                                'Bras Basah',	
                            ' Dhoby Ghaut',	
                                'Fort Canning',
                            ],
                            11=>[
                                "Cairnhill",
                                "Goodwood Park",
                                "Istana Negara",
                                "Monk's Hill",
                                "Newton Circus",
                                "Orange Grove",
                            ],
                            12=>[
                                "Balestier",
                                "Dunearn",
                                "Malcolm",
                                "Moulmein",
                                "Mount Pleasant",
                            ],
                            13=>[
                                "Boulevard",	
                                "Somerset",
                                "Tanglin",
                            ],
                            14=>[
                                "China Square",
                                "Chinatown",
                                "Pearl's Hill",
                                "People's Park",
                            ],
                            15=>[
                                "Commonwealth",
                                "Dover",
                                "Ghim Moh",
                                "Holland Drive",
                                "Kent Ridge",
                                "Margaret Drive",
                                "Mei Chin",
                                "National University of Singapore",
                                "one-north",
                                "Pasir Panjang",
                                "Pasir Panjang ",
                                "Port",
                                "Queensway",
                                "Singapore Polytechnic",
                                "Tanglin Halt"
                            ],
                        
                            16=>[
                                "Institution Hill",
                                "Leonie Hill",
                                "One Tree Hill",
                                "Oxley",
                                "Paterson",
                            ],
                            17=>[
                                "Bencoolen",
                                "Farrer Park",
                                "Kampong Glam",
                                "Little India",
                                "Mackenzie",
                                "Mount Emily",
                                "Rochor Canal",
                                "Selegie",
                                "Sungei Road",
                                "Victoria",
                            ],
                            18=>[
                                "Boat Quay",
                                "Clarke Quay",
                                "Robertson Quay",
                            ],
                            29=>[
                                'Sentosa',
                                'Southern Group',
                            ],
                            20=>[
                                'Straits View',
                            ],
                            21=>[
                                "Chatsworth",
                                "Nassim",
                                "Ridout",
                                "Tyersall",
                            ],
                            22=>[
                                "Bidadari",
                                "Boon Teck",
                                "Braddell",
                                "Joo Seng",
                                "Kim Keat",
                                "Lorong 8 Toa Payoh",
                                "Pei Chun",
                                "Potong Pasir",
                                "Sennett",
                                "Toa Payoh Central",
                                "Toa Payoh West",
                                "Woodleigh",
                            ],
                        ],
                        // central Region end 
                        //East Region start 
                        2=> [
                                1=>[
                                    "Bayshore",
                                    "Bedok North",
                                    "Bedok Reservoir",
                                    "Bedok South",
                                    "Frankel",
                                    "Kaki Bukit",
                                    "Kembangan",
                                    "Siglap",
                                ],
                                2=>[
                                    "Changi Airport",
                                    "Changi Point",
                                    "Changi West",
                                ],
                                3=>[
                                    "Changi Bay",
                                ],
                                4=>[
                                    "Flora Drive",
                                    "Loyang East",
                                    "Loyang West",
                                    "Pasir Ris Central",
                                    "Pasir Ris Drive",
                                    "Pasir Ris Park",
                                    "Pasir Ris Wafer Fab Park",
                                    "Pasir Ris West",
                                ],
                                5=>[
                                    "Airport Road",
                                    "Paya Lebar East",
                                    "Paya Lebar North",
                                    "Paya Lebar West",
                                    "PLAB",
                                ],
                                6=>[
                                    "Simei",
                                    "Tampines East",
                                    "Tampines North",
                                    "Tampines West",
                                    "Xilin",
                                ],
                            ],
                            
                            // North Region start
                       
                        3=>[
                            1=>[
                                "Central Water Catchment",
                            ],
                            2=>[
                                "Lim Chu Kang",
                            ],
                            3=>[
                                "Mandai East",
                                "Mandai Estate",
                                "Mandai West",
                            ],
                            4=>[
                                "Admiralty",
                                "Sembawang Central",
                                "Sembawang East	",
                                "Sembawang North",
                                "Sembawang Springs",
                                "Sembawang Straits",
                                "Senoko North",
                                "Senoko South",
                                "The Wharves",
                            ],
                            5=>[
                                "Pulau Seletar",		
                                "Simpang North",		
                                "Simpang South",		
                                "Tanjong Irau",
                            ],
                            6=>[
                                "Gali Batu",
                                "Kranji",
                                "Pang Sua",
                                "Reservoir View",
                                "Turf Club",
                            ],
                            7=>[
                                "Greenwood Park",
                                "Midview",
                                "North Coast",
                                "Senoko West",
                                "Woodgrove",
                                "Woodlands East	",
                                "Woodlands Regional Centre",
                                "Woodlands South",
                                "Woodlands West",
                            ],
                            8=>[
                                    "Khatib",
                                    "Lower Seletar",
                                    "Nee Soon",
                                    "Northland",
                                    "Springleaf	",
                                    "Yishun Central",
                                    "Yishun East",
                                    "Yishun South",
                                    "Yishun West",
                            ],
                        ],
                            // North-East Region start
                        4=>[
                            1=>[
                                "Ang Mo Kio Town Centre",
                                "Cheng San",
                                "Chong Boon	",
                                "Kebun Bahru",
                                "Sembawang Hills",
                                "Shangri-La",
                                "Tagore",
                                "Townsville",
                                "Yio Chu Kang",
                                "Yio Chu Kang East",
                                "Yio Chu Kang North",
                                "Yio Chu Kang West",
                            ],
                            2=>[
                                "Defu Industrial Park",
                                "Hougang Central",
                                "Hougang East",
                                "Hougang West",
                                "Kangkar",
                                "Kovan",
                                "Lorong Ah Soo",
                                "Lorong Halus",
                                "Tai Seng",
                                "Trafalgar",
                            ],
                            3=>[
                                "North-Eastern Islands",
                            ],
                            4=>[
                                "Coney Island",
                                "Matilda",
                                "Northshore",
                                "Punggol Canal",
                                "Punggol Field",
                                "Punggol Town Centre",
                                "Waterway East",
                            ],
                            5=>[
                                "Pulau Punggol Barat",
                                "Pulau Punggol Timor",
                                "Seletar",
                                "Seletar Aerospace Park",
                            ],
                            6=>[
                                "Anchorvale",
                                "Compassvale",
                                "Fernvale",
                                "Lorong Halus North",
                                "Rivervale",
                                "Sengkang Town Centre",
                                "Sengkang West",
                            ],
                            7=>[
                                "Lorong Chuan",
                                "Seletar Hills",
                                "Serangoon Central",
                                "Serangoon Garden",
                                "Serangoon North",
                                "Serangoon North Industrial Estate",
                                "Upper Paya Lebar",
                            ],
                        ],
                            // West Region start
                        5=>[
                            1=>[
                                "Liu Fang",
                                "Samulun",
                                "Shipyard",
                                "Tukang",
                            ],
                            2=>[
                                "Brickworks", 
                                "Bukit Batok Central", 
                                "Bukit Batok East", 
                                "Bukit Batok West", 
                                "Bukit Batok South", 
                                "Gombak", 
                                "Guilin", 
                                "Hillview", 
                                "Hong Kah North", 
                            ],
                            3=>[
                                "Bangkit",
                                "Dairy Farm",
                                "Fajar",
                                "Jelebu	",
                                "Nature Reserve",
                                "Saujana",
                                "Senja",
                            ],
                            4=>[
                                "Choa Chu Kang Central",
                                "Choa Chu Kang North",
                                "Keat Hong",
                                "Peng Siang",
                                "Teck Whye",
                                "Yew Tee",
                            ],
                            5=>[
                                "Clementi Central",
                                "Clementi North",
                                "Clementi West",
                                "Clementi Woods",
                                "Faber",
                                "Pandan",
                                "Sunset Way",
                                "Toh Tuck",
                                "West Coast",
                            ],
                            6=>[
                                "International Business Park",
                                "Jurong Gateway",
                                "Jurong Port",
                                "Jurong River",
                                "Lakeside (Business)",
                                "Lakeside (Leisure)	",
                                "Penjuru Crescent",
                                "Teban Gardens",
                                "Toh Guan",
                                "Yuhua East",
                                "Yuhua West",
                            ],
                            7=>[
                                "Boon Lay Place",
                                "Chin Bee",
                                "Hong Kah",
                                "Jurong West Central",
                                "Kian Teck",
                                "Safti",
                                "Taman Jurong",
                                "Wenya",
                                "Yunnan",
                            ],
                            8=>[
                                "Benoi Sector",
                                "Gul Basin",
                                "Gul Circle",
                                "Joo Koon",
                                "Pioneer Sector",
                            ],
                            9=>[
                                "Brickland	",
                                "Forest Hill",
                                "Garden",
                                "Park",
                                "Plantation",
                                "Tengah Industrial Estate",
                            ],
                            10=>[
                                "Tengeh",
                                "Tuas Bay",
                                "Tuas North",
                                "Tuas Promenade",
                                "Tuas View",
                                "Tuas View Extension",
                            ],
                            11=>[
                                "Jurong Island and Bukom",
                                "Semakau",
                                "Sudong",
                            ],
                            12=>[
                                "Bahar",
                                "Cleantech",
                                "Murai",
                            ]
                        ],
                    ];

                    // $areas = Area::get();
                    // foreach($areas as $area)
                    // {
                    //     foreach($SubZoneDatas as $SubZoneData )
                    //     SubZone::create([
                    //         'area_id'=>$area->id,
                    //         'name'=>$SubZoneData
                    //     ]);
                    // }

                    foreach ($SubZoneDatas as $areaId => $subZones) {
                        $area = Area::find($areaId);
                        
                        if ($area) {
                            foreach ($subZones as $subZoneArray) {
                                foreach ($subZoneArray as $subZoneName) {
                                    SubZone::create([
                                        'area_id' => $area->id,
                                        'name' => $subZoneName
                                    ]);
                                }
                            }
                        }
                    }
                
    }
}
