@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
  @if (session('status'))
    <p class="alert alert-success">{{ session('status') }}</p>
  @endif

  <form role="form" method="post" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="email">Adresse e-mail</label>

      <input id="email" type="email" name="email" value="{{ old('email') }}" required>

      @if ($errors->has('email'))
        <p class="help-block">{{ $errors->first('email') }}</p>
      @endif
    </div>

    <div class="group">
      <button type="submit">envoyer</button>
    </div>
  </form>
@endsection
