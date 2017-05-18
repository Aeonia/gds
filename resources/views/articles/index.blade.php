@extends('layouts.app')

@section('title', 'Articles')

@section('content')
  <form class="button-only next-to-title flex-row justify-end align-stretch" method="get" action="{{ route('articles.create') }}">
    <a class="sort @if ($sort == 'newest') chosen @endif" href="?sort=newest">les plus récents</a>
    <a class="sort @if ($sort == 'votes') chosen @endif" href="?sort=votes">meilleurs votes</a>
    <button type="submit">nouveau</button>
  </form>
  <h1 class="title">Articles</h1>

  @each('articles.item', $articles, 'article', 'articles.no-items')

  <nav class="pagination">
    {{ $articles->links() }}
  </nav>
@endsection
