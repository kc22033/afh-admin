<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'Ken Cline',
            'email' => 'ken@afh.ngo',
            'password' => bcrypt('David1987'),
        ]);
        DB::table('users')->insert([
            'name' => 'Carmen Cline',
            'email' => 'carmen@aforeverhome.org',
            'password' => bcrypt('kcsavdj5'),
        ]);
        DB::table('users')->insert([
            'name' => 'Maribel Taylor-Mattox',
            'email' => 'maribel@aforeverhome.org',
            'password' => bcrypt('patrick1'),
        ]);
        DB::table('users')->insert([
            'name' => 'Zikuan Li',
            'email' => 'dzli@email.wm.edu',
            'password' => bcrypt('FixIt!'),
        ]);
    }
}
