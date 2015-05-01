<?php

use Illuminate\Database\Seeder;
use App\Map;

class MapsTableSeeder extends Seeder {

    public function run()
    {
        Map::create([
            'name' => 'Dust 2'
        ]);
        
        Map::create([
            'name' => 'Dota 2 Map'
        ]);
        
        Map::create([
            'name' => 'Summoners Rift'
        ]);
        
        Map::create([
            'name' => 'mp_crash'
        ]);
    }

}