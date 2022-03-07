@extends('Layout.index')

@section('content-title')
Rumusan
@endsection

@section('content-body')
<!--begin::Subheader-->
<div class="subheader py-4 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h1 class="text-dark font-weight-bold my-1 mr-5">Rumusan</h1>
                <!--end::Page Title-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Actions-->
            <a href="#" class="btn btn-light-success font-weight-bolder btn-sm mr-2"><i class="fas fa-plus fa-sm"></i> Kategori</a>
            <a href="#" class="btn btn-light-danger font-weight-bolder btn-sm"><i class="fas fa-trash fa-sm"></i> Kategori</a>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->

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
                            @foreach($data as $d)
                            @php
                                $rumus = json_decode($d->rumus);
                            @endphp
                                <div class="col-md-6">
                                    <h3 class="text-primary">Kategori {{$d->kategori}}</h3>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend col-3">
                                                <span class="input-group-text col-12">1 {{$rumus->satuan}} :</span>
                                            </div>
                                            <input type="text" class="number form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Nilai Rupiah" value="{{($rumus->rupiah == null) ? '' : number_format($rumus->rupiah, 0, ',', '.')}}" />
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
                                            <input type="text" class="float form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Jumlah {{$rumus->satuan}}" value="{{($rumus->jiwa == null) ? '' : number_format($rumus->jiwa, 2, ',', '.')}}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{$rumus->satuan}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
<script>
$('#rumusan-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/dashboard",
        cache: false,
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend:function(){
            $.blockUI({
                message: '<i class="fad fa-spin fa-spinner text-white"></i>',
                baseZ: 9999,
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.5,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        },
        success:function(data)
        {
            if(data.success){
                toastr.success(data.success);
            }

            if(data.info){
                toastr.info(data.info);
            }

            if(data.warning){
                toastr.warning(data.warning);
            }

            if(data.error){
                toastr.error(data.error);
            }

            if(data.debug){
                console.log(data.debug);
            }
        },
        error:function(data){
            if (data.status == 422) {
                $.each(data.responseJSON.errors, function (i, error) {
                    toastr.error(error[0]);
                });
            }
            else{
                toastr.error("System error.");
                console.log(data);
            }
        },
        complete:function(data){
            $.unblockUI();
        }
    });
});
</script>
@endsection
