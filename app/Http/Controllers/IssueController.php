<?php

namespace App\Http\Controllers;

use App\Issue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only([
            'edit',
            'update'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $next_issue = Issue::firstOrCreate(['published_at' => null]);

        return view('issues.index', [
            'issues' => Issue::where(
                'published_at', '!=', null
            )->orderBy(
                'published_at', 'desc'
            )->paginate(28),
            'next_issue' => $next_issue
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $year
     * @param  $mon
     * @param  $mday
     * @return \Illuminate\Http\Response
     */
    public function show($year, $mon, $mday)
    {
        return $this->showIssue(
            Issue::whereDate(
                'published_at',
                $year.'-'.$mon.'-'.$mday
            )->firstOrFail()
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        if (Auth::user()->can('update', $issue)) {
            return $this->showIssue($issue);
        } else {
            return view('no-permissions');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        if (Auth::user()->can('update', $issue)) {
            $issue->published_at = Carbon::now();
            $issue->save();

            return redirect()->route(
                'issues.show',
                getdate(
                  strtotime(
                    $issue->published_at
                  )
                )
            );
        } else {
            return redirect()->route('issues.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    private function showIssue(Issue $issue)
    {
        $headlines = $issue->articles()->where(
            'title', '!=', 'Bref'
        )->orderBy('vote_count', 'desc')->get();
        $news = $issue->articles()->where(
            'title', 'Bref'
        )->orderBy('vote_count', 'desc')->get();

        $rows = [[]];

        $used_columns = 0;
        $col_length = 0;

        $j = 0;

        for ($i = 0; $i < count($headlines); ) {
            if ($used_columns == 3) {
                $rows[] = [];
                $used_columns = 0;
            }

            if (strlen($headlines[$i]->content) < 1000) {
                $wanted_columns = 1;
            } elseif (strlen($headlines[$i]->content) < 2000) {
                $wanted_columns = 2;
            } else {
                $wanted_columns = 3;
            }

            $article = (object)[];

            if ($used_columns + $wanted_columns <= 3) {
                $used_columns += $wanted_columns;

                $article->col = $wanted_columns;
                $article->content = $headlines[$i];

                $col_length = strlen($headlines[$i]->content) / (1.5 * $article->col);

                ++$i;
            } else {
                $article->col = 3 - $used_columns;
                $article->content = (object)[];
                $article->content->title = 'Bref';
                $article->content->sections = [];

                $padding_length = 0;

                while (
                    $padding_length < $col_length &&
                    $j < count($news)
                ) {
                    $padding_length += strlen($news[$j]->content);
                    $article->content->sections[] = $news[$j];

                    ++$j;
                }

                $used_columns = 3;
            }

            $rows[count($rows)-1][] = $article;
        }

        if ($j < count($news)) {
            $article = (object)[];
            $article->content = (object)[];
            $article->content->title = 'Bref';
            $article->content->sections = [];

            $padding_length = 0;

            if ($used_columns <= 3) {
                $article->col = 3 - $used_columns;

                while (
                    $padding_length < $col_length &&
                    $j < count($news)
                ) {
                    $padding_length += strlen($news[$j]->content);
                    $article->content->sections[] = $news[$j];

                    ++$j;
                }

                $used_columns = 3;

                $rows[count($rows)-1][] = $article;

                $article = (object)[];
                $article->content = (object)[];
                $article->content->title = 'Bref';
                $article->content->sections = [];

                $padding_length = 0;
            }

            if ($j < count($news)) {
                $rows[] = [];

                while ($j < count($news)) {
                    $padding_length += strlen($news[$j]->content);
                    $article->content->sections[] = $news[$j];

                    ++$j;
                }

                if ($padding_length < 400) {
                    $article->col = 1;
                } elseif ($padding_length < 800) {
                    $article->col = 2;
                } else {
                    $article->col = 3;
                }

                $rows[count($rows)-1][] = $article;
            }
        }

        return view('issues.show', [
            'issue' => $issue,
            'rows' => $rows
        ]);
    }
}
