@extends('layouts.backend_main')

@section('title', 'Tambah Postingan')

@section('content')
    <!-- Quill css -->
    <link href="{{ asset('assets') }}/css/vendor/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/vendor/quill.snow.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/dropify.css" rel="stylesheet" type="text/css" />

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Tambah Postingan</h4>
                </div>
                <form action="{{ route('post.store') }}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <input type="text" id="slug" name="slug"
                                            class="form-control mt-2 @error('slug') is-invalid @enderror"
                                            placeholder="Permalink"
                                            style="background-color: #F8F8F8;outline-color: none;border:0;color:blue;"
                                            value="{{ old('slug') }}">
                                        @error('slug')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <div id="snow-editor" name=content style="height: 555px;"></div>
                                        @error('content')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div> <!-- end card body-->
                            </div>
                        </div> <!-- end card -->
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="dropify" name="image">
                                        @error('image')
                                            <small class="text-danger"> {{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori"
                                            class="form-control @error('kategori') is-invalid @enderror">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tag" class="form-label">Tag</label>
                                        <div style="overflow-y:scroll;height:150px;margin-bottom:30px;">
                                            <div class="form-group">
                                                <label>
                                                    @foreach ($tag as $row)
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="tag[]"
                                                                    value="{{ $row->name }}"> {{ $row->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Publish</button>
                                    </div>
                                </div> <!-- end card body-->
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <label for="description" class="form-label">Meta Description</label>
                                    <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div> <!-- end card -->
                    </div>
                </form>
            </div>
        </div>
        <!-- end page title -->
    </div>


    <script src="{{ asset('assets') }}/js/vendor/quill.min.js"></script>
    <script src="{{ asset('assets') }}/js/pages/demo.quilljs.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/dropzone.min.js"></script>
    <script src="{{ asset('assets') }}/js/ui/component.fileupload.js"></script>
    <script src="{{ asset('assets') }}/js/dropify.js"></script>
    <script>
        $(document).ready(function() {
            $("#form").on("submit", function() {
                var hvalue = $('#snow-editor').html();
                $(this).append("<textarea name='content' style='display:none'>" + hvalue +
                    "</textarea>");
            });
        });

        $('.dropify').dropify({
            messages: {
                default: 'Upload',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });

        $('#title').keyup(function() {
            let title = $(this).val().toLowerCase().replace(/[&\/\\#^, +()$~%.'":*?<>{}]/g, '-');
            $('#slug').val(title);
        });
    </script>
@endsection
