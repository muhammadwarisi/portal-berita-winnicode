@extends('layouts.backend.app')

@section('header', 'Artikel Yang Anda Buat')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Artikel</li>
    <li class="breadcrumb-item active">Buat Artikel</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Tulis Artikel Anda
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('store.artikel') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputGroupFile02">Tulis Judul</label>
                                <input type="text" name="title" class="form-control col-sm-6 col-md-6" required/>
                            </div>
                            <div class="form-group">
                                <label>Pilih Categori</label>
                                <select name="category_id" class="form-control select2bs4" style="width: 100%;" required>
                                    @foreach ($category as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="inputGroupFile02">Upload Gambar Judul</label>
                            <div class="input-group">
                                <input type="file" name="featured_image" class="form-control col-sm-6 col-md-6" id="inputGroupFile02" required/>
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>

                            <div class="col-sm-12 col-md-12 form-group">
                                <label for="summernote-simple">Artikel</label>
                                <textarea class="summernote-simple" name="content" placeholder="Tulis artikel disini" required></textarea>
                            </div>
                            
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Submit Article</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script> --}}
    <!-- CodeMirror -->
    <!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
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
