@extends('layouts.app')

@extends('title', 'Reset password')

@section('content')
  @if (session('status'))
    <p class="alert alert-success">{{ session('status') }}</p>
  @endif

  <form role="form" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="email">Adresse e-mail</label>

      <input id="email" type="email" name="email" value="{{ $email or old('email') }}" required autofocus>

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

    <div class="group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
      <label for="password-confirm">Confirmer le mot de passe</label>

      <input id="password-confirm" type="password" name="password_confirmation" required>

      @if ($errors->has('password_confirmation'))
        <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
      @endif
    </div>

    <div class="group">
      <button type="submit">Envoyer</button>
    </div>
  </form>
@endsection
