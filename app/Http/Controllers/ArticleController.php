<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\ArticleEdited;
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

            event(new ArticleEdited($article));
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

    public static function parseMarkdown($markdown)
    {
        return Markdown::parse($markdown);
    }

    public static function makeExcerpt($html)
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
        $input['html_content'] = self::parseMarkdown($input['content']);
        $input['excerpt'] = self::makeExcerpt($input['html_content']);

        return $input;
    }
}
