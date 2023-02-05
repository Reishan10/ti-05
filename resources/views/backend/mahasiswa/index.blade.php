@extends('layouts.backend_main')

@section('title', 'Mahasiswa')

@section('content')
    <link href="{{ asset('assets') }}/css/dropify.css" rel="stylesheet" type="text/css" />
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Mahasiswa</h4>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-preview">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-danger mb-3 btn-sm" id="btnHapusBanyak">
                                        <i class="mdi mdi-trash-can"></i> Hapus Banyak
                                    </button>
                                    <button type="button" class="btn btn-primary mb-3 btn-sm" id="btnTambah">
                                        <i class="mdi mdi-plus"></i> Tambah Data
                                    </button>
                                </div>
                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th width="1px"><input type="checkbox" id="check_all"></th>
                                            <th>#</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir</th>
                                            <th>No Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
        </div>
        <!-- end page title -->
    </div>

    <!-- Mahasiswa modal -->
    <div id="mahasiswaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mahasiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="mahasiswaForm">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="mahasiswaModalLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="{{ asset('assets') }}/js/dropify.js"></script>

    <script>
        function removeValidation(name, errorName) {
            $(name).removeClass('is-invalid');
            $(errorName).html('');
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('mahasiswa.index') }}",
                columns: [{
                        data: 'comboBox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nim',
                        name: 'NIM'
                    },
                    {
                        data: 'nama',
                        name: 'Nama'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'Tanggal Lahir'
                    },
                    {
                        data: 'no_telepon',
                        name: 'No Telepon'
                    },
                    {
                        data: 'aksi',
                        name: 'Aksi'
                    }
                ]
            });

            // Tambah Data
            $('#btnTambah').click(function() {
                $('#nim').val('');
                $('#mahasiswaModalLabel').html("Tambah Mahasiswa");
                $('#mahasiswaModal').modal('show');
                $('#mahasiswaForm').trigger("reset");

                removeValidation('#nim', '.errorNIM');
                removeValidation('#nama', '.errorNama');
                removeValidation('#jenis_kelamin', '.errorJenisKelamin');
                removeValidation('#tempat_lahir', '.errorTempatLahir');
                removeValidation('#tgl_lahir', '.errorTanggalLahir');
                removeValidation('#no_telepon', '.errorNoTelepon');
                removeValidation('#foto', '.errorFoto');

                $("#foto").next(".dropify-clear").trigger("click");
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
                            })

                            $('#mahasiswaModal').modal('hide');
                            $('#mahasiswaForm').trigger("reset");
                            $("#foto").next(".dropify-clear").trigger("click");
                            $('#datatable').DataTable().ajax.reload()
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });
        });

        // Hapus Data
        $('body').on('click', '#btnHapus', function() {
            let nim = $(this).data('nim');
            Swal.fire({
                title: 'Hapus',
                text: "Apakah anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('mahasiswa/"+nim+"') }}",
                        data: {
                            nim: nim
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.success,
                                });
                                $('#datatable').DataTable().ajax.reload()
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    })
                }
            })
        })

        // Hapus Data Banyak
        $('#btnHapusBanyak').on('click', function(e) {
            let idArr = [];
            $(".checkbox:checked").each(function() {
                idArr.push($(this).attr('data-nim'));
            });
            if (idArr.length <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih data terlebih dahulu untuk dihapus!',
                })
            } else {
                Swal.fire({
                    title: 'Hapus',
                    text: "Apakah anda yakin?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    let strId = idArr.join(",");
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete-multiple-mahasiswa') }}",
                            type: 'POST',
                            data: 'nim=' + strId,
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: response.success,
                                    });
                                    $('#datatable').DataTable().ajax.reload();
                                    $("#check_all").prop('checked', false);
                                    $(".checkbox").prop('checked', false);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            }
                        })
                    }
                })
            }
        });

        // Ceklis Checkbox Hapus Banyak
        $('#check_all').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".checkbox").prop('checked', true);
            } else {
                $(".checkbox").prop('checked', false);
            }
        });

        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove: 'Hapus',
                error: 'error'
            }
        });
    </script>
@endsection
