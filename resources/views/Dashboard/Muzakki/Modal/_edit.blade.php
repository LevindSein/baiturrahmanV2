<!--begin::Modal-->
<div class="modal fade" id="edit-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit @include('Dashboard.Muzakki.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="edit-form">
                <div class="modal-body" style="height: 45vh;">
                    <div class="form-group">
                        <label>Nama Muzakki <span class="text-danger">*</span></label>
                        <input required type="text" id="edit-name" name="edit_name" autocomplete="off" maxlength="100" class="form-control" placeholder="Masukkan Nama Muzakki" />
                    </div>
                    <div class="form-group">
                        <label>Nomor HP <span class="text-danger">*</span></label>
                        <input required type="tel" id="edit-hp" name="edit_hp" autocomplete="off" minlength="11" maxlength="15" placeholder="08xx-xxxx-xxxxx" class="phone form-control" />
                    </div>
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea required rows="5" id="edit-address" name="edit_address" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control"></textarea>
                    </div>
                    <div class="form-group" id="edit-pilih">
                        <label>Pilih Kepala Keluarga</label>
                        <select class="form-control" id="edit-family" name="edit_family" style="width:100%"></select>
                        <span class="form-text text-muted">Pilih Kepala Keluarga jika Muzakki ditanggung</span>
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
function edit_init(){
    $("#edit-name").val('');
    $("#edit-hp").val('');
    $("#edit-address").val('');
    $("#edit-family").val('').html('');
}

var id;

$(document).on('click', '.edit', function(e){
    e.preventDefault();
    id = $(this).attr("id");
    edit_init();

    $('#edit-family').select2({
        placeholder: "Cari Nama Kepala Keluarga",
        allowClear: true,
        ajax: {
            url: "/search/another-user/" + id,
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

    $.ajax({
        url: "/production/dashboard/muzakki/" + id + "/edit",
        cache: false,
        method: "GET",
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
                $("#edit-name").val(data.success.name);
                $("#edit-hp").val(data.success.hp);
                $("#edit-address").val(data.success.address);

                if(data.success.family){
                    var family = new Option(data.success.memberOf.name + ' (' + data.success.memberOf.hp + ')', data.success.memberOf.id, false, false);
                    $('#edit-family').append(family).trigger('change');
                }
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
            toastr.error("System error.");
            console.log(data);
        },
        complete:function(data){
            if(JSON.parse(data.responseText).success){
                $("#edit-modal").modal("show");
            }
            else{
                toastr.error("Gagal mengambil data.");
            }
            $.unblockUI();
        }
    });

    $('#edit-modal').on('shown.bs.modal', function() {
        $("#edit-name").focus();
    });
});

$("#edit-name").on('input change', function() {
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

// phone number format
$("#edit-hp").inputmask("mask", {
    "mask": "9999-9999-99999"
});

$("#edit-form").keypress(function(e) {
    if(e.which == 13) {
        $('#edit-form').submit();
        return false;
    }
});

$('#edit-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/dashboard/muzakki/" + id,
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
                $('#edit-modal').modal('hide');
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
