@extends('layouts.app')

@section('title', $user->name)

@section('content')
  <form role="form" method="post" action="{{ route('users.update', $user->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name">Nom</label>

      <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus>

      @if ($errors->has('name'))
        <p class="help-block">{{ $errors->first('name') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="email">Adresse e-mail</label>

      <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}">

      @if ($errors->has('email'))
        <p class="help-block">{{ $errors->first('email') }}</p>
      @endif
    </div>

    <div class="row">
      <a href="{{ route('users.show', $user->id) }}">annuler</a>
      <button type="submit">envoyer</button>
    </div>
  </form>
@endsection
