<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <!-- Favicon icon -->
    <title>@yield('content-title') | Baiturrahman</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach(config('layout.resources.css') as $style)
        <link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
    @endforeach

    @laravelPWA
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading">
    <div class="se-pre-con"></div>

    <!--begin::Main-->

    @include('Layout.Base._header-mobile')

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                @include('Layout.Base._header')

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @yield('content-body')
                </div>
                <!--end::Content-->

                @include('Layout.Base._footer')

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    @include('Layout.Partial._user-panel')

    @include('Layout.Partial._scroll-top')

    {{-- Global Config (global config for global JS scripts) --}}
    <script>
        var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
    </script>

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#dtable').on('error.dt', function(e, settings, techNote, message) {
                alert("Datatable system error.");
                console.log( 'An error has been reported by DataTables: ', message);
            });

            // Hide Tooltip after clicked in 500 milliseconds
            $(document).on('click', '[data-toggle="tooltip"]', function(){
                setTimeout(() => {
                    $(this).tooltip('hide');
                }, 500);
            });
        });
    </script>

    @yield('content-modal')

    @include('Layout.Partial._modal')

    @include('Layout.Partial._message')

    @include('Layout.Base._pre-loading')

    @yield('content-js')
</body>

</html>
