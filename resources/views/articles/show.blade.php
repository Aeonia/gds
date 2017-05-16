@extends('layouts.app')

@section('title', $article->title)

@section('content')
  <article class="showing">
    @if (Auth::id() == $article->user->id)
      <form class="next-to-title" action="{{ route('articles.destroy', $article->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit">supprimer</button>
      </form>
      <form class="next-to-title" action="{{ route('articles.edit', $article->id) }}" method="get">
        <button type="submit">éditer</button>
      </form>
    @endif
    <h1 class="title">{{ $article->title }}</h1>
    <section class="content">
      {!! $article->html_content !!}
    </section>
    <footer>
      {{ $article->user->name }}
    </footer>
  </article>
  <aside class="comments">
    <section>
      foo
    </section>
    <section>
      bar
    </section>
  </aside>
@endsection
