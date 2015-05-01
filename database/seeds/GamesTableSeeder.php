<?php

use Illuminate\Database\Seeder;
use App\Game;

class GamesTableSeeder extends Seeder {

    public function run()
    {
        Game::create([
            'name' => 'DotA 2',
            'code' => 'dota'
        ]);
        
        Game::create([
            'name' => 'Counter Strike: Global Offensive',
            'code' => 'csgo'
        ]);
        
        Game::create([
            'name' => 'Heartstone',
            'code' => 'heartstone'
        ]);
        
        Game::create([
            'name' => 'League of Legends',
            'code' => 'lol'
        ]);
    }

}