@extends('Layout.index')

@section('content-title')
@include('Users.Partial._title')
@endsection

@section('content-body')
@include('Users.Partial._subheader')

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        @include('Users.Partial._alert', ['text' => 'Pengguna adalah entitas yang memiliki <span class="text-primary">hak akses</span> dan <span class="text-primary">hak kelola</span> Aplikasi Zakat di Masjid Baiturrahman.'])

                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-modal')
@include('Users.Partial._modal')
@endsection

@section('content-js')
@endsection
