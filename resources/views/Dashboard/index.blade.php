@extends('Layout.index')

@section('content-title')
@include('Dashboard.Partial._title')
@endsection

@section('content-body')
@include('Dashboard.Partial._subheader')

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        @include('Dashboard.Partial._alert', ['text' => 'Rumusan adalah takaran umum Zakat Fitrah berupa <span class="text-primary">Beras (Bahan Pokok)</span> dan <span class="text-primary">Konversi Nilai Mata Uang</span> yang diberlakukan di Masjid Baiturrahman. <span class="text-primary">Isi sesuai dengan ketentuan</span>.'])

                        <form id="rumus-form">
                            <div class="row">
                            @foreach($data as $d)
                            @php
                                $rumus = json_decode($d->rumus);
                            @endphp
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="text-primary">Kategori {{$d->kategori}}</h3>
                                        <div>
                                            <a href="javascript:void(0)"tabindex="-1" class="edit-rumus mr-2" rumus-id="{{Crypt::encrypt($d->id)}}"><i class="fas fa-edit text-primary"></i></a>
                                            <a href="javascript:void(0)"tabindex="-1" class="hapus-rumus" rumus-id="{{Crypt::encrypt($d->id)}}"><i class="fas fa-trash text-danger"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend col-3">
                                                <span class="input-group-text col-12">1 {{$rumus->alternatif}} :</span>
                                            </div>
                                            <input required type="text" name="rumus_rupiah_{{$d->id}}" class="number form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Nilai Rupiah" value="{{($rumus->rupiah == null) ? '' : number_format($rumus->rupiah, 0, ',', '.')}}" />
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
                                            <input required type="text" name="rumus_satuan_{{$d->id}}" class="float form-control" maxlength="11" autocomplete="off" placeholder="Masukkan Jumlah {{$rumus->satuan}}" value="{{($rumus->jiwa == null) ? '' : number_format($rumus->jiwa, 2, ',', '.')}}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{$rumus->alternatif}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="rumus_id_hidden[]" value="{{$d->id}}" />
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
@include('Dashboard.Partial._modal')
@endsection

@section('content-js')
<script>
$('#rumus-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/dashboard/all",
        cache: false,
        method: "PUT",
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
            if(JSON.parse(data.responseText).success){
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
            setTimeout(() => {
                $.unblockUI();
            }, 1000);
        }
    });
});
</script>
@endsection
