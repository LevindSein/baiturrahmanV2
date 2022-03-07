<!--
Modal ada di Layout.Modal._hapus
-->

<!--begin::Javascript-->
<script>
var id;

$(".hapus-rumus").click(function(e){
    e.preventDefault();
    id = $(this).attr("rumus-id");

    $("#hapus-modal").modal("show");
})

$('#hapus-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/dashboard/" + id,
        cache: false,
        method: "DELETE",
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
            $.unblockUI();
            if(JSON.parse(data.responseText).success){
                $('#hapus-modal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }
    });
});
</script>
<!--end::Javascript-->
