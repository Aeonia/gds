@component('users.form', [
  'name' => $user->name,
  'email' => $user->email,
  'action' => route('users.update', $user->id),
  'method' => method_field('PUT'),
  'cancel' => route('users.show', $user->id)
])
@endcomponent
