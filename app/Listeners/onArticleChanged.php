<?php

namespace App\Listeners;

use App\Notification;
use App\Events\ArticleChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class onArticleChanged
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleChanged  $event
     * @return void
     */
    public function handle(ArticleChanged $event)
    {
        $notified = [];

        $user = $event->article->comments->last()->user;

        $parameters = [
            'article_id' => $event->article->id,
            'content' => $event->message
        ];

        if (
            $event->article->user_id != Auth::user()->id &&
            !array_search($event->article->user_id, $notified)
        ) {
            $parameters['user_id'] = $event->article->user_id;
            Notification::create($parameters);
            $notified[] = $event->article->user_id;
        }

        foreach ($event->article->comments as $comment) {
            if (
                $comment->user_id != Auth::user()->id &&
                !array_search($comment->user_id, $notified)
            ) {
                $parameters['user_id'] = $comment->user_id;
                Notification::create($parameters);
                $notified[] = $comment->user_id;
            }
        }
    }
}
