@extends('layouts.frontend.app')

@section('title', $category->name . ' - Portal Berita')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
            
            <h1 class="mb-4">{{ $category->name }}</h1>
            
            @if($articles->count() > 0)
                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                @if($article->featured_image)
                                    <img class="card-img-top" src="{{asset('dist/img/photo4.jpg')}}" alt="{{ $article->title }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                    <p class="card-text text-truncate" style="max-height: 4.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        {!! strip_tags($article->content) !!}
                                    </p>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{\Carbon\Carbon::parse($article->published_at)->diffForHumans()}}</small>
                                        <a href="{{route('article',$article->id)}}" class="btn btn-sm btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No articles found in this category.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection