<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/" class="text-nowrap logo-img d-flex gap-2 justify-content-center align-items-end">
                <img src="{{asset('dashboard_assets/dist/images/logo/election.png')}}" class="dark-logo" width="30"
                    alt="" />
                <img src="{{asset('dashboard_assets/dist/images/logo/election.png')}}" class="light-logo" width="30"
                    alt="" />
                <h3 id="app-name" class="m-0 fw-bolder">Voting App</h3>
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8 text-muted"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                @foreach (config('sidebar') as $menu_group => $menus)
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">{{$menu_group}}</span>
                </li>
                @foreach ($menus as $menu)
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route($menu['url'])}}" aria-expanded="false">
                        <span>
                            <i class="{{$menu['icon']}}"></i>
                        </span>
                        <span class="hide-menu">{{$menu['title']}}</span>
                    </a>
                </li>
                @endforeach
                @endforeach
            </ul>
            <div class="unlimited-access hide-menu bg-light-primary position-relative my-7 rounded">
                <div class="d-flex">
                    <div class="unlimited-access-title">
                        <h6 class="fw-semibold mb-6 text-dark w-85">Aplikasi preview</h6>
                        <button class="w-100 btn btn-primary fs-2 fw-semibold lh-sm"><i class="fab fa-whatsapp me-1"></i> Cavemen Team</button>
                    </div>
                </div>
            </div>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->