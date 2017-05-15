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
            'content' => '**Lorem** ipsum',
            'user_id' => 1
        ]);
        DB::table('articles')->insert([
            'id' => 2,
            'title' => 'Knack ipsum',
            'content' => '**Knack** ipsum',
            'user_id' => 1
        ]);
        DB::table('articles')->insert([
            'id' => 3,
            'title' => 'Cheuteumi ipsum',
            'content' => '**Cheuteumi** ipsum',
            'user_id' => 1
        ]);
    }
}
