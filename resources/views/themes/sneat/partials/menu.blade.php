<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
    <a href="{{route('home')}}" class="app-brand-link">
        <img src="{{config('app.logo')}}" alt="" height="40px">
        <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: capitalize">{{config('app.name')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @include('themes.sneat.partials.sidebar')
</aside>