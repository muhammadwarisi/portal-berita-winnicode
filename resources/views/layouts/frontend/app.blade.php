<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title' || 'Portal Berita')</title>

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/blog.css')}}" rel="stylesheet">
</head>
<body>

  <div class="container">
    @include('layouts.frontend.navbar')

    <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
      <div class="col-md-6 px-0">
        <h1 class="display-4 font-italic">Title of a longer featured blog post</h1>
        <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what's most interesting in this post's contents.</p>
        <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
      </div>
    </div>

    <div class="mb-2">
      <h3>Berita Terbaru</h3>
    </div>

    <main class="scroll-container">
      <div class="row mb-2 flex-nowrap">
        @foreach ($latestArticles as $article)
        <div class="col-md-1 col-lg-1 col-sm-1">
          <div class="card flex-md-row mb-4 box-shadow h-md-250 card-bg" style="background-image: url({{asset('dist/img/photo4.jpg')}});">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-white">{{Str::limit($article->category->name,'20')}}</strong>
              <h3 class="mb-0">
                <a class="text-white" href="#">{{Str::limit($article->title,25)}}</a>
              </h3>
              <div class="mb-1 text-white">{{\Carbon\Carbon::parse($article->published_at)->diffForHumans()}}</div>
              <p class="card-text mb-auto text-truncate" style="max-height: 4.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
              <a href="#">Continue reading</a>
            </div>
          </div>
        </div>
        <!-- Tambahkan lebih banyak card jika diperlukan untuk melihat efek scroll -->
        @endforeach
      </div>
    </main>
    <!-- Recommended Articles Section -->
    <div class="row mt-4">
      <div class="col-md-8 col-lg-8 col-sm-8 mb-2 blog-main">
    <h2>Recommended For You</h2>
    <div class="row d-flex">
        @foreach($recommendedArticles as $article)
        <div class="col-md-6 h-100 mb-4">
            {{-- <img class="card-img-top" src="{{ asset('dist/img/photo4.jpg') }}" alt="{{ $article->title }}"> --}}
            <div class="box-shadow card-bg" style="background-image: url({{asset('dist/img/photo4.jpg')}});">
              <div class="card-body">
                  <span class="badge bg-primary mb-2">{{ $article->category->name }}</span>
                  <h5 class="card-title text-white">{{ Str::limit($article->title,'50') }}</h5>
                  <p class="card-text">{{ Str::limit(strip_tags($article->content), 100) }}</p>
              </div>
            </div>
            <div class="card-footer bg-dark">
                <small class="text-white">Published {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</small>
                <a href="#" class="btn btn-sm btn-outline-primary float-right">Read More</a>
            </div>
        </div>
        @endforeach
      </div>
    </div>
    <aside class="col-md-4 col-sm-4 blog-sidebar">
      <h2>Trending</h2>
      @foreach ($trendingArticles as $article)
      <div class="p-3 mb-3 bg-light rounded">
        <h5 class="font-italic">{{Str::limit($article->title,'50')}}</h5>
        <p class="mb-0">{{Str::limit($article->content,'60')}}</p>
      </div>
      @endforeach

      <div class="p-3">
        <h4 class="font-italic">Follow Us</h4>
        <ol class="list-unstyled">
          <li><a href="#">GitHub</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Facebook</a></li>
        </ol>
      </div>
    </aside><!-- /.blog-sidebar -->
</div>
    
  </div>

  <footer class="blog-footer">
    <p>Portal Berita <a href="#">Winnicode</a> by <a href="https://github.com/muhammadwarisi/portal-berita-winnicode">Muhammad Warisi</a>.</p>
    <p>
      <a href="#">Back to top</a>
    </p>
  </footer>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <script src="{{asset('plugins/popper/popper.min.js')}}"></script>
  <script src="../../dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.8/holder.min.js"></script>
  
  {{-- <script src="../../assets/js/vendor/holder.min.js"></script> --}}
  <script>
    Holder.addTheme('thumb', {
      bg: '#55595c',
      fg: '#eceeef',
      text: 'Thumbnail'
    });
  </script>
</body>
</html>



