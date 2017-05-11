@extends('layouts.app')

@section('title', $article->title)

@section('content')
  <h1>{{ $article->title }}</h1>
  {{ $article->content }}
@endsection
