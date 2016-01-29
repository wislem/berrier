<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'is_active' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('page_translations')->insert([
            'page_id' => 1,
            'slug' => 'home',
            'title' => 'Home Page',
            'locale' => 'en'
        ]);
    }
}
