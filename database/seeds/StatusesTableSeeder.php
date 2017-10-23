<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->delete();

        Status::create(['name' => 'Available']);
        Status::create(['name' => 'Adopted']);
        Status::create(['name' => 'Adoption Pending']);
        Status::create(['name' => 'Being Returned']);
        Status::create(['name' => 'Deleted']);
        Status::create(['name' => 'Deceased']);
        Status::create(['name' => 'Euthanized']);
        Status::create(['name' => 'Transferred']);
    }
}
