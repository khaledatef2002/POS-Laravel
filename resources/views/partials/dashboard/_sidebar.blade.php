<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/dashboard') }}/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/dashboard') }}/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/dashboard') }}/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/dashboard') }}/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                {{-- <li class="menu-title"><span>Menu</span></li> --}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.index') ? 'active': '' }}" href="{{ route('dashboard.index') }}" role="button">
                        <i class="ri-home-4-fill"></i> <span>@lang('site.home')</span>
                    </a>
                </li>

                @if (auth()->user()->hasPermission('read-category'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.categories') ? 'active': '' }}" href="{{ route('dashboard.categories.index') }}" role="button">
                            <i class="ri-list-indefinite"></i> <span>@lang('site.categories')</span>
                        </a>
                    </li>
                @endif
                
                @if (auth()->user()->hasPermission('read-product'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.products') ? 'active': '' }}" href="{{ route('dashboard.products.index') }}" role="button">
                            <i class="ri-luggage-cart-line"></i> <span>@lang('site.products')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('read-user'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.users') ? 'active': '' }}" href="{{ route('dashboard.users.index') }}" role="button">
                            <i class="ri-account-circle-line"></i> <span>@lang('site.users')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('read-client'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.clients') ? 'active': '' }}" href="{{ route('dashboard.clients.index') }}" role="button">
                            <i class="ri-team-line"></i> <span>@lang('site.clients')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('read-order'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.orders') ? 'active': '' }}" href="{{ route('dashboard.orders.index') }}" role="button">
                            <i class="ri-team-line"></i> <span>@lang('site.orders')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasPermission('read-role'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with(request()->route()->getName(), 'dashboard.roles') ? 'active': '' }}" href="{{ route('dashboard.roles.index') }}" role="button">
                            <i class="ri-bank-card-line"></i> <span>@lang('site.roles')</span>
                        </a>
                    </li>
                @endif
                <!-- end Dashboard Menu -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>