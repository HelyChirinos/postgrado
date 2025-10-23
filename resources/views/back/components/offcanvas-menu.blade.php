<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
    <!-- Application (all authenticated users) -->
    <li class="nav-item text-light">Oficina Virtual</li>
    <hr class="narrow text-light">

    <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.divisas.index') }}"><i class="fa-solid fa-dollar-sign fa-fw"></i> Divisas (Dolar BCV)</a></li>

    @can ('Ver Recibos') 
        <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.recibos.index') }}"><i class="fa-solid fa-file-invoice-dollar fa-fw"></i> Recibos</a></li>
    @endcan
    @canany(['Ver Programas','Ver Cohortes']) 
        <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.tablas.index') }}"><i class="fa-solid fa-table-pivot fa-fw"></i> Programas y Menciones</a></li>
    @endcan
    @canany(['Ver Aranceles','Ver Matrículas']) 
        <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.aranceles.index') }}"><i class="fa-light fa-money-check-dollar-pen fa-fw"></i> Aranceles </a></li>
    @endcan
    @canany (['Ver Estudiantes']) 
        <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.estudiantes.index') }}"><i class="fa-light fa-screen-users fa-fw"></i> Estudiantes</a></li>
    @endcan
    @canany (['Ver Bancos']) 
        <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.bancos.index') }}"><i class="fa-light fa-building-columns fa-fw"></i> Bancos</a></li>
    @endcan
    @can ('Ver Reportes') 
        <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.reportes.index') }}"><i class="fa-light fa-print fa-fw"></i> Reportes</a></li>
    @endcan
    <li class="nav-item"><a class="nav-link text-light " href="{{ route('back.videos.index') }}"><i class="fa-light fa-video fa-fw"></i> Videos Tutoriales</a></li>

    <!-- Administration (solo Administradores y SuperAdmin) -->
    @hasanyrole(['Administrador','SuperAdmin'])
        <hr class="narrow text-light">
        <li class="nav-item text-light">Administración</li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                <i class="bi bi-person-bounding-box nav-icon"></i>{{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                <li><a class="dropdown-item" href="{{ route('back.profile.show') }}"><i class="bi bi-person-badge nav-icon"></i>Perfil</a></li>
                @can('superAdmin')
                    <li><a class="dropdown-item" href="{{ route('back.users.index') }}"><i class="bi bi-people-fill nav-icon"></i>Usuarios</a></li>
                    <li><a class="dropdown-item" href="{{ route('back.userslog.index') }}"><i class="bi bi-person-lines-fill nav-icon"></i>Control Ingresos</a></li>
                    <li><a class="dropdown-item" href="{{ route('back.roles.index') }}"><i class="bi bi-person-lines-fill nav-icon"></i>Roles y Permisos</a></li>

                @endcan
                <hr class="narrow">
                <li><a class="dropdown-item" href="{{ route('back.reportes.index') }}"><i class="fa-regular fa-print fa-fw"></i> Reportes</a></li>
                <li><a class="dropdown-item" href="{{route('back.bancos.index')}}"><i class="fa-regular fa-money-bill-1-wave fa-fw"></i> Conciliación Bancaria</a></li>
                <li><a class="dropdown-item" href="{{ route('back.videos.index') }}"><i class="fa-regular fa-video fa-fw"></i> Videos</a></li>

                <hr class="narrow">

                <li><a class="dropdown-item" href="{{ route('back.backups.index') }}"><i class="bi bi-archive-fill nav-icon"></i>Backups</a></li>
                <hr class="narrow">


            </ul>
        </li>
    @endhasanyrole
</ul>
