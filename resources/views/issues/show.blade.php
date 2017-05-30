<!doctype html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
      Publication du {{ $issue->published_at }} - la gazette des Simplonien.ne.s
    </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Open+Sans+Condensed:300,300i,700">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/issue.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/simplon.png') }}">
  </head>
  <body>
    <main class="newspaper">
      <header>
        <a class="next-to-title" href="{{ route('issues.index') }}">&larr;</a>
        <h1 class="title">
          la gazette des
          <strong>Simplonien.ne.s</strong>
        </h1>
        <aside>
          <p>{{ $issue->published_at }}</p>
          <a class="gds" href="{{ route('root') }}">GDS - la gazette des Simplonien.ne.s</a>
          <p>édition de P20</p>
        </aside>
      </header>
      @foreach ($rows as $row)
        <div class="row">
          @foreach ($row as $article)
            <article class="col-{{ $article->col }}">
              @isset ($article->content->sections)
                <div class="content">
                  <h2 class="title">{{ $article->content->title }}</h2>
                  @foreach ($article->content->sections as $section)
                    <section>
                      {!! $section->html_content !!}
                      <aside>{{ $section->user->name }}</aside>
                    </section>
                  @endforeach
                </div>
              @else
                <h2 class="title">{{ $article->content->title }}</h2>
                <div class="content">{!! $article->content->html_content !!}</div>
                <aside>{{ $article->content->user->name }}</aside>
              @endisset
            </article>
          @endforeach 
        </div>
      @endforeach 
    </main>
  </body>
</html>
