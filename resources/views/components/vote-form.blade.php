@if (Auth::check())
  <form class="button-only" method="post" action="{{ route('votes.update', $post->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="value" value="{{ $value }}">
    <button @if ($post->voteValue(Auth::id()) == $value) class="voted" @endif type="submit">{{ $value }}</button>
  </form>
@endif
