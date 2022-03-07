<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">Profil</h3>
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
                <div class="symbol-label" style="background-image:url('{{asset('metronic/assets/media/users/300_21.png')}}')"></div>
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
            <a href="javascript:void(0)" class="navi-item text-hover-primary" id="profil-setting" user-id="{{Crypt::encrypt(Auth::user()->id)}}">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <span class="svg-icon svg-icon-md">
                                <i class="fad fa-user-cog"></i>
                            </span>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">Pengaturan</div>
                        <div class="text-muted">Username, Nama, dan Password.</div>
                    </div>
                </div>
            </a>
            <!--end:Item-->
    </div>
    <!--end::Content-->
</div>
<!-- end::User Panel-->
