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
                        <a href="javascript:void(0)" class="nav-link py-4 px-6 {{ (request()->is('production/dashboard*')) ? 'active' : '' }}" data-toggle="tab" data-target="#kt_header_tab_1" role="tab">Beranda</a>
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
                    @if(Auth::user()->level == 1)
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link py-4 px-6 {{ (request()->is('production/users*')) ? 'active' : '' }}" data-toggle="tab" data-target="#kt_header_tab_5" role="tab">Pengguna</a>
                    </li>
                    @endif
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
                        <a href="javascript:void(0)" class="nav-link btn btn-clean {{ (request()->is('production/dashboard*')) ? 'active' : '' }}" data-toggle="tab" data-target="#kt_header_tab_1" role="tab">Beranda</a>
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
                        <a href="javascript:void(0)" class="nav-link btn btn-clean {{ (request()->is('production/users*')) ? 'active' : '' }}" data-toggle="tab" data-target="#kt_header_tab_5" role="tab">Pengguna</a>
                    </li>
                    <!--end::Item-->
                </ul>
                <!--begin::Tab Navs-->
                <!--begin::Tab Content-->
                <div class="tab-content">
                    <!--begin::Tab Pane-->
                    <div class="tab-pane py-5 p-lg-0 {{ (request()->is('production/dashboard*')) ? 'show active' : '' }}" id="kt_header_tab_1">
                        <!--begin::Menu-->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Nav-->
                            <ul class="menu-nav">
                                @if(Auth::user()->level == 1)
                                <li class="menu-item {{ (request()->is('production/dashboard/rumusan*')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                    <a href="{{url('production/dashboard/rumusan')}}" class="menu-link">
                                        <span class="menu-text">Rumusan</span>
                                    </a>
                                </li>
                                @endif
                                <li class="menu-item {{ (request()->is('production/dashboard/muzakki*')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                    <a href="{{url('production/dashboard/muzakki')}}" class="menu-link">
                                        <span class="menu-text">Muzakki</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ (request()->is('production/dashboard/mustahik*')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                    <a href="{{url('production/dashboard/mustahik')}}" class="menu-link">
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
                    @if(Auth::user()->level == 1)
                    <div class="tab-pane p-5 p-lg-0 justify-content-between {{ (request()->is('production/users*')) ? 'show active' : '' }}" id="kt_header_tab_5">
                        <!--begin::Menu-->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Nav-->
                            <ul class="menu-nav">
                                <li class="menu-item {{ (request()->is('production/users/1/aktif')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                    <a href="{{url('production/users/1/aktif')}}" class="menu-link">
                                        <span class="menu-text">Aktif</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ (request()->is('production/users/0/aktif')) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                    <a href="{{url('production/users/0/aktif')}}" class="menu-link">
                                        <span class="menu-text">Nonaktif</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Nav-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    @endif
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
