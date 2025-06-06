<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
            <a class="blog-header-logo text-dark" href="{{ route('homepage') }}">KilasBerita</a>
        </div>
        <div class="col-4 text-center">
            {{-- <a class="text-muted" href="#">Subscribe</a> --}}
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            <div class="search-container mr-2">
                <form id="searchForm" action="{{route('article.search')}}" class="form-inline">
                    <div class="input-group">
                        <input type="text" id="searchInput" name="q" class="form-control form-control-sm" placeholder="Cari berita..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="10.5" cy="10.5" r="7.5"></circle>
                                    <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @auth
                <a class="btn btn-sm btn-outline-secondary" href="{{ Route('dashboard') }}">Dashboard</a>
            @else
                <a class="btn btn-sm btn-outline-secondary" href="{{ Route('login') }}">Sign up</a>
            @endauth
        </div>
    </div>
</header>
<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
        @foreach ($categories as $category)
            <a class="p-2 text-muted nav-link {{ request()->is('category/' . $category->slug) ? 'active' : '' }}"
                href="{{ route('category.articles', $category->slug) }}">{{ $category->name }}</a>
        @endforeach
    </nav>
</div>
