<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

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

    @yield('content')
    
  </div>

  <footer class="blog-footer">
    <p>Portal Berita <a href="{{route('homepage')}}">Winnicode</a> by <a href="https://github.com/muhammadwarisi/portal-berita-winnicode">Muhammad Warisi</a>.</p>
    <p>
      <a href="#">Back to top</a>
    </p>
  </footer>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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



