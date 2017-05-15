@extends('layouts.app')

@section('title', 'Nouvel article')

@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <form role="form" method="post" action="{{ route('articles.store') }}" ng-app="markdownApp" ng-controller="markdownController">
    {{ csrf_field() }}

    <div class="group{{ $errors->has('content') ? ' has-error' : '' }}">
      <label for="md-content">Contenu</label>

      <textarea id="md-content" name="content" rows="15" ng-model="input" maxlength="5000" required></textarea>

      <p class="text-right" ng-cloak>@{{ input.length }} caractères (140 minimum)</p>

      @if ($errors->has('content'))
        <p class="help-block">{{ $errors->first('content') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('title') ? ' has-error' : '' }}" ng-show="input.length >= 500">
      <label for="title">Titre</label>

      <input id="title" type="text" name="title" value="{{ old('title') }}" ng-maxlength="255" autofocus>

      <p class="text-right">(obligatoire à partir de 500 caractères)</p>

      @if ($errors->has('title'))
        <p class="help-block">{{ $errors->first('title') }}</p>
      @endif
    </div>

    <div class="markdown-preview" ng-bind-html="input | markdown"></div>

    <div class="group">
      <button type="submit">Envoyer</button>
    </div>
  </form>
  <script src="https://cdn.rawgit.com/showdownjs/showdown/1.6.4/dist/showdown.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.min.js"></script>
  <script>
    angular.module('markdownApp', ['ngSanitize'])
      .controller('markdownController', function($scope) {
        $scope.input = "{{ old('content') }}";
      })
      .filter('markdown', function() {
          let converter = new showdown.Converter();
          return function(value) {
            return converter.makeHtml(value || '');
          }
      });
  </script>
@endsection
