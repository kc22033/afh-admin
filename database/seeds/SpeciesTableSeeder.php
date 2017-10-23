<?php

use Illuminate\Database\Seeder;
use App\Models\Species;

class SpeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('species')->delete();

        Species::create(['name' => 'Dog', 'description_url' => 'https://en.wikipedia.org/wiki/Dog']);
        Species::create(['name' => 'Cat', 'description_url' => 'https://en.wikipedia.org/wiki/Cat']);
    }
}
