<article>
  <h2 class="title"><a href="{{ route('articles.index') }}/{{ $article->id }}">{{ $article->title }}</a></h2>
  <div class="excerpt">
    {{ $article->excerpt }}
  </div>
  <aside>
    {{ $article->user->name }}
    {{ $article->created_at }}
  </aside>
</article>
