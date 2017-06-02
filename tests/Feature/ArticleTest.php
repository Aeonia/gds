<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    public function testIndex()
    {
        // as guest
        {
            $response = $this->get(
                route('articles.index')
            );
            $response->assertStatus(200);
        }

        // as Nick Fury
        {
            $nick_fury = User::where('level', 10)->first();

            $response = $this->actingAs($nick_fury)->get(
                route('articles.index')
            );
            $response->assertStatus(200);
        }
    }

    public function testCreate()
    {
        // as guest
        {
            $response = $this->get(
                route('articles.create')
            );
            $response->assertRedirect(
                route('login')
            );
        }

        // as Nick Fury
        {
            $nick_fury = User::where('level', 10)->first();

            $response = $this->actingAs($nick_fury)->get(
                route('articles.create')
            );
            $response->assertStatus(200);
        }
    }

    public function testShow()
    {
        $article = Article::first();

        // as guest
        {
            $response = $this->get(
                route('articles.show', [$article])
            );
            $response->assertStatus(200);
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('articles.show', [$article])
            );
            $response->assertStatus(200);
        }
    }

    public function testEdit()
    {
        $article = Article::first();

        // as guest
        {
            $response = $this->get(
                route('articles.edit', [$article])
            );
            $response->assertRedirect(
                route('login')
            );
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('articles.edit', [$article])
            );
            $response->assertStatus(200);
        }
    }

    public function testPublish()
    {
        $article = Article::first();

        // as guest
        {
            $response = $this->get(
                route('articles.publish', [$article])
            );
            $response->assertRedirect(
                route('login')
            );

            $response = $this->get(
                route('articles.unpublish', [$article])
            );
            $response->assertRedirect(
                route('login')
            );
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('articles.publish', [$article])
            );
            $response->assertRedirect(
                route('articles.show', [$article])
            );

            $response = $this->actingAs($nick_fury)->get(
                route('articles.unpublish', [$article])
            );
            $response->assertRedirect(
                route('articles.show', [$article])
            );
        }
    }
}
