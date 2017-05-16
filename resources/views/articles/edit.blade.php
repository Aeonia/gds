@component('articles.form', [
  'title' => $article->title,
  'content' => $article->content,
  'action' => route('articles.update', $article->id),
  'method' => method_field('PUT'),
  'cancel' => route('articles.show', $article->id)
])
@endcomponent
