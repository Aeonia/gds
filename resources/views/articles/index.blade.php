@extends('layouts.app')

@section('title', 'Articles')

@section('content')
  <ul>
    @each('articles.item', $articles, 'article', 'articles.no-items')
  </ul>
@endsection
