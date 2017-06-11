@extends('layouts.app')

@section('title', $title)

@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.min.js"></script>
  <script src="https://cdn.rawgit.com/showdownjs/showdown/1.6.4/dist/showdown.min.js"></script>
  <script>
    angular.module('markdownApp', ['ngSanitize'])
      .controller('markdownController', function($scope) {
        $scope.content = `{!! old('content', str_replace(['\\', '`'], ['\\\\', '\`'], $content)) !!}`;
        $scope.title = `{!! old('title', str_replace(['\\', '`'], ['\\\\', '\`'], $title)) !!}`;
        $scope.storage = window.localStorage;

        $scope.saveDraft = function() {
          $scope.storage['articleDraft'] = $scope.content;
        };
        $scope.loadDraft = function() {
          $scope.content = $scope.storage['articleDraft'];

          return false;
        };
      })
      .filter('markdown', function() {
          let converter = new showdown.Converter();
          return function(value) {
            return converter.makeHtml(value || '');
          }
      });
  </script>
  <form role="form" method="post" action="{{ $action }}" ng-app="markdownApp" ng-controller="markdownController">
    {{ csrf_field() }}
    @if (isset($method))
      {{ $method }}
    @endif

    <div class="group{{ $errors->has('content') ? ' has-error' : '' }}">
      <label for="content">Contenu</label>

      <textarea id="content" name="content" rows="15" ng-model="content" ng-change="saveDraft()" maxlength="{{ App\Article::maximumLength() }}" required></textarea>

      <p class="text-right" ng-cloak>@{{ content.length }} caractères ({{ App\Article::minimumLength() }} minimum)</p>

      @if ($errors->has('content'))
        <p class="help-block">{{ $errors->first('content') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('title') ? ' has-error' : '' }}" ng-show="content.length >= {{ App\Article::newsLength() }}">
      <label for="title">Titre</label>

      <input id="title" type="text" name="title" ng-model="title" maxlength="{{ App\Article::titleMaximumLength() }}" autofocus>

      <p class="text-right" ng-cloak>@{{ title.length }} caractères ({{ App\Article::titleMaximumLength() }} maximum, obligatoire à partir de {{ App\Article::newsLength() }} caractères)</p>

      @if ($errors->has('title'))
        <p class="help-block">{{ $errors->first('title') }}</p>
      @endif
    </div>

    <div class="markdown-preview" ng-bind-html="content | markdown"></div>

    <div class="row">
      <a href="{{ $cancel }}">annuler</a>
      <button type="button" ng-click="loadDraft()">recharcher brouillon</button>
      <button type="submit">envoyer</button>
    </div>
  </form>
@endsection
