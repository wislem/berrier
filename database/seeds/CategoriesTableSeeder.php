<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('category_translations')->insert([
            'category_id' => 1,
            'slug' => 'root',
            'name' => 'Root',
            'locale' => 'en'
        ]);
        DB::table('category_translations')->insert([
            'category_id' => 1,
            'slug' => 'root',
            'name' => 'Root',
            'locale' => 'el'
        ]);
        DB::table('category_translations')->insert([
            'category_id' => 1,
            'slug' => 'root',
            'name' => 'Root',
            'locale' => 'de'
        ]);

        DB::table('categories')->insert([
            'parent_id' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::table('category_translations')->insert([
            'category_id' => 2,
            'slug' => 'uncategorized',
            'name' => 'Uncategorized',
            'locale' => 'en'
        ]);
        DB::table('category_translations')->insert([
            'category_id' => 2,
            'slug' => 'uncategorized',
            'name' => 'Uncategorized',
            'locale' => 'el'
        ]);
        DB::table('category_translations')->insert([
            'category_id' => 2,
            'slug' => 'uncategorized',
            'name' => 'Uncategorized',
            'locale' => 'de'
        ]);

        \Wislem\Berrier\Models\Category::fixTree();
    }
}
