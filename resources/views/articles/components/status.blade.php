@if ($article->issue())
  @if ($article->issue()->published_at)
    <a class="status published" href="
      @component('issues.components.href', [
        'issue' => $article->issue()
      ])
      @endcomponent
    ">
      publié le
      @component('issues.components.date', [
        'issue' => $article->issue()
      ])
      @endcomponent
    </a>
  @else
    <span class="status pending-publication"> en attente de publication </span>
  @endif
@endif
