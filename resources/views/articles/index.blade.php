@extends('layouts.app')

@section('title', 'Articles')

@section('content')
  <nav class="float-right">
    <ul>
      <li><a class="button" href="{{ route('articles.create') }}">Nouveau</a></li>
    </ul>
  </nav>
  <h1 class="title">Articles</h1>

  @each('articles.item', $articles, 'article', 'articles.no-items')

  <nav>
    {{ $articles->links() }}
  </nav>
@endsection
