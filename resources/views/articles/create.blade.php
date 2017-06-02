@component('articles.components.form', [
  'title' => 'Nouvel article',
  'content' => '',
  'action' => route('articles.store'),
  'cancel' => route('articles.index')
])
@endcomponent
