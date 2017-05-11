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
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/simplon.png') }}">
  </head>
  <body>
    <header>
      <nav class="top-right links">
        <ul>
          <li><a class="gds" href="{{ url('/') }}">GDS - la gazette des Simplonien.ne.s</a></li>
          <li><a href="{{ url('/articles') }}">Articles</a></li>
          <li><a href="{{ url('/users') }}">Utilisateurs</a></li>
          <li><a href="{{ url('/issues') }}">Publications</a></li>
          @if (Route::has('login'))
            @if (Auth::check())
              <li class="right"><a href="{{ url('/home') }}">Profil</a></li>
              <li><a href="{{ url('/logout') }}">Log out</a></li>
            @else
              <li class="right"><a href="{{ url('/login') }}">Log in</a></li>
              <li><a href="{{ url('/register') }}">Register</a></li>
            @endif
          @endif
        </ul>
      </nav>
    </header>
    <main @hasSection('mainClass') class="@yield('mainClass', '')" @endif>
      @yield('content')
    </main>
  </body>
</html>
