@extends('layouts.app')

@section('title', $article->title)

@section('content')
  <article class="showing">
    @if ($article->issue())
      @if (Auth::check() && Auth::user()->can('publish', $article))
        <form class="button-only next-to-title" method="get" action="{{ route('articles.unpublish', $article->id) }}">
          <button type="submit">dépublier</button>
        </form>
      @endif
    @else
      @if (Auth::check() && Auth::user()->can('delete', $article))
        <form class="button-only next-to-title" method="post" action="{{ route('articles.destroy', $article->id) }}">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button type="submit">supprimer</button>
        </form>
      @endif
      @if (Auth::check() && Auth::user()->can('update', $article))
        <form class="button-only next-to-title" method="get" action="{{ route('articles.edit', $article->id) }}">
          <button type="submit">éditer</button>
        </form>
      @endif
      @if (Auth::check() && Auth::user()->can('publish', $article))
        <form class="button-only next-to-title" method="get" action="{{ route('articles.publish', $article->id) }}">
          <button type="submit">publier</button>
        </form>
      @endif
    @endif
    <h1 class="title">
      {{ $article->title }}
      @if ($article->issue())
        @if ($article->issue()->published_at)
          <span class="status published">publié le {{ $article->issue()->published_at }}</span>
        @else
          <span class="status pending-publication">en attente de publication</span>
        @endif
      @endif
    </h1>
    <div class="content">
      {!! $article->html_content !!}
    </div>
    @component('components.post-aside', [
      'post' => $article
    ])
    @endcomponent
  </article>
  <aside class="comments">
    @each('comments.item', $article->comments, 'comment', 'comments.no-items')
    @if (!$article->issue() && Auth::check() && Auth::user()->can('create', App\Comment::class))
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
      <script>
        angular.module('commentApp', [])
          .controller('commentController', function($scope) {
            $scope.content = `{{ old('content') }}`;
          });
      </script>
      <form method="post" action="{{ route('comments.store', $article->id) }}" ng-app="commentApp" ng-controller="commentController">
        {{ csrf_field() }}

        <div class="group{{ $errors->has('content') ? ' has-error' : '' }}">
          <textarea id="content" name="content" rows="2" ng-model="content" maxlength="140" required></textarea>

          <p class="text-right" ng-cloak>@{{ content.length }} caractères (15 minimum, 140 maximum)</p>

          @if ($errors->has('content'))
            <p class="help-block">{{ $errors->first('content') }}</p>
          @endif
        </div>

        <div class="group">
          <button type="submit">commenter</button>
        </div>
      </form>
    @endif
  </aside>
@endsection
