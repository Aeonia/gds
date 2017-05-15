@extends('layouts.app')

@section('title', 'Articles')

@section('content')
  <form class="next-to-title" action="{{ route('articles.create') }}" method="get">
    <button type="submit">nouveau</button>
  </form>
  <h1 class="title">Articles</h1>

  @each('articles.item', $articles, 'article', 'articles.no-items')

  <nav>
    {{ $articles->links() }}
  </nav>
@endsection
