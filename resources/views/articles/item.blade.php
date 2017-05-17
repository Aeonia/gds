<article>
  <h2 class="title"><a href="{{ route('articles.index') }}/{{ $article->id }}">{{ $article->title }}</a></h2>
  <div class="excerpt">
    {{ $article->excerpt }}
  </div>
  @component('components.post-aside', [
    'post' => $article
  ])
  @endcomponent
</article>
