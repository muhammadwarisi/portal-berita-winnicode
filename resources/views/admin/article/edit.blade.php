@extends('layouts.backend.app')

@section('header', 'Edit Artikel')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Artikel</li>
    <li class="breadcrumb-item active">Edit Artikel</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Edit Artikel</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('update.artikel', $article->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" value="{{ $article->title }}" required/>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category_id" class="form-control select2bs4" style="width: 100%;" required>
                                    @foreach ($category as $item)
                                    <option value="{{$item->id}}" {{ $article->category_id == $item->id ? 'selected' : '' }}>
                                        {{$item->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Gambar Judul</label>
                                <div class="mb-2">
                                    <img src="{{ Storage::url($article->featured_image) }}" alt="Current Image" style="max-width: 200px">
                                </div>
                                <div class="input-group">
                                    <input type="file" name="featured_image" class="form-control"/>
                                    <label class="input-group-text">Upload New Image</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Artikel</label>
                                <textarea class="summernote-simple" name="content" required>{{ $article->content }}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Update Article</button>
                                <a href="{{ route('index.artikel') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function() {
            $(".summernote-simple").summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['paragraph']]
                ]
            });
        })
    </script>
@endsection