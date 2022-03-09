<!--begin::Modal-->
<div class="modal fade" id="nonaktif-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="nonaktif-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="nonaktif-form">
                <div class="modal-body">
                    <p>
                        Tekan tombol <span class="text-danger">Nonaktif</span>, jika anda yakin untuk menonaktifkan pengguna.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold">Nonaktif</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
var id;

$(document).on('click', '.nonaktif', function(e){
    e.preventDefault();
    id = $(this).attr("id");

    $("#nonaktif-modal").modal("show");
    $(".title").text("Nonaktif : " + $(this).attr("nama"));
})

$('#nonaktif-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/users/aktif/nonaktif/" + id,
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
            toastr.error("System error.");
            console.log(data);
        },
        complete:function(data){
            if(JSON.parse(data.responseText).success){
                $('#nonaktif-modal').modal('hide');
                dtableReload();
            }
            setTimeout(() => {
                $.unblockUI();
            }, 1000);
        }
    });
});
</script>
<!--end::Javascript-->
