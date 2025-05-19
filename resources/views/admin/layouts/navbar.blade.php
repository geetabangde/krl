@if(request()->query('appview') == 'true')
<style>
    #page-topbar {
        display: none !important;
    }
    body {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    .page-content{
    padding: 0 !important;
    padding-top: 10px !important;
    }
</style>
@endif

    <header id="page-topbar">
        <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO and Toggle Button -->
                        @if(request()->get('appview') !== 'true')
                            <div class="navbar-brand-box">
                                <a href="#" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="{{ asset('backend/images/logo.png') }}" alt="" height="24">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('backend/images/logo.png') }}" alt="" height="24">
                                        <span class="logo-txt">KRL</span>
                                    </span>
                                </a>
                            </div>
            
                            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>
                        @endif
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="search" class="icon-lg"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
        
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if(auth('admin')->check())
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               
                                <img class="rounded-circle header-profile-user" src="{{ asset('backend//images/users/avatar-1.jpg') }}" alt="Header Avatar">
                                <span class="d-xl-inline-block ms-1 fw-medium">
                                    {{ auth('admin')->user()->name }}
                                </span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                    <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
      </header>
<!-- Bootstrap Bundle includes Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
