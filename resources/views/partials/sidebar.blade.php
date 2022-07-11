<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/dashboard" style="color: #6777ef">Gestion </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/dashboard">

                <center> <img class="mx-auto" id="logo" width="50" src="{{ asset('assets/img/logo_resto.png') }}" alt="logo">
                </center>

            </a>
        </div>
        <ul class="sidebar-menu">
            {{-- <li class="menu-header">Dashboard</li> --}}

            @if (Auth::check())
                @if (Auth::user()->role == 'vehicule' || Auth::user()->role == 'appartement' || Auth::user()->role === 'admin')
                    <li style="" class="{{ request()->routeIs('dashboard') ? 'nav-link active' : 'nav-link' }}">
                        <a href="/dashboard" class="nav-link"><span> Dashboard</span></a>
                    </li>
                @endif
                @if (Auth::user()->role == 'admin')
                    <li class="{{ request()->routeIs('agent_dash') || request()->routeIs('agent_activites_dash') ? 'dropdown active' : 'dropdown' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Agents</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="/agent-dash">Gestion des agents</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->role == 'appartement' || Auth::user()->role === 'admin')
                    <li class="{{ request()->routeIs('appart_dash') || request()->routeIs('appart_activites_dash') || request()->routeIs('recapIndexAppart') ? 'dropdown active' : 'dropdown' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-home"></i><span>Appartements</span></a>
                        <ul class="dropdown-menu">
                            {{-- <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Appartements</span></a> --}}
                            <li><a class="nav-link" href="/appart-dash">Gestion des appartements</a></li>
                            <li><a class="nav-link" href="/appart-historic-dash">Historique</a></li>
                            <li><a class="nav-link" href="/appart-recap">Recapitulatif</a></li>

                        </ul>
                    </li>
                @endif
                @if (Auth::user()->role == 'vehicule' || Auth::user()->role === 'admin')
                    <li class="{{ request()->routeIs('vehicle_dash') || request()->routeIs('vehicle_activites_dash') || request()->routeIs('recapIndex') ? 'dropdown active' : 'dropdown' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-car"></i><span>Vehicules</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="/vehicle-dash">Gestion des Vehicules</a></li>
                            <li><a class="nav-link" href="/vehicle-historic-dash">Historique</a></li>
                            <li><a class="nav-link" href="/vehicle-recap">Recapitulatif</a></li>
                        </ul>
                    </li>
                @endif

            @endif
    </aside>
</div>
