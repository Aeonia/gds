<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'id' => 1,
            'title' => 'Lorem ipsum',
            'content' => '<p>Lorem ipsum</p>',
            'user_id' => 1
        ]);
        DB::table('articles')->insert([
            'id' => 2,
            'title' => 'Knack ipsum',
            'content' => '<p>Knack ipsum</p>',
            'user_id' => 1
        ]);
        DB::table('articles')->insert([
            'id' => 3,
            'title' => 'Cheuteumi ipsum',
            'content' => '<p>Cheuteumi ipsum</p>',
            'user_id' => 1
        ]);
    }
}
