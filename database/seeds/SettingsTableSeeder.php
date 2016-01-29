<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'Website title',
            'key' => 'website_title',
            'value' => 'Website powered by Berrier'
        ], [
            'name' => 'Theme',
            'key' => 'theme',
            'value' => 'default'
        ]);
    }
}
