@extends('layouts.app')

@section('title', 'Articles')

@section('content')
  <form class="button-only next-to-title" method="get" action="{{ route('articles.create') }}">
    <button type="submit">nouveau</button>
  </form>
  <h1 class="title">Articles</h1>

  @each('articles.item', $articles, 'article', 'articles.no-items')

  <nav class="pagination">
    {{ $articles->links() }}
  </nav>
@endsection
