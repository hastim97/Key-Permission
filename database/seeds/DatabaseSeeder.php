<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\User::class,50)->create();
       /* DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10) . '@gmail.com',
                'password' => bcrypt('secret'),
                'role' => 'Student',
                'Phone_No' => rand(100,999),
                'remember_token' => str_random(10),
        ]);     */



        factory(App\Room::class,50)->create();
        factory(App\Permission::class,50)->create();

    }
}
//123