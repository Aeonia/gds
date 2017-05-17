<?php

namespace App\Http\Controllers;

use App\ArticleVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleVoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $article_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {
        $input = $request->all();

        if ($input['value'] > 0) {
            $input['value'] = 1;
        } else {
            $input['value'] = -1;
        }

        $vote = ArticleVote::where([
            ['article_id', $article_id],
            ['user_id', Auth::id()]
        ])->first();

        if ($vote) {
            if ($vote->value == $input['value']) {
                $vote->delete();
            } else {
                $vote->value = $input['value'];
                $vote->save();
            }
        } else {
            $input['article_id'] = $article_id;
            $input['user_id'] = Auth::id();

            $vote = ArticleVote::create($input);
        }

        $vote_count = 0;

        foreach ($vote->article->votes as $vote) {
            $vote_count += $vote->value;
        }

        $vote->article->vote_count = $vote_count;
        $vote->article->save();

        return redirect()->route('articles.show', [$article_id]);
    }
}
