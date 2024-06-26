<nav class="pcoded-navbar" navbar-theme="themelight1">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            @if(request()->segment(1) == 'clinician')
                <li class="{{ (request()->route()->getName() == 'clinician-dashbord') ? 'active' : ''}}">
                    <a href="{{ route('clinician-dashbord') }}">
                        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i><b></b></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="{{ (request()->route()->getName() == 'clinician-slot') ? 'active' : ''}}">
                    <a href="{{ route('clinician-slot') }}">
                        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i><b></b></span>
                        <span class="pcoded-mtext">Slot</span>
                    </a>
                </li>
                <li class="{{ (request()->route()->getName() == 'clinician-appointment') ? 'active' : ''}}">
                    <a href="{{ route('clinician-appointment') }}">
                        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i><b></b></span>
                        <span class="pcoded-mtext">Appointment</span>
                    </a>
                </li>
            @else
                <li class="{{ (request()->route()->getName() == 'slots') ? 'active' : ''}}">
                    <a href="{{ route('slots') }}">
                        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i><b></b></span>
                        <span class="pcoded-mtext">Slots</span>
                    </a>
                </li>
                <li class="{{ (request()->route()->getName() == 'user-appointment') ? 'active' : ''}}">
                    <a href="{{ route('user-appointment') }}">
                        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i><b></b></span>
                        <span class="pcoded-mtext">Appointment</span>
                    </a>
                </li>
            @endif
            
        </ul>
    </div>
</nav>
