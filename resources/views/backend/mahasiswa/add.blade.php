@extends('layouts.backend_main')

@section('title', 'Tambah Mahasiswa')

@section('content')
    <link href="{{ asset('assets') }}/css/dropify.css" rel="stylesheet" type="text/css" />
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <form action="{{ route('mahasiswa.store') }}" method="post" id="mahasiswaForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">Nomor Induk Mahasiswa</label>
                                        <input type="number" id="nim" name="nim" class="form-control">
                                        <div class="invalid-feedback errorNIM">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="nama" name="nama" class="form-control">
                                        <div class="invalid-feedback errorNama">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <div class="invalid-feedback errorJenisKelamin">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control">
                                        <div class="invalid-feedback errorTempatLahir">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control">
                                        <div class="invalid-feedback errorTanggalLahir">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telepon" class="form-label">No Telepon</label>
                                        <input type="number" id="no_telepon" name="no_telepon" class="form-control">
                                        <div class="invalid-feedback errorNoTelepon">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" class="dropify" name="foto" id="foto">
                                        <small class="text-danger errorFoto"></small>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-secondary mb-3"
                                        onclick="window.location='{{ route('mahasiswa.index') }}'">Kembali</button>
                                    <button type="submit" class="btn btn-primary mb-3" id="simpan">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets') }}/js/dropify.js"></script>

    <script>
        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#mahasiswaForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    data: new FormData(this),
                    url: "{{ route('mahasiswa.store') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('#simpan').attr('disable', 'disabled');
                        $('#simpan').text('Proses...');
                    },
                    complete: function() {
                        $('#simpan').removeAttr('disable');
                        $('#simpan').html('Simpan');
                    },
                    success: function(response) {
                        if (response.errors) {
                            if (response.errors.nim) {
                                $('#nim').addClass('is-invalid');
                                $('.errorNIM').html(response.errors.nim);
                            } else {
                                $('#nim').removeClass('is-invalid');
                                $('.errorNIM').html('');
                            }

                            if (response.errors.nama) {
                                $('#nama').addClass('is-invalid');
                                $('.errorNama').html(response.errors.nama);
                            } else {
                                $('#nama').removeClass('is-invalid');
                                $('.errorNama').html('');
                            }

                            if (response.errors.jenis_kelamin) {
                                $('#jenis_kelamin').addClass('is-invalid');
                                $('.errorJenisKelamin').html(response.errors.jenis_kelamin);
                            } else {
                                $('#jenis_kelamin').removeClass('is-invalid');
                                $('.errorJenisKelamin').html('');
                            }

                            if (response.errors.tempat_lahir) {
                                $('#tempat_lahir').addClass('is-invalid');
                                $('.errorTempatLahir').html(response.errors.tempat_lahir);
                            } else {
                                $('#tempat_lahir').removeClass('is-invalid');
                                $('.errorTempatLahir').html('');
                            }

                            if (response.errors.tgl_lahir) {
                                $('#tgl_lahir').addClass('is-invalid');
                                $('.errorTanggalLahir').html(response.errors.tgl_lahir);
                            } else {
                                $('#tgl_lahir').removeClass('is-invalid');
                                $('.errorTanggalLahir').html('');
                            }

                            if (response.errors.no_telepon) {
                                $('#no_telepon').addClass('is-invalid');
                                $('.errorNoTelepon').html(response.errors.no_telepon);
                            } else {
                                $('#no_telepon').removeClass('is-invalid');
                                $('.errorNoTelepon').html('');
                            }

                            if (response.errors.foto) {
                                $('#foto').addClass('is-invalid');
                                $('.errorFoto').html(response.errors.foto);
                            } else {
                                $('#foto').removeClass('is-invalid');
                                $('.errorFoto').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                            }).then(function() {
                                top.location.href = "{{ route('mahasiswa.index') }}";
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
    </script>
@endsection
