<!--begin::Modal-->
<div class="modal fade" id="profil-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="profil-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="profil-form">
                <div class="modal-body" style="height: 45vh;">
                    <div class="form-group">
                        <label>Username (untuk Login)<span class="text-danger">*</span></label>
                        <input required type="text" id="profil-username" name="profil_username" autocomplete="off" maxlength="100" class="form-control" placeholder="Masukkan Username untuk Login" style="text-transform: lowercase;" />
                    </div>
                    <div class="form-group">
                        <label>Nama Pengguna <span class="text-danger">*</span></label>
                        <input required type="text" id="profil-name" name="profil_name" autocomplete="off" maxlength="100" class="form-control" placeholder="Masukkan Nama Anda" />
                    </div>
                    <div class="form-group">
                        <label>Nomor HP <span class="text-danger">*</span></label>
                        <input required type="text" id="profil-hp" name="profil_hp" autocomplete="off" minlength="11" maxlength="15" placeholder="08xx-xxxx-xxxxx" class="phone form-control" />
                    </div>
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea required rows="5" id="profil-address" name="profil_address" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Password Sekarang <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input required type="password" id="profil-password-now" name="profil_password_now" minlength="6" class="form-control" placeholder="Masukkan Password untuk Konfirmasi Perubahan" />
                            <div class="input-group-append">
                                <button id="profil-password-now-show" class="btn btn-secondary" tabindex="-1"><i class="fas fa-eye-slash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <div class="input-group">
                            <input type="password" id="profil-password-new" name="profil_password_new" minlength="6" class="form-control" placeholder="Masukkan Password untuk Ganti Password" />
                            <div class="input-group-append">
                                <button id="profil-password-new-show" class="btn btn-secondary" tabindex="-1"><i class="fas fa-eye-slash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><sup><span class="text-danger">*) Wajib diisi.</span></sup></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                    <input type="hidden" id="user-id-hidden" value="{{Crypt::encrypt(Auth::user()->id)}}"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
$("#profil-setting").click(function(){
    $.ajax({
        url: "/production/profile/" + $(this).attr('user-id') + "/edit",
        type: "GET",
        cache:false,
        success:function(data){
            if(data.success){
                $("#profil-username").val(data.success.username);
                $("#profil-name").val(data.success.name);
                $("#profil-hp").val(data.success.hp);
                $("#profil-address").val(data.success.address);
            }

            if(data.error){
                toastr.error(data.error);
            }

            if(data.warning){
                toastr.warning(data.warning);
            }

            if(data.info){
                toastr.info(data.info);
            }

            if(data.debug){
                console.log(data.debug);
            }
        },
        error:function(data){
            toastr.error("Fetching data failed.");
            console.log(data);
        },
        complete:function(){
            $("#profil-modal").modal('show');
            $('#profil-modal').on('shown.bs.modal', function() {
                $("#profil-username").focus();
            });
        },
    });
});

$("#profil-username").on('input', function() {
    this.value = this.value.replace(/[^0-9a-zA-Z]+$/g, '');
});

$("#profil-name").on('input', function() {
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
$("#profil-hp").inputmask("mask", {
    "mask": "9999-9999-99999"
});

$('#profil-password-new-show').on('click touchstart', function(e){
    e.preventDefault();
    if($('#profil-password-new').attr('type') == 'password'){
        $('#profil-password-new').prop('type', 'text');
        $('#profil-password-new-show').html('<i class="fas fa-eye"></i>');
    }else{
        $('#profil-password-new').prop('type', 'password');
        $('#profil-password-new-show').html('<i class="fas fa-eye-slash"></i>');
    }
});

$('#profil-password-now-show').on('click touchstart', function(e){
    e.preventDefault();
    if($('#profil-password-now').attr('type') == 'password'){
        $('#profil-password-now').prop('type', 'text');
        $('#profil-password-now-show').html('<i class="fas fa-eye"></i>');
    }else{
        $('#profil-password-now').prop('type', 'password');
        $('#profil-password-now-show').html('<i class="fas fa-eye-slash"></i>');
    }
});

$("#profil-form").keypress(function(e) {
    if(e.which == 13) {
        $('#profil-form').submit();
        return false;
    }
});

$('#profil-form').on('submit', function(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/production/profile/" + $('#user-id-hidden').val(),
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
                }, 750);
            }
            setTimeout(() => {
                $.unblockUI();
            }, 750);
        }
    });
});
</script>
<!--end::Javascript-->
