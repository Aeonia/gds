@extends('layouts.app')

@section('title', $user->name)

@section('content')
  @if (Auth::check() && Auth::user()->can('upgrade', $user))
    <form class="button-only next-to-title" role="form" method="post" action="{{ route('users.upgrade', $user->id) }}">
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
  @if (Auth::check() && Auth::user()->can('update', $user))
    <a href="{{ route('users.edit', $user->id) }}">éditer</a>
  @endif
  @if (Auth::check() && Auth::user()->can('view', $user))
    <section>
      <h2 class="title">Mes notifications</h2>
      @each('notifications.item', $user->notifications->sortByDesc('created_at'), 'notification', 'notifications.no-items')
    </section>
  @endif
@endsection
