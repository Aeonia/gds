@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
  <h1 class="title">Utilisateurs</h1>

  <ul>
    @each('users.item', $users, 'user', 'users.no-items')
  </ul>

  <nav>
    {{ $users->links() }}
  </nav>
@endsection
