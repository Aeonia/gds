@extends('layouts.app')

@section('title', 'Publications')

@section('content')
  @if (Auth::check() && Auth::user()->can('update', $next_issue))
    <form class="button-only next-to-title" method="get" action="{{ route('issues.edit', $next_issue) }}">
      <button type="submit">maquette du prochain numéro</button>
    </form>
  @endif
  <h1 class="title">Publications</h1>

  <ul>
    @forelse ($issues as $issue)
      <li>
        <a href="
          @component('issues.components.href', [
            'issue' => $issue
          ])
          @endcomponent
        ">
          @component('issues.components.date', [
            'issue' => $issue
          ])
          @endcomponent
        </a>
      </li>
    @empty
      <li>(Aucune publication disponible)</li>
    @endforelse
  </ul>

  <nav>
    {{ $issues->links() }}
  </nav>
@endsection
