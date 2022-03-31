<!--begin::Modal-->
<div class="modal fade" id="check-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="check-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah @include('Transaction.Fitrah.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="check-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Rumusan</label>
                        <select class="form-control" id="check-rumusan" name="check_rumusan">
                            @foreach($rumusan as $d)
                            <option value="{{$d->id}}">Kategori {{$d->kategori}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih Muzakki</label>
                        <select required class="form-control" id="check-muzakki" name="check_muzakki" style="width:100%"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success font-weight-bold">Check</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah @include('Transaction.Fitrah.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="tambah-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-8 mb-sm-0">
                            <small class="text-muted pt-4 db">Rumusan</small>
                            <h6 id="showRupiah"></h6>
                            <h6 id="showJiwa"></h6>
                            <small class="text-muted pt-4 db">Muzakki</small>
                            <h6 id="showMuzakki"></h6>
                            <div id="showFamily"></div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-center mb-8"><b><u>Yang Harus Dibayar</u></b></h4>
                            <div class="d-flex justify-content-between mb-4">
                                <div>
                                    <span class="text-primary">Nama</span>
                                </div>
                                <div>
                                    <span class="text-primary" id="showSatuan"></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 id="nameMuzakki"></h6>
                                </div>
                                <div>
                                    <h6><span class="nominal" id="nominalMuzakki"></span> <span class="satuan" id="satuanMuzakki"></span></h6>
                                </div>
                            </div>
                            <div id="nominalFamily"></div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="text-primary">TOTAL</h4>
                                </div>
                                <div>
                                    <h4 class="text-primary" id="total"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    function tambah_init(){
        $("#check-rumusan").prop("selectedIndex", 0).val();
        $("#check-muzakki").val('').html('');
    }

    $("#add").click(function(){
        tambah_init();

        $("#check-modal").modal("show");
    });

    $('#check-muzakki').select2({
        placeholder: "Cari Muzakki",
        allowClear: true,
        ajax: {
            url: "/search/muzakki",
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (d) {
                        return {
                            id: d.id,
                            text: d.name + '(' + d.hp + ')'
                        }
                    })
                };
            },
        }
    });

    $('#tambah-modal').on('shown.bs.modal', function(e) {
        e.preventDefault();

        function muzakki(){
            if($(this).is(":checked")){
                $(".index" + $(this).attr("index")).show();
            }
            else{
                $(".index" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.muzakki').click(muzakki);

        function totalBayar(){
            var nominal = 0;
            $('.nominal:visible').each(function() {
                var value = Number($(this).text().replace(/\./g, ''));
                nominal += value;
            });

            var satuan = 0;
            $('.satuan:visible').each(function() {
                var value = Number($(this).text().replace(/\,/g, '.'));
                satuan += value;
            });

            $("#total").text('Rp. ' + nominal.toLocaleString('id-ID') + ' (' + satuan.toLocaleString('id-ID') + ')');
        }
    });

    $('#check-form').on('submit', function(e){
        e.preventDefault();
        var totalRupiah = 0;
        var totalSatuan = 0;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/production/transaction/fitrah/0",
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
                    $('#tambah-modal').modal('show');
                    $('#showRupiah').text('Rp. ' + data.success.rumusan.rupiah.toLocaleString('id-ID') + ' per-' + data.success.rumusan.satuan);
                    $('#showJiwa').text(data.success.rumusan.jiwa.toLocaleString('id-ID') + " " + data.success.rumusan.satuan + ' per-Jiwa');
                    $('#showMuzakki').text(data.success.muzakki.name);

                    var html = '';
                    if(data.success.family.length > 0){
                        html += '<small class="text-muted pt-4 db">Anggota Keluarga</small>';

                        $.each(data.success.family, function(i, val){
                            html += '<div class="checkbox-inline d-flex pt-3" >';
                            html += '<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">';
                            html += '<input checked class="muzakki" type="checkbox" name="tambah_muzakki[]" value="{{Crypt::encrypt(' + val.id + ')}}" index="' + i + '" />';
                            html += '<span></span>' + val.name;
                            html += '</label>';
                            html += '</div>';
                        })
                    }
                    $("#showFamily").html(html);

                    //Yang Harus Dibayar
                    $("#showSatuan").text("Rupiah (" + data.success.rumusan.satuan + ")");

                    if(data.success.muzakki.name.length > 15){
                        $("#nameMuzakki").text(data.success.muzakki.name.substring(0,15) + "...");
                    } else {
                        $("#nameMuzakki").text(data.success.muzakki.name);
                    }

                    var nominalRupiah = Number(data.success.rumusan.rupiah * data.success.rumusan.jiwa);
                    var nominalSatuan = data.success.rumusan.jiwa;
                    $("#nominalMuzakki").text(nominalRupiah.toLocaleString('id-ID'));
                    $("#satuanMuzakki").text("" + nominalSatuan.toLocaleString('id-ID') + "");
                    //End Yang Harus Dibayar

                    totalRupiah += nominalRupiah;
                    totalSatuan += nominalSatuan;

                    var html = '';
                    if(data.success.family.length > 0){
                        $.each(data.success.family, function(i, val){
                            var nominalRupiah = Number(data.success.rumusan.rupiah * data.success.rumusan.jiwa);
                            var nominalSatuan = data.success.rumusan.jiwa;

                            html += '<div class="d-flex justify-content-between">';
                            html += '<div>';
                            html += '<h6>' + val.name + '</h6>';
                            html += '</div>';
                            html += '<div>';
                            html += '<h6 class="index' + i + '"><span class="nominal">' + nominalRupiah.toLocaleString('id-ID') + '</span> <span class="satuan">' + nominalSatuan.toLocaleString('id-ID') + '</span></h6>';
                            html += '</div>';
                            html += '</div>';

                            totalRupiah += nominalRupiah;
                            totalSatuan += nominalSatuan;
                        })
                    }
                    $("#nominalFamily").html(html);

                    $("#total").text(totalRupiah.toLocaleString('id-ID') + " (" + totalSatuan.toLocaleString('id-ID') + ")");
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
                    $('#check-modal').modal('hide');
                    dtableReload();
                }
                setTimeout(() => {
                    $.unblockUI();
                }, 750);
            }
        });
    });

    $('#tambah-form').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/production/transaction/fitrah/1",
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
                if(JSON.parse(data.responseText).success){
                    $('#tambah-modal').modal('hide');
                    dtableReload();
                }
                setTimeout(() => {
                    $.unblockUI();
                }, 750);
            }
        });
    });
</script>
<!--end::Javascript-->
