<!DOCTYPE html>
<html>

<head>
	<title>Login | Baiturrahman</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Core --}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/welcome.css')}}">

    {{-- Font Awesome --}}
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>

    {{-- Toastr --}}
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/toastr/toastr.min.css')}}">

    @laravelPWA
</head>

<body>
	<div class="container">
		<div class="img">
			<img src="{{asset('img/ramadan.png')}}">
		</div>
		<div class="login-content">
			<form id="formAction">
				<img src="{{asset('img/avatar.svg')}}">
				<h2 class="droid-arabic-kufi" style="color: #193741">اهلاوسهلا</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
                        <input required type="text" maxlength="100" id="username" name="username" class="input" style="text-transform:lowercase;"/>
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
                        <input required type="password" minlength="6" id="password" name="password" class="input"/>
					</div>
				</div>
				<div style="padding-bottom: 1.75rem;"></div>
				<button type="submit" class="btn">Masuk</button>
			</form>
		</div>
	</div>

    {{-- Core --}}
	<script type="text/javascript" src="{{asset('js/welcome.js')}}"></script>

    {{-- jQuery --}}
    <script type="text/javascript" src="{{asset('js/jQuery.min.js')}}"></script>

    {{-- Toastr --}}
    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>

    {{-- BlockUI --}}
    <script src="{{asset('vendor/block-ui/jquery.blockUI.js')}}"></script>

    {{-- Custom --}}
    <script>
    $(document).ready(function(){
        $("#username").focus();
    });

    $("#username").on('input', function() {
        this.value = this.value.replace(/\s/g,'');
    });

    $('#formAction').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/login',
            cache: false,
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend:function(){
                $.blockUI({
                    message: '<i class="fas fa-spin fa-spinner"></i>',
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
                    location.href = "/login";
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
                $("#formAction")[0].reset();
                $("#username").focus();
                $.unblockUI();
            }
        });
    });
    </script>

    @include('Message.toastr')
</body>

</html>
