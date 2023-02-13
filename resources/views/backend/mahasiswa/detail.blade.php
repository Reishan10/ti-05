@extends('layouts.backend_main')

@section('title', 'Detail Mahasiswa')

@section('content')
    <link href="{{ asset('assets') }}/css/dropify.css" rel="stylesheet" type="text/css" />
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
