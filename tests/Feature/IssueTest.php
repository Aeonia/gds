<?php

namespace Tests\Feature;

use App\Issue;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IssueTest extends TestCase
{
    public function testIndex()
    {
        // as guest
        {
            $response = $this->get(
                route('issues.index')
            );
            $response->assertStatus(200);
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('issues.index')
            );
            $response->assertStatus(200);
        }
    }

    public function testShow()
    {
        $issue = Issue::where('published_at', '!=', null)->first();

        $issue_url = parse_url(
            route('issues.show', 
                getdate(
                    strtotime(
                        $issue->published_at
                    )
                )
            ),
            PHP_URL_PATH
        );

        // as guest
        {
            $response = $this->get(
                $issue_url
            );
            $response->assertStatus(200);
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                $issue_url
            );
            $response->assertStatus(200);
        }
    }

    public function testEdit()
    {
        $issue = Issue::where('published_at', null)->first();

        // as guest
        {
            $response = $this->get(
                route('issues.edit', $issue->id)
            );
            $response->assertRedirect(
                route('login')
            );
        }

        // as Nick Fury
        {
            $nick_fury = User::nickFury();

            $response = $this->actingAs($nick_fury)->get(
                route('issues.edit', $issue->id)
            );
            $response->assertStatus(200);
        }
    }
}
