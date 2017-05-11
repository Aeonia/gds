@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
  <ul>
    @each('users.item', $users, 'user', 'users.no-items')
  </ul>
@endsection
