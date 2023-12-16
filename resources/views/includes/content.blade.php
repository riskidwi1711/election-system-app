<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    @include('includes.sidebar')
    <!--  Main wrapper -->
    <div class="body-wrapper">
        @include('includes.header')
        <div class="container-fluid">
            @yield('pages')
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <div class="dark-transparent sidebartoggler"></div>
</div>