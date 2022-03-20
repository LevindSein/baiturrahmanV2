<!--begin::Modal-->
<div class="modal fade" id="detail-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian @include('Dashboard.Muzakki.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" style="height: 45vh;">
                <small class="text-muted pt-4 db">Nama</small>
                <h6 id="showNama"></h6>
                <small class="text-muted pt-4 db">Nomor HP</small>
                <h6 id="showHp"></h6>
                <small class="text-muted pt-4 db">Status</small>
                <h6 id="showStatus"></h6>
                <small class="text-muted pt-4 db">Alamat</small>
                <h6 id="showAlamat"></h6>
                <small class="text-muted pt-4 db">Keanggotaan</small>
                <h6 id="showKeanggotaan"></h6>
                <div id="showKeluarga"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
var id;

$(document).on('click', '.detail', function(e){
    e.preventDefault();
    id = $(this).attr("id");
    $("#showKeanggotaan").html("");
    var family = "";
    var families = "";

    $.ajax({
        url: "/production/dashboard/muzakki/" + id,
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
                $("#showNama").text(data.success.name);
                $("#showHp").text(data.success.hp);
                $("#showStatus").html((data.success.stt_muzakki == 1) ? "<span class='text-success'>Aktif</span>" : "<span class='text-danger'>Nonaktif</span>" );
                $("#showAlamat").text(data.success.address);

                if(data.success.family){
                    family += "Anggota Keluarga dari <span class='text-primary'>" + data.success.memberOf.name + "</span>";
                } else {
                    family += "Kepala Keluarga";
                }
                $("#showKeanggotaan").html(family);

                if(data.success.families){
                    var i = 1;
                    families += '<small class="text-muted pt-4 db">Keluarga</small>';
                    $.each(data.success.families, function( key, value ){
                        families += '<h6>' + i + '. ' + value.name + '</h6>';
                        i++;
                    })
                }
                $("#showKeluarga").html(families);
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
                $("#detail-modal").modal("show");
            }
            else{
                toastr.error("Gagal mengambil data.");
            }
            setTimeout(() => {
                $.unblockUI();
            }, 500);
        }
    });
});
</script>
<!--end::Javascript-->
