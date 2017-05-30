@extends('layouts.app')

@section('title', 'Publications')

@section('content')
  @if (Auth::check() && Auth::user()->can('create', App\Issue::class))
  <form class="button-only next-to-title" method="get" action="{{ route('issues.edit', $next_issue) }}">
    <button type="submit">nouvelle</button>
  </form>
  @endif
  <h1 class="title">Publications</h1>

  <ul>
    @forelse ($issues as $issue)
      <li><a href="{{ route('issues.show', $issue->id) }}">{{ $issue->published_at }}</a></li>
    @empty
      <li>(Aucune publication disponible)</li>
    @endforelse
  </ul>

  <nav>
    {{ $issues->links() }}
  </nav>
@endsection
