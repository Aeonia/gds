@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
  <h1 class="title">Utilisateurs</h1>

  <ul>
    @forelse ($users as $user)
      <li><a href="{{ route('users.show', $user->id) }}">{{ $user->who() }}</a></li>
    @empty
      <li>(Aucun utilisateur disponible)</li>
    @endforelse
  </ul>

  <nav>
    {{ $users->links() }}
  </nav>
@endsection
