<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
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
        $this->middleware('auth', ['only' => [
            'create',
            'store',
            'edit',
            'update',
            'destroy'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::with('user')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = Article::create(
            $this->prepareInput($request)
        );

        return redirect()->route('articles.show', [$article]);
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
            'article' => $article,
            'comments' => Comment::where(
                'article_id', $article->id
            )->with('user')->get()
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
        if (Auth::id() == $article->id) {
            $article->fill(
                $this->prepareInput($request)
            );
            $article->save();
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
        if ($article->id == Auth::id()) {
            $article->delete();
        }

        return redirect()->route('articles.index');
    }

    public static function parseMarkdown(String $markdown)
    {
        return Markdown::parse($markdown);
    }

    public static function makeExcerpt(String $html)
    {
        return str_limit(
            strip_tags($html),
            140
        );
    }

    /**
     * Prepare the input from the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function prepareInput(Request $request)
    {
        $input = $request->all();

        if (
            $request->input('content') &&
            strlen($request->input('content')) < 500
        ) {
            $this->validate($request, [
              'content' => 'required|min:140'
            ]);

            $input['title'] = 'Brève';
        } else {
            $this->validate($request, [
              'title' => 'required|max:255',
              'content' => 'required|max:5000'
            ]);
        }

        $input['user_id'] = Auth::id();
        $input['html_content'] = self::parseMarkdown($input['content']);
        $input['excerpt'] = self::makeExcerpt($input['html_content']);

        return $input;
    }
}
