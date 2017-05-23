<?php

namespace App\Providers;

use App\Article;
use App\ArticleVote;
use App\Comment;
use App\Issue;
use App\User;
use App\Policies\ArticlePolicy;
use App\Policies\ArticleVotePolicy;
use App\Policies\CommentPolicy;
use App\Policies\IssuePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class,
        ArticleVote::class => ArticleVotePolicy::class,
        Comment::class => CommentPolicy::class,
        Issue::class => IssuePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
