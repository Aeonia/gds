@extends('layouts.app')

@section('title', 'Log in')

@section('content')
  <form role="form" method="post" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name">Nom</label>

      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

      @if ($errors->has('name'))
        <p class="help-block">{{ $errors->first('name') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('password') ? ' has-error' : '' }}">
      <label for="password">Mot de passe</label>

      <input id="password" type="password" name="password" required>

      @if ($errors->has('password'))
        <p class="help-block">{{ $errors->first('password') }}</p>
      @endif
    </div>

    <div class="row">
      <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
      </label>

      <a href="{{ route('password.request') }}">Mot de passe oublié?</a>
    </div>

    <div class="group">
      <button type="submit">envoyer</button>
    </div>
  </form>
@endsection
