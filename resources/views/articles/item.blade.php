<article>
  <h2 class="title">
    <a href="{{ route('articles.index') }}/{{ $article->id }}">{{ $article->title }}</a>
    @if ($article->issue())
      @if ($article->issue()->published_at)
        <span class="status published">publié le {{ $article->issue()->published_at }}</span>
      @else
        <span class="status pending-publication">en attente de publication</span>
      @endif
    @endif
  </h2>
  <div class="excerpt">
    {{ $article->excerpt }}
  </div>
  @component('components.post-aside', [
    'post' => $article
  ])
  @endcomponent
</article>
