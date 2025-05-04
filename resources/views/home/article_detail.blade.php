@extends('layouts.frontend.app')

@section('title', 'Portal Berita')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.articles', $article->category->slug) }}">{{ $article->category->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 30) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <!-- Main Content Area -->
        <div class="col-md-8">
            <article class="blog-post">
                <h1 class="blog-post-title mb-3">{{ $article->title }}</h1>
                
                <div class="blog-post-meta mb-4">
                    <span class="mr-3"><i class="fas fa-user"></i> {{ $article->user->name }}</span>
                    <span class="mr-3"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</span>
                    <span class="mr-3"><i class="fas fa-folder"></i> {{ $article->category->name }}</span>
                    <span><i class="fas fa-eye"></i> {{ $article->view_count }} views</span>
                </div>
                
                @if($article->featured_image)
                    <div class="featured-image mb-4">
                        <img src="{{asset('dist/img/photo4.jpg')}}" alt="{{ $article->title }}" class="img-fluid rounded">
                    </div>
                @endif
                
                <div class="article-content">
                    {!! $article->content !!}
                </div>

                
                <div class="article-share mt-4">
                    <h5>Share This Article:</h5>
                    <div class="social-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-sm btn-primary mr-2">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $article->title }}" target="_blank" class="btn btn-sm btn-info mr-2">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ $article->title }} {{ url()->current() }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </article>
            
            <!-- Author Info -->
            <div class="card mt-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img src="https://via.placeholder.com/80" alt="{{ $article->user->name }}" class="rounded-circle">
                        </div>
                        <div class="col-md-10">
                            <h5>{{ $article->user->name }}</h5>
                            <p class="text-muted">Author</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae eros quis nisl aliquam aliquet.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Articles -->
            <div class="related-articles mt-5">
                <h3 class="mb-4">Related Articles</h3>
                <div class="row">
                    @foreach($relatedArticles as $relatedArticle)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <img class="card-img-top" src="{{asset('dist/img/photo4.jpg')}}" alt="{{ $relatedArticle->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relatedArticle->title }}</h5>
                                    <p class="card-text text-truncate" style="max-height: 4.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        {!! strip_tags($relatedArticle->content) !!}
                                    </p>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($relatedArticle->published_at)->diffForHumans() }}</small>
                                        <a href="{{ route('article', $relatedArticle->id) }}" class="btn btn-sm btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Search Widget -->
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <form action="{{ route('article.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search for...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Go!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Categories Widget -->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled mb-0">
                                @foreach($categories as $cat)
                                    <li class="mb-2">
                                        <a href="{{ route('category.articles', $cat->slug) }}" class="d-flex justify-content-between align-items-center">
                                            {{ $cat->name }}
                                            <span class="badge badge-primary badge-pill">{{ $cat->articles_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Popular Articles Widget -->
            <div class="card mb-4">
                <div class="card-header">Popular Articles</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($popularArticles as $popularArticle)
                            <li class="media mb-3">
                                <img src="{{asset('dist/img/photo4.jpg')}}" class="mr-3" alt="{{ $popularArticle->title }}" style="width: 64px; height: 64px; object-fit: cover;">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">
                                        <a href="{{ route('article', $popularArticle->id) }}">{{ Str::limit($popularArticle->title, 50) }}</a>
                                    </h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($popularArticle->published_at)->diffForHumans() }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Tags Widget -->
            <div class="card mb-4">
                <div class="card-header">Tags</div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        {{-- @foreach($tags as $tag) --}}
                            {{-- <a href="#" class="badge badge-secondary mr-2 mb-2 p-2">{{ $tag }}</a> --}}
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Increment view count
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('article.increment-view', $article->id) }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            }
        });
    });
</script>
@endsection
