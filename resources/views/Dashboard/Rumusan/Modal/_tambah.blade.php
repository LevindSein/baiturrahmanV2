<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="tambah-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Satuan <span class="text-danger">*</span></label>
                        <input required type="text" id="tambah-satuan" name="tambah_satuan" autocomplete="off" maxlength="100" class="form-control" placeholder="Liter / Kilogram / Lainnya . ." />
                    </div>
                    <div class="form-group">
                        <label>Nama Alternatif <span class="text-danger">*</span></label>
                        <input required type="text" id="tambah-alternatif" name="tambah_alternatif" autocomplete="off" maxlength="100" class="form-control" placeholder="Ltr / Kg / Lainnya . ." />
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
$("#add").click(function(){
    $("#tambah-modal").modal("show");

    $('#tambah-modal').on('shown.bs.modal', function() {
        $("#tambah-satuan").focus();
    });
})

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
        url: "/production/dashboard/rumusan",
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
<!--end::Javascript-->
