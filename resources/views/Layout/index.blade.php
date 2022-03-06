<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    @include('Layout.header')

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
        <!--begin::Logo-->
        <a href="javascript:void(0)">
            <img alt="Logo" src="{{asset('metronic/assets/media/logos/logo-letter-9.png')}}" class="max-h-30px" />
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <button class="btn p-0 mr-3 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <i class="fad fa-user"></i>
                </span>
            </button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header flex-column header-fixed">
                    <!--begin::Top-->
                    <div class="header-top">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Left-->
                            <div class="d-none d-lg-flex align-items-center mr-3">
                                <!--begin::Logo-->
                                <a href="javascript:void(0)" class="mr-20">
                                    <img alt="Logo" src="{{asset('metronic/assets/media/logos/logo-letter-9.png')}}" class="max-h-35px" />
                                </a>
                                <!--end::Logo-->
                                <!--begin::Tab Navs(for desktop mode)-->
                                <ul class="header-tabs nav align-self-end font-size-lg" role="tablist">
                                    <!--begin::Item-->
                                    <li class="nav-item">
                                        <a href="javascript:void(0)" class="nav-link py-4 px-6 active" data-toggle="tab" data-target="#kt_header_tab_1" role="tab">Beranda</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a href="javascript:void(0)" class="nav-link py-4 px-6" data-toggle="tab" data-target="#kt_header_tab_2" role="tab">Transaksi</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a href="javascript:void(0)" class="nav-link py-4 px-6" data-toggle="tab" data-target="#kt_header_tab_3" role="tab">Distribusi</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a href="javascript:void(0)" class="nav-link py-4 px-6" data-toggle="tab" data-target="#kt_header_tab_4" role="tab">Pembukuan</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item">
                                        <a href="javascript:void(0)" class="nav-link py-4 px-6" data-toggle="tab" data-target="#kt_header_tab_5" role="tab">Pengguna</a>
                                    </li>
                                    <!--end::Item-->
                                </ul>
                                <!--begin::Tab Navs-->
                            </div>
                            <!--end::Left-->
                            <!--begin::Topbar-->
                            <div class="topbar bg-primary">
                                <!--begin::User-->
                                <div class="topbar-item">
                                    <div class="btn btn-icon btn-hover-transparent-white w-sm-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                        <div class="d-flex flex-column text-right pr-sm-3">
                                            <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-sm-inline">{{Auth::user()->level == 1 ? 'Super Admin' : 'Amil Zakat'}}</span>
                                            <span class="text-white font-weight-bolder font-size-sm d-none d-sm-inline">{{substr(Auth::user()->name, 0, 15)}}</span>
                                        </div>
                                        <span class="symbol symbol-35">
                                            <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30">{{strtoupper(substr(Auth::user()->name, 0, 1))}}</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Top-->
                    <!--begin::Bottom-->
                    <div class="header-bottom">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Header Menu Wrapper-->
                            <div class="header-navs header-navs-left" id="kt_header_navs">
                                <!--begin::Tab Navs(for tablet and mobile modes)-->
                                <ul class="header-tabs p-5 p-lg-0 d-flex d-lg-none nav nav-bold nav-tabs" role="tablist">
                                    <!--begin::Item-->
                                    <li class="nav-item mr-2">
                                        <a href="javascript:void(0)" class="nav-link btn btn-clean active" data-toggle="tab" data-target="#kt_header_tab_1" role="tab">Beranda</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-2">
                                        <a href="javascript:void(0)" class="nav-link btn btn-clean" data-toggle="tab" data-target="#kt_header_tab_2" role="tab">Transaksi</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-2">
                                        <a href="javascript:void(0)" class="nav-link btn btn-clean" data-toggle="tab" data-target="#kt_header_tab_3" role="tab">Distribusi</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-2">
                                        <a href="javascript:void(0)" class="nav-link btn btn-clean" data-toggle="tab" data-target="#kt_header_tab_4" role="tab">Pembukuan</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item">
                                        <a href="javascript:void(0)" class="nav-link btn btn-clean" data-toggle="tab" data-target="#kt_header_tab_5" role="tab">Pengguna</a>
                                    </li>
                                    <!--end::Item-->
                                </ul>
                                <!--begin::Tab Navs-->
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <!--begin::Tab Pane-->
                                    <div class="tab-pane py-5 p-lg-0 show active" id="kt_header_tab_1">
                                        <!--begin::Menu-->
                                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                            <!--begin::Nav-->
                                            <ul class="menu-nav">
                                                <li class="menu-item menu-item-active" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Rumusan</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Muzakki</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Mustahik</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Tab Pane-->
                                    <!--begin::Tab Pane-->
                                    <div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_2">
                                        <!--begin::Menu-->
                                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                            <!--begin::Nav-->
                                            <ul class="menu-nav">
                                                <li class="menu-item menu-item-active" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Zakat Fitrah</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Zakat Maal</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Infaq</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Tab Pane-->
                                    <!--begin::Tab Pane-->
                                    <div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_3">
                                        <!--begin::Menu-->
                                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                            <!--begin::Nav-->
                                            <ul class="menu-nav">
                                                <li class="menu-item menu-item-active" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Diproses</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Dikirim</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Terkirim</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Dikembalikan</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Tab Pane-->
                                    <!--begin::Tab Pane-->
                                    <div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_4">
                                        <!--begin::Menu-->
                                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                            <!--begin::Nav-->
                                            <ul class="menu-nav">
                                                <li class="menu-item menu-item-active" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Harian</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Bulanan</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Tahunan</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Tab Pane-->
                                    <!--begin::Tab Pane-->
                                    <div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_5">
                                        <!--begin::Menu-->
                                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                                            <!--begin::Nav-->
                                            <ul class="menu-nav">
                                                <li class="menu-item menu-item-active" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Aktif</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item" aria-haspopup="true">
                                                    <a href="javascript:void(0)" class="menu-link">
                                                        <span class="menu-text">Nonaktif</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Tab Pane-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end::Header Menu Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Bottom-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            @yield('content-body')
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">2022©</span>
                            <span class="text-dark-75 text-hover-primary">Masjid Baiturrahman</span>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Nav-->
                        <div class="nav nav-dark order-1 order-md-2">
                            <a href="javascript:void(0)" target="_blank" class="nav-link pr-3 pl-0">Developer</a>
                            <a href="javascript:void(0)" target="_blank" class="nav-link px-3">DKM Baiturrahman</a>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
    <!-- begin::User Panel-->
    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">User Profile</h3>
            <a href="javascript:void(0)" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <!--begin::Header-->
            <div class="d-flex align-items-center mt-5">
                <div class="symbol symbol-100 mr-5">
                    <div class="symbol-label" style="background-image:url('{{asset('metronic/assets/media/users/300_21.jpg')}}')"></div>
                    <i class="symbol-badge bg-success"></i>
                </div>
                <div class="d-flex flex-column">
                    <span class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{substr(Auth::user()->name, 0, 15)}}</span>
                    <div class="text-muted mt-1">{{Auth::user()->level == 1 ? 'Super Admin' : 'Amil Zakat'}}</div>
                    <div class="navi mt-2">
                        <a href="{{url('logout')}}" class="btn btn-sm btn-light-danger font-weight-bolder py-2 px-5"><i class="fad fa-sign-out-alt"></i> Sign Out</a>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Separator-->
            <div class="separator separator-dashed mt-8 mb-5"></div>
            <!--end::Separator-->
            <!--begin::Nav-->
            <div class="navi navi-spacer-x-0 p-0">
                <!--begin::Item-->
                <a href="javascript:void(0)" class="navi-item text-hover-primary">
                    <div class="navi-link">
                        <div class="symbol symbol-40 bg-light mr-3">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md">
                                    <i class="fad fa-user-cog"></i>
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">Profil</div>
                            <div class="text-muted">Pengaturan akun dan lainnya.</div>
                        </div>
                    </div>
                </a>
                <!--end:Item-->
                <!--begin::Item-->
                <a href="javascript:void(0)" class="navi-item text-hover-primary">
                    <div class="navi-link">
                        <div class="symbol symbol-40 bg-light mr-3">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-danger">
                                    <i class="fad fa-tasks"></i>
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">Aktivitas</div>
                            <div class="text-muted">Catatan aktivitas dan transaksi.</div>
                        </div>
                    </div>
                </a>
                <!--end:Item-->
        </div>
        <!--end::Content-->
    </div>
    <!-- end::User Panel-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <img src="{{asset('metronic/assets/media/svg/icons/Navigation/Up-2.svg')}}" />
        </span>
    </div>
    <!--end::Scrolltop-->

    {{-- Global Config (global config for global JS scripts) --}}
    <script>
        var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
    </script>

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    {{-- <script>
        $(window).on('load', function() {
            $(".se-pre-con").fadeIn("slow").fadeOut("slow");
        });

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
    </script> --}}

    @include('message.toastr')

    @yield('content-js')
</body>

</html>
