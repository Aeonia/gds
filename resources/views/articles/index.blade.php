@extends('layouts.app')

@section('title', 'Articles')

@section('content')
  <form class="button-only next-to-title flex-row justify-end align-stretch" method="get" action="{{ route('articles.create') }}">
    <a class="sort @if ($sort == 'newest') chosen @endif" href="?sort=newest">les plus récents</a>
    <a class="sort @if ($sort == 'votes') chosen @endif" href="?sort=votes">meilleurs votes</a>
    <button type="submit">nouveau</button>
  </form>
  <h1 class="title">Articles</h1>

  @forelse ($articles as $article)
    <article>
      <h2 class="title">
        <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
        @component('articles.components.status', [
          'article' => $article
        ])
        @endcomponent
      </h2>
      <div class="excerpt">
        {{ $article->excerpt }}
      </div>
      @component('components.post-aside', [
        'post' => $article
      ])
      @endcomponent
    </article>
  @empty
    <p>(Aucun article disponible)</p>
  @endforelse

  <nav class="pagination">
    {{ $articles->links() }}
  </nav>
@endsection
