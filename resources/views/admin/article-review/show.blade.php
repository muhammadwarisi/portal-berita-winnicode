@extends('layouts.backend.app')

@section('header', 'Detail Artikel')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('reviewer.artikel.index') }}">Artikel Review</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $article->title }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <dl class="row">
                            <dt class="col-sm-3">Judul</dt>
                            <dd class="col-sm-9">{{ $article->title }}</dd>
                            
                            <dt class="col-sm-3">Penulis</dt>
                            <dd class="col-sm-9">{{ $article->user->name }}</dd>
                            
                            <dt class="col-sm-3">Kategori</dt>
                            <dd class="col-sm-9">{{ $article->category->name }}</dd>
                            
                            <dt class="col-sm-3">Tanggal Dibuat</dt>
                            <dd class="col-sm-9">{{ $article->created_at->format('d F Y H:i') }}</dd>
                            
                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">
                                @php
                                    $review = $article->reviews->where('reviewer_id', auth()->id())->first();
                                    $status = $review ? $review->status : 'pending';
                                @endphp
                                @if($status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid">
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4>Konten Artikel</h4>
                        <div class="border p-3">
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <a href="{{ route('reviewer.artikel.index') }}" class="btn btn-secondary">Kembali</a>
                        @if($status == 'pending')
                            <a href="{{ route('reviewer.artikel.review-form', $article->id) }}" class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Review Artikel
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection