@extends('layouts.frontend.app')

@section('title', 'Search Results')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Search Results for "{{ $query }}"</h2>

    @if($articles->count() > 0)
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                        @else
                            <img src="{{ asset('images/default-article.jpg') }}" class="card-img-top" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text text-muted">
                                <small>
                                    <i class="fas fa-user"></i> {{ $article->user->name }} |
                                    <i class="fas fa-calendar"></i> {{ $article->created_at->format('d M Y') }}
                                </small>
                            </p>
                            <p class="card-text">{{ Str::limit($article->description, 100) }}</p>
                            <a href="{{ route('article', [$article->id, $article->slug]) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {!! $articles->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    @else
        <div class="alert alert-info">
            No articles found matching your search criteria.
        </div>
    @endif
</div>
@endsection
