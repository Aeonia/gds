<article>
  <h2 class="title"><a href="{{ route('articles.index') }}/{{ $article->id }}">{{ $article->title }}</a></h2>
  <div class="excerpt">
    {{ str_limit($article->content, 140) }}
  </div>
  <aside>
    {{ $article->user->name }}
    {{ $article->created_at }}
  </aside>
</article>
