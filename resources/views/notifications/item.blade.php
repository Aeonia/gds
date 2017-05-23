<article>
  <h3 class="title">
    <a href="{{ route('articles.index') }}/{{ $notification->article_id }}">{{ $notification->article->title }}</a>
  </h3>
  <p>{{ $notification->content }}</p>
</article>
