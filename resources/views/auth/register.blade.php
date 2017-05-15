@extends('layouts.app')

@section('title', 'Sign up')

@section('content')
  <form role="form" method="post" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name">Nom</label>

      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

      @if ($errors->has('name'))
        <p class="help-block">{{ $errors->first('name') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="email">Adresse e-mail</label>

      <input id="email" type="email" name="email" value="{{ old('email') }}" required>

      @if ($errors->has('email'))
        <p class="help-block">{{ $errors->first('email') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('password') ? ' has-error' : '' }}">
      <label for="password">Mot de passe</label>

        <input id="password" type="password" name="password" required>

        @if ($errors->has('password'))
          <p class="help-block">{{ $errors->first('password') }}</p>
        @endif
    </div>

    <div class="group">
      <label for="password-confirm">Confirmer le mot de passe</label>

      <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>

    <div class="group">
      <button type="submit">Envoyer</button>
    </div>
  </form>
@endsection
