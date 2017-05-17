@if (Auth::id() == $comment->user->id)
  <form class="next-to-title" method="post" action="{{ route('comments.destroy', ['article_id' => $article->id, 'comment_id' => $comment->id]) }}">
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
