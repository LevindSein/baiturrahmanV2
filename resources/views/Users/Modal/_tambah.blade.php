<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah @include('Users.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="tambah-form">
                <div class="modal-body" style="height: 45vh;">
                    <div class="form-group">
                        <label>Nama Pengguna <span class="text-danger">*</span></label>
                        <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="100" class="form-control" placeholder="Masukkan Nama Pengguna" />
                    </div>
                    <div class="form-group">
                        <label>Username (untuk Login) <span class="text-danger">*</span></label>
                        <input required type="text" id="tambah-username" name="tambah_username" autocomplete="off" maxlength="100" class="form-control" placeholder="Masukkan Nama Pengguna" style="text-transform: lowercase;"/>
                    </div>
                    <div class="form-group">
                        <label>Nomor HP <span class="text-danger">*</span></label>
                        <input required type="text" id="tambah-hp" name="tambah_hp" autocomplete="off" minlength="11" maxlength="15" placeholder="08xx-xxxx-xxxxx" class="phone form-control" />
                    </div>
                    <div class="form-group">
                        <label>Level Pengguna <span class="text-danger">*</span></label>
                        <select required class="form-control" id="tambah-level" name="tambah_level">
                            <option value="2">Admin</option>
                            <option value="1">Super Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea required rows="5" id="tambah-address" name="tambah_address" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control"></textarea>
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
var status = JSON.parse("{{ $status }}");

function tambah_init(){
    $("#tambah-name").val('');
    $("#tambah-username").prop("disabled", true).val('');
    $("#tambah-hp").val('');
    $("#tambah-address").val('');
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

    if($("#tambah-name").val() == ''){
        $("#tambah-username").prop("disabled", true).val('');
    }
    else{
        $("#tambah-username").prop("disabled", false);
        var str = $("#tambah-name").val().replace(/\s/g, '').toLowerCase().substring(0,10);
        $("#tambah-username").val(str);
    }
});

$('.phone').on('input change', function(e) {
    $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
});

$('.phone').on('keypress', function(e) {
    keys = ['0','1','2','3','4','5','6','7','8','9']
    return keys.indexOf(e.key) > -1
});

// phone number format
$("#tambah-hp").inputmask("mask", {
    "mask": "9999-9999-99999"
});

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
        url: "/production/users/" + status + "/aktif",
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
