@if ($article->issue())
  @if ($article->issue()->published_at)
    <a class="status published" href="
      @component('components.issue-href', [
        'issue' => $article->issue()
      ])
      @endcomponent
    ">
      publié le
      @component('components.issue-date', [
        'issue' => $article->issue()
      ])
      @endcomponent
    </a>
  @else
    <span class="status pending-publication"> en attente de publication </span>
  @endif
@endif
