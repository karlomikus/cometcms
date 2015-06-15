<?php

use Illuminate\Database\Seeder;
use App\Map;

class MapsTableSeeder extends Seeder {

    public function run()
    {
        Map::create([
            'name' => 'Dota 2 Map',
            'game_id' => 1
        ]);
        
        Map::create([
            'name' => 'Dust 2',
            'game_id' => 2,
            'image' => '2.png'
        ]);
        Map::create([
            'name' => 'Cache',
            'game_id' => 2,
            'image' => '3.png'
        ]);
        Map::create([
            'name' => 'Train',
            'game_id' => 2,
            'image' => '4.png'
        ]);
        Map::create([
            'name' => 'Mirage',
            'game_id' => 2,
            'image' => '5.png'
        ]);
        Map::create([
            'name' => 'Inferno',
            'game_id' => 2,
            'image' => '6.png'
        ]);
        Map::create([
            'name' => 'Cobblestone',
            'game_id' => 2,
            'image' => '1.png'
        ]);
        
        Map::create([
            'name' => 'Crash',
            'game_id' => 3
        ]);
        Map::create([
            'name' => 'Crossfire',
            'game_id' => 3
        ]);
        Map::create([
            'name' => 'Vacant',
            'game_id' => 3
        ]);
        Map::create([
            'name' => 'Backlot',
            'game_id' => 3
        ]);
        Map::create([
            'name' => 'District',
            'game_id' => 3
        ]);
        
        Map::create([
            'name' => 'Summoners Rift',
            'game_id' => 4
        ]);
    }

}