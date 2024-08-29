<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\SubZone;

class ResourceSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $region1 = Region::create([
            'id' => 1,
            'name' => 'Central Region',
        ]);

        $area1 = Area::create(['region_id' => 1, 'name' => 'Bishan']);
        $subzones1 = ['Bishan East',
        'Marymount',
        'Upper Thomson'];
        foreach($subzones1 as $subzone1){
            SubZone::create([
                'area_id'   => 1,
                'name'      => $subzone1
            ]);
        }

        $area2 = Area::create(['region_id' => 1, 'name' => 'Bukit Merah']);
        $subzones2 = ['Alexandra Hill',
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
        'Tiong Bahru Station'];
        foreach($subzones2 as $subzone2){
            SubZone::create([
                'area_id'   => 2,
                'name'      => $subzone2
            ]);
        }

        $area3 = Area::create(['region_id' => 1, 'name' => 'Bukit Timah']);
        $subzones3 = ['Anak Bukit',
        'Coronation Road',
        'Farrer Court',
        'Hillcrest',
        'Holland Road',
        'Leedon Park',
        'Swiss Club	',
        'Ulu Pandan'];
        foreach($subzones3 as $subzone3){
            SubZone::create([
                'area_id'   => 3,
                'name'      => $subzone3
            ]);
        }

        $area4 = Area::create(['region_id' => 1, 'name' => 'Downtown Core']);
        $subzones4 = ['Anson',
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
        'Tanjong Pagar'];
        foreach($subzones4 as $subzone4){
            SubZone::create([
                'area_id'   => 4,
                'name'      => $subzone4
            ]);
        }

        $area5 = Area::create(['region_id' => 1, 'name' => 'Geylang',]);
        $subzones5 = ["Aljunied",
        "Geylang East",
        "Kallang Way",
        "Kampong Ubi",
        "MacPherson"];
        foreach($subzones5 as $subzone5){
            SubZone::create([
                'area_id'   => 5,
                'name'      => $subzone5
            ]);
        }

        $area6 = Area::create(['region_id' => 1, 'name' => 'Kallang']);
        $subzones6 = ["Bendemeer",
        "Boon Keng",
        "Crawford",
        "Geylang Bahru",
        "Kallang Bahru",
        "Kampong Bugis",
        "Kampong Java",
        "Lavender",
        "Tanjong Rhu"];
        foreach($subzones6 as $subzone6){
            SubZone::create([
                'area_id'   => 6,
                'name'      => $subzone6
            ]);
        }

        $area7 = Area::create(['region_id' => 1, 'name' => 'Marina East']);
        $subzones7 = ['Marina East'];
        foreach($subzones7 as $subzone7){
            SubZone::create([
                'area_id'   => 7,
                'name'      => $subzone7
            ]);
        }

        $area8 = Area::create(['region_id' => 1, 'name' => 'Marina South']);
        $subzones8 = ['Marina South'];
        foreach($subzones8 as $subzone8){
            SubZone::create([
                'area_id'   => 8,
                'name'      => $subzone8
            ]);
        }

        $area9 = Area::create(['region_id' => 1, 'name' => 'Marine Parade']);
        $subzones9 = ["East Coast",
        "Katong",
        "Marina East",
        "Marine Parade",
        "Mountbatten"];
        foreach($subzones9 as $subzone9){
            SubZone::create([
                'area_id'   => 9,
                'name'      => $subzone9
            ]);
        }

        $area10 = Area::create(['region_id' => 1, 'name' => 'Museum']);
        $subzones10 = ['Bras Basah', 'Dhoby Ghaut', 'Fort Canning'];
        foreach($subzones10 as $subzone10){
            SubZone::create([
                'area_id'   => 10,
                'name'      => $subzone10
            ]);
        }

        $area11 = Area::create(['region_id' => 1, 'name' => 'Newton']);
        $subzones11 = ["Cairnhill",
        "Goodwood Park",
        "Istana Negara",
        "Monk's Hill",
        "Newton Circus",
        "Orange Grove"];
        foreach($subzones11 as $subzone11){
            SubZone::create([
                'area_id'   => 11,
                'name'      => $subzone11
            ]);
        }

        $area12 = Area::create(['region_id' => 1, 'name' => 'Novena']);
        $subzones12 = ["Balestier",
        "Dunearn",
        "Malcolm",
        "Moulmein",
        "Mount Pleasant"];
        foreach($subzones12 as $subzone12){
            SubZone::create([
                'area_id'   => 12,
                'name'      => $subzone12
            ]);
        }

        $area13 = Area::create(['region_id' => 1, 'name' => 'Orchard']);
        $subzones13 = ["Boulevard",	
        "Somerset",
        "Tanglin"];
        foreach($subzones13 as $subzone13){
            SubZone::create([
                'area_id'   => 13,
                'name'      => $subzone13
            ]);
        }

        $area14 = Area::create(['region_id' => 1, 'name' => 'Outram']);
        $subzones14 = ["China Square",
        "Chinatown",
        "Pearl's Hill",
        "People's Park"];
        foreach($subzones14 as $subzone14){
            SubZone::create([
                'area_id'   => 14,
                'name'      => $subzone14
            ]);
        }

        $area15 = Area::create(['region_id' => 1, 'name' => 'Queenstown']);
        $subzones15 = ["Commonwealth",
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
        "Tanglin Halt"];
        foreach($subzones15 as $subzone15){
            SubZone::create([
                'area_id'   => 15,
                'name'      => $subzone15
            ]);
        }

        $area16 = Area::create(['region_id' => 1, 'name' => 'River Valley']);
        $subzones16 = ["Institution Hill",
        "Leonie Hill",
        "One Tree Hill",
        "Oxley",
        "Paterson"];
        foreach($subzones16 as $subzone16){
            SubZone::create([
                'area_id'   => 16,
                'name'      => $subzone16
            ]);
        }

        $area17 = Area::create(['region_id' => 1, 'name' => 'Rochor']);
        $subzones17 = ["Bencoolen",
        "Farrer Park",
        "Kampong Glam",
        "Little India",
        "Mackenzie",
        "Mount Emily",
        "Rochor Canal",
        "Selegie",
        "Sungei Road",
        "Victoria"];
        foreach($subzones17 as $subzone17){
            SubZone::create([
                'area_id'   => 17,
                'name'      => $subzone17
            ]);
        }

        $area18 = Area::create(['region_id' => 1, 'name' => 'Singapore River']);
        $subzones18 = ["Boat Quay",
        "Clarke Quay",
        "Robertson Quay"];
        foreach($subzones18 as $subzone18){
            SubZone::create([
                'area_id'   => 18,
                'name'      => $subzone18
            ]);
        }

        $area19 = Area::create(['region_id' => 1, 'name' => 'Southern Islands']);
        $subzones19 = ['Sentosa',
        'Southern Group'];
        foreach($subzones19 as $subzone19){
            SubZone::create([
                'area_id'   => 19,
                'name'      => $subzone19
            ]);
        }

        $area20 = Area::create(['region_id' => 1, 'name' => 'Straits View']);
        $subzones20 = ['Straits View'];
        foreach($subzones20 as $subzone20){
            SubZone::create([
                'area_id'   => 20,
                'name'      => $subzone20
            ]);
        }

        $area21 = Area::create(['region_id' => 1, 'name' => 'Tanglin']);
        $subzones21 = ["Chatsworth",
        "Nassim",
        "Ridout",
        "Tyersall"];
        foreach($subzones21 as $subzone21){
            SubZone::create([
                'area_id'   => 21,
                'name'      => $subzone21
            ]);
        }

        $area22 = Area::create(['region_id' => 1, 'name' => 'Toa Payoh']);
        $subzones22 = ["Bidadari",
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
        "Woodleigh"];
        foreach($subzones22 as $subzone22){
            SubZone::create([
                'area_id'   => 22,
                'name'      => $subzone22
            ]);
        }

        $region2 = Region::create([
            'id' => 2,
            'name' => 'East Region',
        ]);

        $area23 = Area::create(['region_id' => 2, 'name' => 'Bedok']);
        $subzones23 = ["Bayshore",
        "Bedok North",
        "Bedok Reservoir",
        "Bedok South",
        "Frankel",
        "Kaki Bukit",
        "Kembangan",
        "Siglap"];
        foreach($subzones23 as $subzone23){
            SubZone::create([
                'area_id'   => 23,
                'name'      => $subzone23
            ]);
        }

        $area24 = Area::create(['region_id' => 2, 'name' => 'Changi']);
        $subzones24 = ["Changi Airport",
        "Changi Point",
        "Changi West"];
        foreach($subzones24 as $subzone24){
            SubZone::create([
                'area_id'   => 24,
                'name'      => $subzone24
            ]);
        }

        $area25 = Area::create(['region_id' => 2, 'name' => 'Changi Bay']);
        $subzones25 = ["Changi Bay"];
        foreach($subzones25 as $subzone25){
            SubZone::create([
                'area_id'   => 25,
                'name'      => $subzone25
            ]);
        }

        $area26 = Area::create(['region_id' => 2, 'name' => 'Pasir Ris']);
        $subzones26 = ["Flora Drive",
        "Loyang East",
        "Loyang West",
        "Pasir Ris Central",
        "Pasir Ris Drive",
        "Pasir Ris Park",
        "Pasir Ris Wafer Fab Park",
        "Pasir Ris West"];
        foreach($subzones26 as $subzone26){
            SubZone::create([
                'area_id'   => 26,
                'name'      => $subzone26
            ]);
        }

        $area27 = Area::create(['region_id' => 2, 'name' => 'Paya Lebar']);
        $subzones27 = ["Airport Road",
        "Paya Lebar East",
        "Paya Lebar North",
        "Paya Lebar West",
        "PLAB"];
        foreach($subzones27 as $subzone27){
            SubZone::create([
                'area_id'   => 27,
                'name'      => $subzone27
            ]);
        }

        $area28 = Area::create(['region_id' => 2, 'name' => 'Tampines']);
        $subzones28 = ["Simei",
        "Tampines East",
        "Tampines North",
        "Tampines West",
        "Xilin"];
        foreach($subzones28 as $subzone28){
            SubZone::create([
                'area_id'   => 28,
                'name'      => $subzone28
            ]);
        }

        $region3 = Region::create([
            'id' => 3,
            'name' => 'North Region',
        ]);

        $area29 = Area::create(['region_id' => 3, 'name' => 'Lim Chu Kang']);
        $subzones29 = ["Lim Chu Kang"];
        foreach($subzones29 as $subzone29){
            SubZone::create([
                'area_id'   => 29,
                'name'      => $subzone29
            ]);
        }

        $area30 = Area::create(['region_id' => 3, 'name' => 'Central Water Catchment']);
        $subzones30 = ["Central Water Catchment"];
        foreach($subzones30 as $subzone30){
            SubZone::create([
                'area_id'   => 30,
                'name'      => $subzone30
            ]);
        }

        $area31 = Area::create(['region_id' => 3, 'name' => 'Mandai']);
        $subzones31 = ["Mandai East",
        "Mandai Estate",
        "Mandai West"];
        foreach($subzones31 as $subzone31){
            SubZone::create([
                'area_id'   => 31,
                'name'      => $subzone31
            ]);
        }

        $area32 = Area::create(['region_id' => 3, 'name' => 'Sembawang']);
        $subzones32 = ["Admiralty",
                                "Sembawang Central",
                                "Sembawang East	",
                                "Sembawang North",
                                "Sembawang Springs",
                                "Sembawang Straits",
                                "Senoko North",
                                "Senoko South",
                                "The Wharves"];
        foreach($subzones32 as $subzone32){
            SubZone::create([
                'area_id'   => 32,
                'name'      => $subzone32
            ]);
        }

        $area33 = Area::create(['region_id' => 3, 'name' => 'Simpang']);
        $subzones33 = ["Pulau Seletar",		
        "Simpang North",		
        "Simpang South",		
        "Tanjong Irau"];
        foreach($subzones33 as $subzone33){
            SubZone::create([
                'area_id'   => 33,
                'name'      => $subzone33
            ]);
        }

        $area34 = Area::create(['region_id' => 3, 'name' => 'Sungei Kadut']);
        $subzones34 = ["Gali Batu", "Kranji", "Pang Sua", "Reservoir View", "Turf Club"];
        foreach($subzones34 as $subzone34){
            SubZone::create([
                'area_id'   => 34,
                'name'      => $subzone34
            ]);
        }

        $area35 = Area::create(['region_id' => 3, 'name' => 'Woodlands']);
        $subzones35 = ["Greenwood Park",
        "Midview",
        "North Coast",
        "Senoko West",
        "Woodgrove",
        "Woodlands East	",
        "Woodlands Regional Centre",
        "Woodlands South",
        "Woodlands West"];
        foreach($subzones35 as $subzone35){
            SubZone::create([
                'area_id'   => 35,
                'name'      => $subzone35
            ]);
        }

        $area36 = Area::create(['region_id' => 3, 'name' => 'Yishun']);
        $subzones36 = [ "Khatib",
        "Lower Seletar",
        "Nee Soon",
        "Northland",
        "Springleaf	",
        "Yishun Central",
        "Yishun East",
        "Yishun South",
        "Yishun West"];
        foreach($subzones36 as $subzone36){
            SubZone::create([
                'area_id'   => 36,
                'name'      => $subzone36
            ]);
        }

        $region4 = Region::create([
            'id' => 4,
            'name' => 'North-East Region',
        ]);

        $area37 = Area::create(['region_id' => 4, 'name' => 'Ang Mo Kio']);
        $subzones37 = ["Ang Mo Kio Town Centre","Cheng San","Chong Boon	","Kebun Bahru","Sembawang Hills","Shangri-La","Tagore","Townsville","Yio Chu Kang","Yio Chu Kang East","Yio Chu Kang North","Yio Chu Kang West"];
        foreach($subzones37 as $subzone37){
            SubZone::create([
                'area_id'   => 37,
                'name'      => $subzone37
            ]);
        }

        $area38 = Area::create(['region_id' => 4, 'name' => 'Hougang']);
        $subzones38 = ["Defu Industrial Park","Hougang Central","Hougang East","Hougang West","Kangkar","Kovan","Lorong Ah Soo","Lorong Halus","Tai Seng","Trafalgar"];
        foreach($subzones38 as $subzone38){
            SubZone::create([
                'area_id'   => 38,
                'name'      => $subzone38
            ]);
        }

        $area39 = Area::create(['region_id' => 4, 'name' => 'North-Eastern Islands']);
        $subzones39 = ["North-Eastern Islands"];
        foreach($subzones39 as $subzone39){
            SubZone::create([
                'area_id'   => 39,
                'name'      => $subzone39
            ]);
        }

        $area40= Area::create(['region_id' => 4, 'name' => 'Punggol']);
        $subzones40 = ["Coney Island","Matilda","Northshore","Punggol Canal","Punggol Field","Punggol Town Centre","Waterway East"];
        foreach($subzones40 as $subzone40){
            SubZone::create([
                'area_id'   => 40,
                'name'      => $subzone40
            ]);
        }

        $area41 = Area::create(['region_id' => 4, 'name' => 'Seletar']);
        $subzones41 = ["Pulau Punggol Barat","Pulau Punggol Timor","Seletar","Seletar Aerospace Park"];
        foreach($subzones41 as $subzone41){
            SubZone::create([
                'area_id'   => 41,
                'name'      => $subzone41
            ]);
        }

        $area42 = Area::create(['region_id' => 4, 'name' => 'Sengkang']);
        $subzones42 = ["Anchorvale","Compassvale","Fernvale","Lorong Halus North","Rivervale","Sengkang Town Centre","Sengkang West"];
        foreach($subzones42 as $subzone42){
            SubZone::create([
                'area_id'   => 42,
                'name'      => $subzone42
            ]);
        }

        $area43 = Area::create(['region_id' => 4, 'name' => 'Serangoon']);
        $subzones43 = [ "Lorong Chuan", "Seletar Hills", "Serangoon Central", "Serangoon Garden", "Serangoon North", "Serangoon North Industrial Estate", "Upper Paya Lebar"];
        foreach($subzones43 as $subzone43){
            SubZone::create([
                'area_id'   => 43,
                'name'      => $subzone43
            ]);
        }

        $region5 = Region::create([
            'id' => 5,
            'name' =>  'West Region',
        ]);

        $area44 = Area::create(['region_id' => 5, 'name' => 'Boon Lay']);
        $subzones44 = [ "Liu Fang", "Samulun", "Shipyard", "Tukang"];
        foreach($subzones44 as $subzone44){
            SubZone::create([
                'area_id'   => 44,
                'name'      => $subzone44
            ]);
        }

        $area45 = Area::create(['region_id' => 5, 'name' => 'Bukit Batok']);
        $subzones45 = ["Brickworks", "Bukit Batok Central", "Bukit Batok East", "Bukit Batok West", "Bukit Batok South", "Gombak", "Guilin", "Hillview", "Hong Kah North"];
        foreach($subzones45 as $subzone45){
            SubZone::create([
                'area_id'   => 45,
                'name'      => $subzone45
            ]);
        }

        $area46 = Area::create(['region_id' => 5, 'name' => 'Bukit Panjang']);
        $subzones46 = [ "Bangkit", "Dairy Farm", "Fajar", "Jelebu	", "Nature Reserve", "Saujana", "Senja"];
        foreach($subzones46 as $subzone46){
            SubZone::create([
                'area_id'   => 46,
                'name'      => $subzone46
            ]);
        }

        $area47 = Area::create(['region_id' => 5, 'name' => 'Choa Chu Kang']);
        $subzones47 = [ "Choa Chu Kang Central", "Choa Chu Kang North", "Keat Hong", "Peng Siang", "Teck Whye", "Yew Tee"];
        foreach($subzones47 as $subzone47){
            SubZone::create([
                'area_id'   => 47,
                'name'      => $subzone47
            ]);
        }

        $area48 = Area::create(['region_id' => 5, 'name' => 'Clementi']);
        $subzones48 = [ "Clementi Central", "Clementi North", "Clementi West", "Clementi Woods", "Faber", "Pandan", "Sunset Way", "Toh Tuck", "West Coast"];
        foreach($subzones48 as $subzone48){
            SubZone::create([
                'area_id'   => 48,
                'name'      => $subzone48
            ]);
        }

        $area49 = Area::create(['region_id' => 5, 'name' => 'Jurong East']);
        $subzones49 = [ "International Business Park", "Jurong Gateway", "Jurong Port", "Jurong River", "Lakeside (Business)", "Lakeside (Leisure)	", "Penjuru Crescent", "Teban Gardens", "Toh Guan", "Yuhua East", "Yuhua West"];
        foreach($subzones49 as $subzone49){
            SubZone::create([
                'area_id'   => 49,
                'name'      => $subzone49
            ]);
        }

        $area50 = Area::create(['region_id' => 5, 'name' => 'Jurong West']);
        $subzones50 = [ "Boon Lay Place", "Chin Bee", "Hong Kah", "Jurong West Central", "Kian Teck", "Safti", "Taman Jurong", "Wenya", "Yunnan"];
        foreach($subzones50 as $subzone50){
            SubZone::create([
                'area_id'   => 50,
                'name'      => $subzone50
            ]);
        }

        $area51 = Area::create(['region_id' => 5, 'name' => 'Pioneer']);
        $subzones51 = [ "Benoi Sector", "Gul Basin", "Gul Circle", "Joo Koon", "Pioneer Sector"];
        foreach($subzones51 as $subzone51){
            SubZone::create([
                'area_id'   => 51,
                'name'      => $subzone51
            ]);
        }

        
        $area52 = Area::create(['region_id' => 5, 'name' => 'Tengah']);
        $subzones52 = ["Brickland	", "Forest Hill", "Garden", "Park", "Plantation", "Tengah Industrial Estate"];
        foreach($subzones52 as $subzone52){
            SubZone::create([
                'area_id'   => 52,
                'name'      => $subzone52
            ]);
        }


        $area53 = Area::create(['region_id' => 5, 'name' => 'Tuas']);
        $subzones53 = [ "Tengeh", "Tuas Bay", "Tuas North", "Tuas Promenade", "Tuas View", "Tuas View Extension"];
        foreach($subzones53 as $subzone53){
            SubZone::create([
                'area_id'   => 53,
                'name'      => $subzone53
            ]);
        }

        $area54 = Area::create(['region_id' => 5, 'name' => 'Western Islands']);
        $subzones54 = [ "Jurong Island and Bukom", "Semakau", "Sudong"];
        foreach($subzones54 as $subzone54){
            SubZone::create([
                'area_id'   => 54,
                'name'      => $subzone54
            ]);
        }

        $area55 = Area::create(['region_id' => 5, 'name' => 'Western Water Catchment']);
        $subzones55 = [ "Bahar", "Cleantech", "Murai"];

        foreach($subzones55 as $subzone55){
            SubZone::create([
                'area_id'   => 55,
                'name'      => $subzone55
            ]);
        }
    }
}
