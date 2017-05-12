<!doctype html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
      @hasSection('title')
        @yield('title') - la gazette des Simplonien.ne.s
      @else
        la gazette des Simplonien.ne.s
      @endif
    </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Open+Sans+Condensed:100,300,600">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/simplon.png') }}">
  </head>
  <body>
    <nav class="gds-nav-bar">
      <ul>
        <li><a class="gds" href="{{ route('root') }}">GDS - la gazette des Simplonien.ne.s</a></li>
        <li><a href="{{ route('articles.index') }}">Articles</a></li>
        <li><a href="{{ route('users.index') }}">Utilisateurs</a></li>
        <li><a href="{{ route('issues.index') }}">Publications</a></li>
        @if (Route::has('login'))
          @if (Auth::check())
            <li class="right"><a href="{{ route('home') }}">Profil</a></li>
            <li><a href="{{ url('/logout') }}">Log out</a></li>
          @else
            <li class="right"><a href="{{ url('/login') }}">Log in</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
          @endif
        @endif
      </ul>
    </nav>
    <main @hasSection('mainClass') class="@yield('mainClass', '')" @endif>
      @yield('content')
    </main>
  </body>
</html>
