@if (Auth::check() && Auth::user()->can('delete', $comment))
  <form class="button-only next-to-title" method="post" action="{{ route('comments.destroy', ['article_id' => $comment->article->id, 'comment_id' => $comment->id]) }}">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit">supprimer</button>
  </form>
@endif
<section>
  <div class="content">
    {{ $comment->content }}
  </div>
  @component('components.post-aside', [
    'post' => $comment
  ])
  @endcomponent
</section>
