<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Http\Controllers\ArticleController;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'level' => 2,
        'remember_token' => str_random(10)
    ];
});
$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->words(5, true),
        'content' => $faker->text(600),
        'html_content' => function (array $article) {
            return ArticleController::parseMarkdown(
                $article['content']
            );
        },
        'excerpt' => function (array $article) {
            return ArticleController::makeExcerpt(
                $article['html_content']
            );
        },
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text(120),
        'article_id' => function () {
            return factory(App\Article::class)->create([
                'title' => 'Bref',
                'content' => Faker\Factory::create()->text(200)
            ])->id;
        },
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
