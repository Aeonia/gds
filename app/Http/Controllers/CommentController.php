<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $article_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $article_id)
    {
        $input = $request->all();

        $this->validate($request, [
          'content' => 'required|min:15|max:140'
        ]);

        $input['article_id'] = $article_id;
        $input['user_id'] = Auth::id();

        Comment::create($input);

        return redirect()->route('articles.show', [$article_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $article_id
     * @param  integer  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $article_id, $comment_id)
    {
        $comment = Comment::find($comment_id);

        if ($comment && $comment->user->id == Auth::id()) {
            $comment->delete();
        }

        return redirect()->route('articles.show', [$article_id]);
    }
}
