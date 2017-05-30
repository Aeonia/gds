@extends('layouts.app')

@section('title', 'Nouvelle publication')

@section('content')
  <form role="form" method="post" action="{{ route('issues.update', $issue->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="row">
      <a href="{{ route('issues.index') }}">annuler</a>
      <button type="submit">publier</button>
    </div>
  </form>
@endsection
