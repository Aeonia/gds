<aside>
  @isset ($post->vote_count)
    <div class="votes flex-1">
      @component('components.vote-form', [
        'post' => $post,
        'value' => '-1'
      ])
      @endcomponent
      <p>{{ $post->vote_count }} vote(s)</p>
      @component('components.vote-form', [
        'post' => $post,
        'value' => '+1'
      ])
      @endcomponent
    </div>
  @endisset
  {{ $post->user->name }} - {{ $post->created_at }}
</aside>
