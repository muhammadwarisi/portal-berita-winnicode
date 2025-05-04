@extends('layouts.backend.app')

@section('header', 'Detail Article')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('index.artikel') }}">Article</a></li>
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
                    <div class="col-md-12 mb-4">
                        <label for="img">Image Banner</label>
                        <img src="{{ Storage::url($article->featured_image) }}" id="img" alt="Featured Image" width="100" class="img-fluid">
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px">Judul</th>
                                <td>{{ $article->title }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Category</th>
                                <td>{{ $article->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Author</th>
                                <td>{{ $article->user->name }}</td>
                            </tr>
                            <tr>
                                @php
                                    $published = date_create($article->published_at);
                                @endphp
                                <th>Published Date</th>
                                <td>{{ date_format($published,'d F Y H:i') }}</td>
                            </tr>
                        </table>
                        
                        <div class="content mt-4">
                            <h5>Article:</h5>
                            <div class="p-3">
                                {!! $article->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('index.artikel') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection