<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleIssue;
use App\Issue;
use App\Events\ArticleChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index',
            'show'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->cookie('sort');

        if ($request->has('sort')) {
            $sort =  $request->input('sort');
        }

        switch ($sort) {
            case 'votes':
                $order_by = 'vote_count';
                break;
            case 'newest':
            default:
                $order_by = 'updated_at';
                break;
        }

        return response(
            view('articles.index', [
                'articles' => Article::with('user')->orderBy(
                    $order_by, 'desc'
                )->paginate(15),
                'sort' => $sort
            ])
        )->cookie(
            'sort', $sort, 60*24*7
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('create', Article::class)) {
            return view('articles.create');
        } else {
            return view('no-permissions');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create', Article::class)) {
            $article = Article::create(
                $this->prepareInput($request, Auth::id())
            );

            return redirect()->route('articles.show', [$article]);
        } else {
            return redirect()->route('articles.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        if (Auth::user()->can('update', $article)) {
            $article->fill(
                $this->prepareInput($request, $article->user_id)
            );
            $article->save();

            event(
                new ArticleChanged(
                    $article,
                    Auth::user()->name . ' a édité'
                )
            );
        }

        return redirect()->route('articles.show', [$article]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if (Auth::user()->can('delete', $article)) {
            $article->delete();
        }

        return redirect()->route('articles.index');
    }

    /**
     * Create a link with the next issue,
     * making the article flagged as published.
     *
     * @param  $article_id
     * @return \Illuminate\Http\Response
     */
    public function publish($article_id)
    {
        $article = Article::findOrFail($article_id);

        if (Auth::user()->can('publish', $article)) {
            $issue = Issue::firstOrCreate(['published_at' => null]);

            ArticleIssue::updateOrCreate([
                'article_id' => $article->id,
                'issue_id' => $issue->id
            ]);

            event(
                new ArticleChanged(
                    $article,
                    Auth::user()->name . " a sélectionné l'article pour la prochaine publication"
                )
            );
        }

        return redirect()->route('articles.show', [$article]);
    }

    /**
     * Destroy the link with this article's issue,
     * making the article flagged as unpublished.
     *
     * @param  $article_id
     * @return \Illuminate\Http\Response
     */
    public function unpublish($article_id)
    {
        $article = Article::findOrFail($article_id);
        $issue = $article->issue();

        if (
            Auth::user()->can('publish', $article) &&
            $issue
        ) {
            ArticleIssue::where([
                'article_id' => $article->id,
                'issue_id' => $issue->id
            ])->delete();

            event(
                new ArticleChanged(
                    $article,
                    Auth::user()->name . " a désélectionné l'article pour la prochaine publication"
                )
            );
        }

        return redirect()->route('articles.show', [$article]);
    }

    /**
     * Prepare the input from the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $user_id
     * @return array
     */
    protected function prepareInput(Request $request, $user_id)
    {
        $input = $request->all();

        if (
            $request->input('content') &&
            strlen($request->input('content')) < 500
        ) {
            $this->validate($request, [
              'content' => 'required|min:140'
            ]);

            $input['title'] = 'Bref';
        } else {
            $this->validate($request, [
              'title' => 'required|max:255',
              'content' => 'required|max:5000'
            ]);
        }

        $input['user_id'] = $user_id;
        $input['html_content'] = Article::parseMarkdown($input['content']);
        $input['excerpt'] = Article::makeExcerpt($input['html_content']);

        return $input;
    }
}
