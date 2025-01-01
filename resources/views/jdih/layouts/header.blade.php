<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content container d-lg-flex">
        <div class="d-flex">
            <div class="d-flex flex-column flex-md-row flex-sm-row align-items-center">
                <a href="{{ $jdihnUrl }}" class="me-3" style="align-self: center;">
                    <img src="{{ $jdihnLogo }}" alt="{{ $jdihnTitle }}" width="64">
                </a>

                <a href="{{ $appUrl }}" class="me-3" style="align-self: center;">
                    <img class="rounded" src="{{ $appLogoUrl }}" alt="{{ $appName }}" width="64">
                </a>
            </div>

            <h1 class="page-title mb-0">
                <a href="{{ $appUrl }}" class="text-dark">
                    <span class="fw-bold">{!! $appName !!}</span>
                    <small class="d-block fs-base fs-sm text-muted">{!! $appDesc !!}</small>
                </a>
            </h1>

            <!--<a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse" data-color-theme="dark">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>-->
        </div>

        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="ph_text_input_right_icon">
            <form action="#" class="mb-3 mb-lg-0">
                <div class="form-control-feedback form-control-feedback-end">
                    <input type="text" class="form-control wmin-lg-200" data-bs-toggle="modal" data-bs-target="#search-modal" placeholder="Cari">
                    <div class="form-control-feedback-icon">
                        <i class="ph-magnifying-glass"></i>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /page header -->
