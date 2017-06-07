@extends('layouts.app')

@section('title', $user->name)

@section('content')
  <h1 class="title">{{ $user->who() }} <em class="name">{{ $user->name }}</em></h1>
  @if (Auth::check() && Auth::user()->can('update', $user))
    <a href="{{ route('users.edit', $user->id) }}">éditer</a>
  @endif
  @if (Auth::check() && Auth::user()->can('view', $user))
    <section>
      <h2 class="title">Mes notifications</h2>
      @forelse ($user->notifications->sortByDesc('created_at') as $notification)
        <article>
          <h3 class="title">
            <a href="{{ route('articles.show', $notification->article_id) }}">{{ $notification->article->title }}</a>
          </h3>
          <p>{{ $notification->content }}</p>
        </article>
      @empty
        <p>(Rien à déclarer)</p>
      @endforelse
    </section>
  @endif
@endsection
