<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- SVG logo here -->
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">id-grow</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ url('/') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Barang -->
        <li class="menu-item {{ request()->is('barang*') || request()->is('kategori*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Layouts">Barang</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('barang') ? 'active' : '' }}">
                    <a href="{{ route('barang.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Data Barang</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('kategori') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Kategori</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Lokasi -->
        <li class="menu-item {{ request()->is('lokasi*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-map"></i> 
                <div data-i18n="Layouts">Lokasi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('lokasi') ? 'active' : '' }}">
                    <a href="{{ route('lokasi.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Data Lokasi</div>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Mutasi -->
        <li class="menu-item {{ request()->is('mutasi*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-transfer"></i> 
                <div data-i18n="Layouts">Mutasi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('mutasi') ? 'active' : '' }}">
                    <a href="{{ route('mutasi.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Data Mutasi</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
