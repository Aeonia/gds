@extends('layouts.app')

@section('title', $user->name)

@section('content')
  <h1>{{ $user->name }}</h1>
@endsection
