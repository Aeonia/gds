<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    public function testIndex()
    {
        // as guest
        {
            $response = $this->get(
                route('users.index')
            );
            $response->assertStatus(200);
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('users.index')
            );
            $response->assertStatus(200);
        }
    }

    public function testShow()
    {
        $user = User::first();

        // as guest
        {
            $response = $this->get(
                route('users.show', [$user])
            );
            $response->assertStatus(200);
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('users.show', [$user])
            );
            $response->assertStatus(200);
        }
    }

    public function testEdit()
    {
        $user = User::first();

        // as guest
        {
            $response = $this->get(
                route('users.edit', [$user])
            );
            $response->assertRedirect(
                route('login')
            );
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('users.edit', [$user])
            );
            $response->assertStatus(200);
        }
    }
}
