<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{request()->routeIs('home') ? 'active' : ''}}">
        <a href="{{route('home')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    @foreach (\App\Libraries\Menu::get() as $group => $items)
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ $group }}</span>
    </li>
    @foreach ($items as $item)
    @if(auth()->user()->canAccess($item::getRoute()))
    <li class="menu-item {{request()->routeIs($item::getPageRouteName('*')) ? 'active' : ''}}">
        <a href="{{route($item::getRoute())}}" class="menu-link">
            @if($item::getNavigationIcon())
            <i class="menu-icon tf-icons {{$item::getNavigationIcon() }}"></i>
            @endif
            <div data-i18n="Basic">{{ $item::getNavigationLabel() }}</div>
        </a>
    </li>
    @endif
    @endforeach
    @endforeach
</ul>