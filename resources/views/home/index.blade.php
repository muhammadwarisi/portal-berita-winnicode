@extends('layouts.frontend.app')

@section('title', 'Portal Berita')

@section('header.content', 'Portal Berita')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div id="featuredCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    @foreach($featuredArticles as $key => $article)
      <li data-target="#featuredCarousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
    @endforeach
  </ol>
  
  <div class="carousel-inner rounded">
    @foreach($featuredArticles as $key => $article)
      <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
        <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark mb-0" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{asset('dist/img/photo' . (($key % 4) + 1) . '.png')}}) no-repeat center center; background-size: cover;">
          <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">{{ $article->title }}</h1>
            <p class="lead my-3">{{ Str::limit(strip_tags($article->content), 150) }}</p>
            <p class="lead mb-0"><a href="{{ route('article', [$article->id,$article->slug]) }}" class="text-white font-weight-bold">Continue reading...</a></p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  
  <a class="carousel-control-prev" href="#featuredCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#featuredCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
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
          <a href="{{ route('article', [$article->id,$article->slug]) }}">Continue reading</a>
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
            <a href="{{ route('article', [$article->id,$article->slug]) }}" class="btn btn-sm btn-outline-primary float-right">Read More</a>
        </div>
    </div>
    @endforeach
  </div>
</div>
<aside class="col-md-4 col-sm-4 blog-sidebar">
  <h2>Trending</h2>
  @foreach ($trendingArticles as $article)
  <div class="card p-3 mb-3 bg-light rounded">
    <h5 class="font-italic">{!! Str::limit($article->title,'50') !!}</h5>
    <p class="mb-0">{!!Str::limit($article->content,'60')!!}</p>
    <a href="{{ route('article', [$article->id,$article->slug]) }}" class="btn btn-sm btn-outline-primary">Read More</a>
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
@endsection
