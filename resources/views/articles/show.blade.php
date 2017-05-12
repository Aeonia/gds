@extends('layouts.app')

@section('title', $article->title)

@section('content')
  <article>
    <h1 class="title">{{ $article->title }}</h1>
    {{ $article->content }}
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
