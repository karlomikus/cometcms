<?php

use Illuminate\Database\Seeder;
use App\Game;

class GamesTableSeeder extends Seeder {

    public function run()
    {
        Game::create([
            'name' => 'DotA 2',
            'code' => 'dota',
            'image' => '1_dota.gif'
        ]);
        
        Game::create([
            'name' => 'Counter Strike: Global Offensive',
            'code' => 'csgo',
            'image' => '2_csgo.gif'
        ]);
        
        Game::create([
            'name' => 'Call of Duty 4: Modern Warfare',
            'code' => 'cod4',
            'image' => '3_cod4.gif'
        ]);
        
        Game::create([
            'name' => 'League of Legends',
            'code' => 'lol',
            'image' => '4_lol.gif'
        ]);
    }

}