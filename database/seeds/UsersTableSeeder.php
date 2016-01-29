<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Lastnamer',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'gender' => 0,
            'birthday' => \Carbon\Carbon::now(),
            'role' => 2,
            'status' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
