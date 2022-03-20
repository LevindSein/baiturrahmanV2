
<!--begin::Subheader-->
<div class="subheader py-4 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h1 class="font-weight-bold my-1 mr-5 {{ ($status == 1) ? 'text-dark' : 'text-danger' }}">@include('Users.Partial._title')</h1>
                <!--end::Page Title-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            @if($status == 1)
            <!--begin::Actions-->
            <a href="javascript:void(0)" id="add" class="btn btn-light-success font-weight-bolder btn-sm"><i class="fas fa-plus fa-sm"></i>@include('Users.Partial._title')</a>
            <!--end::Actions-->
            @endif
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->
