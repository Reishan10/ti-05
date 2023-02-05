@extends('layouts.backend_main')

@section('title', 'Tambah Postingan')

@section('content')
    <!-- SimpleMDE css -->
    <link href="{{ asset('assets') }}/css/vendor/simplemde.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/dropify.css" rel="stylesheet" type="text/css" />

    <style>
        .CodeMirror,
        .CodeMirror-scroll {
            height: 580px;
        }
    </style>

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
                                        <input type="text" id="title" name="title" class="form-control"
                                            value="{{ old('title') }}">
                                        <div class="invalid-feedback errorTitle"></div>

                                        <input type="text" id="slug" name="slug" class="form-control mt-2"
                                            placeholder="Permalink" style="background-color: #F8F8F8; color:blue;"
                                            value="{{ old('slug') }}">
                                        <div class="invalid-feedback errorSlug"></div>

                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea id="simplemde1" class="form-control" name="content">{{ old('content') }}</textarea>
                                        <small class="text-danger errorContent"></small>
                                    </div>
                                </div> <!-- end card body-->
                            </div>
                        </div> <!-- end card -->
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="dropify" name="image" id="image">
                                        <small class="text-danger errorImage"></small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback errorKategori"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tag" class="form-label">Tag</label>
                                        <div style="overflow-y:scroll;height:150px;margin-bottom:30px;">
                                            <div class="form-group">
                                                <label>
                                                    @foreach ($tag as $row)
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="tag[]" id="tag"
                                                                    value="{{ $row->name }}">
                                                                {{ $row->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                        <small class="text-danger errorTags"></small>
                                    </div>
                                    <div class="mb-3 d-grid gap-2">
                                        <button type="submit" class="btn btn-primary" id="publish">Publish</button>
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

    <!-- SimpleMDE js -->
    <script src="{{ asset('assets') }}/js/vendor/simplemde.min.js"></script>
    <!-- SimpleMDE demo -->
    <script src="{{ asset('assets') }}/js/pages/demo.simplemde.js"></script>
    <script src="{{ asset('assets') }}/js/dropify.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    data: new FormData(this),
                    url: "{{ route('post.store') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#publish').attr('disable', 'disabled');
                        $('#publish').text('Proses...');
                    },
                    complete: function() {
                        $('#publish').removeAttr('disable');
                        $('#publish').html('Publish');
                    },
                    success: function(response) {
                        if (response.errors) {
                            if (response.errors.title) {
                                $('#title').addClass('is-invalid');
                                $('.errorTitle').html(response.errors.title);
                            } else {
                                $('#title').removeClass('is-invalid');
                                $('.errorTitle').html('');
                            }

                            if (response.errors.slug) {
                                $('#slug').addClass('is-invalid');
                                $('.errorSlug').html(response.errors.slug);
                            } else {
                                $('#slug').removeClass('is-invalid');
                                $('.errorSlug').html('');
                            }

                            if (response.errors.content) {
                                $('.errorContent').html(response.errors.content);
                            } else {
                                $('.errorContent').html('');
                            }

                            if (response.errors.image) {
                                $('.errorImage').html(response.errors.image);
                            } else {
                                $('.errorImage').html('');
                            }

                            if (response.errors.kategori) {
                                $('#kategori').addClass('is-invalid');
                                $('.errorKategori').html(response.errors.kategori);
                            } else {
                                $('#kategori').removeClass('is-invalid');
                                $('.errorKategori').html('');
                            }

                            if (response.errors.tag) {
                                $('.errorTags').html(response.errors.tag);
                            } else {
                                $('.errorTags').html('');
                            }


                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                            }).then(function() {
                                top.location.href = "{{ route('post.index') }}";
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });
        });

        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
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
