@extends('Layout.index')

@section('content-title')
Rumusan
@endsection

@section('content-body')
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <form id="rumusan-form">
                            <div class="form-group">
                                <div class="alert alert-custom alert-default" role="alert">
                                    <div class="alert-icon">
                                        <i class="fas fa-info fa-md"></i>
                                    </div>
                                    <div class="alert-text">
                                        Rumusan adalah takaran umum Zakat Fitrah berupa <span class="text-primary">Beras (Bahan Pokok)</span> dan <span class="text-primary">Konversi Nilai Mata Uang</span> yang diberlakukan di Masjid Baiturrahman. <span class="text-primary">Isi sesuai dengan ketentuan</span>.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-primary">Kategori 1</h3>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend col-3">
                                                <span class="input-group-text col-12">1 Liter :</span>
                                            </div>
                                            <input type="text" class="number form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Nilai Rupiah" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rupiah</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend col-3">
                                                <span class="input-group-text col-12">1 Jiwa :</span>
                                            </div>
                                            <input type="text" class="float form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Jumlah Liter" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">Liter</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-primary">Kategori 2</h3>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend col-3">
                                                <span class="input-group-text col-12">1 Kg :</span>
                                            </div>
                                            <input type="text" class="number form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Nilai Rupiah" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rupiah</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend col-3">
                                                <span class="input-group-text col-12">1 Jiwa :</span>
                                            </div>
                                            <input type="text" class="float form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Jumlah Kilogram" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">Kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-rounded btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-modal')
@endsection

@section('content-js')
@endsection
