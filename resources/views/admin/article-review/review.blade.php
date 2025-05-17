@extends('layouts.backend.app')

@section('header', 'Review Artikel')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('reviewer.artikel.index') }}">Artikel Review</a></li>
    <li class="breadcrumb-item active">Review</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Review Artikel: {{ $article->title }}</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <dl class="row">
                            <dt class="col-sm-3">Judul</dt>
                            <dd class="col-sm-9">{{ $article->title }}</dd>
                            
                            <dt class="col-sm-3">Penulis</dt>
                            <dd class="col-sm-9">{{ $article->user->name }}</dd>
                            
                            <dt class="col-sm-3">Kategori</dt>
                            <dd class="col-sm-9">{{ $article->category->name }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid">
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Konten Artikel</h4>
                        <div class="border p-3" style="max-height: 400px; overflow-y: auto;">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('reviewer.artikel.submit-review', $article->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Status Review</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-4">
                                <input class="custom-control-input" type="radio" id="approved" name="status" value="approved" required>
                                <label for="approved" class="custom-control-label">Setujui Artikel</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="rejected" name="status" value="rejected" required>
                                <label for="rejected" class="custom-control-label">Tolak Artikel</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="comments">Komentar Review</label>
                        <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" rows="5" required>{{ old('comments') }}</textarea>
                        @error('comments')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Berikan komentar yang konstruktif tentang artikel ini. Jika ada perbaikan yang diperlukan, jelaskan dengan detail.</small>
                    </div>
                    
                    <div class="form-group">
                        <a href="{{ route('reviewer.artikel.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection