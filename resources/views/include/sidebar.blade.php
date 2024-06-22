<nav class="pcoded-navbar" navbar-theme="themelight1">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ (request()->route()->getName() == 'clinician-dashbord') ? 'active' : ''}}">
                <a href="{{ route('clinician-dashbord') }}">
                    <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i><b></b></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
