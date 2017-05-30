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
    @each('issues.item', $issues, 'issue', 'issues.no-items')
  </ul>

  <nav>
    {{ $issues->links() }}
  </nav>
@endsection
