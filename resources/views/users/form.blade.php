@extends('layouts.app')

@section('title', $name)

@section('content')
  <form role="form" method="post" action="{{ $action }}">
    {{ csrf_field() }}
    @if (isset($method))
      {{ $method }}
    @endif

    <div class="group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name">Nom</label>

      <input id="name" type="text" name="name" value="{{ old('name', $name) }}" autofocus>

      @if ($errors->has('name'))
        <p class="help-block">{{ $errors->first('name') }}</p>
      @endif
    </div>

    <div class="group{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="email">Adresse e-mail</label>

      <input id="email" type="email" name="email" value="{{ old('email', $email) }}">

      @if ($errors->has('email'))
        <p class="help-block">{{ $errors->first('email') }}</p>
      @endif
    </div>

    <div class="row">
      <a href="{{ $cancel }}">annuler</a>
      <button type="submit">envoyer</button>
    </div>
  </form>
@endsection
