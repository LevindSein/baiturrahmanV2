<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah @include('Dashboard.Muzakki.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="tambah-form">
                <div class="modal-body" style="height: 45vh;">
                    <div class="form-group">
                        <label>Nama Muzakki <span class="text-danger">*</span></label>
                        <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="100" class="form-control" placeholder="Masukkan Nama Muzakki" />
                    </div>
                    <div class="form-group">
                        <label>Nomor HP <span class="text-danger">*</span></label>
                        <input required type="tel" id="tambah-hp" name="tambah_hp" autocomplete="off" minlength="11" maxlength="15" placeholder="0852123xxxxx" class="phone form-control" />
                    </div>
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea required rows="5" id="tambah-address" name="tambah_address" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control"></textarea>
                    </div>
                    <div class="form-group" id="tambah-pilih">
                        <label>Pilih Kepala Keluarga</label>
                        <select class="form-control" id="tambah-family" name="tambah_family" style="width:100%"></select>
                        <span class="form-text text-muted">Pilih Kepala Keluarga jika Muzakki ditanggung</span>
                    </div>
                    <label>Checklist apabila Muzakki termasuk Mustahik</label>
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            <div class="checkbox-inline d-flex pt-3">
                                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                    <input type="checkbox" name="tambah_mustahik" id="tambah-mustahik" />
                                    <span></span>Mustahik
                                </label>
                            </div>
                        </div>
                        <div class="col-9 col-form-label">
                            <select required class="form-control" id="tambah-type" name="tambah_type">
                                <option value="" disabled selected>Pilih Kategori Mustahik</option>
                                <option value="1">Fakir</option>
                                <option value="2">Miskin</option>
                                <option value="3">Fi Sabilillah</option>
                                <option value="4">Mualaf</option>
                                <option value="5">Gharim</option>
                                <option value="6">Ibnu Sabil</option>
                                <option value="7">Amil Zakat</option>
                                <option value="8">Riqab</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><sup><span class="text-danger">*) Wajib diisi.</span></sup></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
function tambah_init(){
    $("#tambah-name").val('');
    $("#tambah-hp").val('');
    $("#tambah-address").val('');
    $("#tambah-family").val('').html('');
    $("#tambah-mustahik").prop('checked', false);
    $("#tambah-type").val('').prop('disabled', true).prop('required', false);
}

$("#add").click(function(){
    $("#tambah-modal").modal("show");

    tambah_init();

    $('#tambah-modal').on('shown.bs.modal', function() {
        $("#tambah-name").focus();
    });
});

$("#tambah-name").on('input change', function() {
    this.value = this.value.replace(/[^0-9a-zA-Z/\s.,]+$/g, '');
    this.value = this.value.replace(/\s\s+/g, ' ');
});

$('.phone').on('input change', function(e) {
    $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
});

$('.phone').on('keypress', function(e) {
    keys = ['0','1','2','3','4','5','6','7','8','9']
    return keys.indexOf(e.key) > -1
});

$('#tambah-family').select2({
    placeholder: "Cari Nama Kepala Keluarga",
    allowClear: true,
    ajax: {
        url: "/search/another-user",
        dataType: 'json',
        delay: 250,
        cache: true,
        processResults: function (data) {
            return {
                results:  $.map(data, function (d) {
                    return {
                        id: d.id,
                        text: d.name + ' (' + d.hp + ')'
                    }
                })
            };
        },
    }
});

function tambahMustahik(data){
    if(data == 'show'){
        $("#tambah-type").prop('disabled', false).prop('required', true);
    }
    else{
        $("#tambah-type").val('').prop('disabled', true).prop('required', false);
    }
}

function checkTambahMustahik(){
    if($("#tambah-mustahik").is(":checked")){
        tambahMustahik("show");
    }
    else{
        tambahMustahik("hide");
    }
}

$('#tambah-mustahik').click(checkTambahMustahik).each(checkTambahMustahik);

$("#tambah-form").keypress(function(e) {
    if(e.which == 13) {
        $('#tambah-form').submit();
        return false;
    }
});

$('#tambah-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/dashboard/muzakki",
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
            }, 500);
        }
    });
});
</script>
<!--end::Javascript-->
