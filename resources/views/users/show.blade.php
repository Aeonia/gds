@extends('layouts.app')

@section('title', $user->name)

@section('content')
  @if (Auth::check() && Auth::user()->can('upgrade', $user))
    <form class="button-only next-to-title" role="form" method="post" action="{{ route('users.update', $user->id) }}">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="row">
        <label for="level">Niveau</label>

        <input id="level" type="number" name="level" value="{{ old('level', $user->level) }}">

        <button type="submit">envoyer</button>
      </div>
    </form>
  @endif
  <h1 class="title">{{ $user->name }}</h1>
@endsection
