<header>
    <nav class="navbar bg-secondary fixed-top d-print-none">
        <div class="container-fluid">
            {{-- left --}}
            <div class="d-flex align-items-center justify-content-start">
                <div>
                    <button class="btn btn-lg btn-outline-dark ms-4 me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" tabindex="-1"
                        title="Menu">
                        <i class="bi bi-list"></i>
                    </button>
                </div>

                <div class="user-box dropdown ms-4">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" width="42" height="42" src="{{asset(Auth::user()->profile_photo_url) }}" alt="{{ Auth::user()->name }}" />
                            <span class="text-white ms-2"> {{ Auth::user()->name }} </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('back.profile.show') }}"><i class="fa-light fa-user mx-2"></i></i><span>Perfil</span></a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('back.profile.showPassword')   }}"><i class="fa-light fa-lock mx-2"></i><span>Cambiar Password</span></a>
                        </li>
                        <li>
                            <div class="dropdown-divider mb-0"></div>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout2-form').submit();"><i class="fa-light fa-person-to-door mx-2"></i><span>Salir del Sistema</span></a>
                        </li>
                        <form method="POST" id="logout2-form" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </ul>
                </div>

            </div>

            {{-- center left 
            <div class="d-none d-lg-block">
                @include('components.switch')
            </div>

            {{-- center right --}}
            <div>
                {{-- @include('back.components.year') --}}
            </div>

            <div> @include ('back.components.dolar') </div>

            {{-- right --}}

            @php($ruta = request()->route()->uri)

            <div>
 
                <div class="btn-group me-1" role="group">

                    <a class="{{ ($ruta =='back/divisas') ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}" 
                    href="{{ route('back.divisas.index') }}"  title="Dolar BCV" role="button" tabindex="-1">
                        <i class="fa-solid fa-dollar-sign fa-lg"></i>
                    </a> 
                    @can('Ver Recibos')
                        <a class="{{ ($ruta =='back/recibos') ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}" 
                        href="{{ route('back.recibos.index') }}" title="Recibos" role="button" tabindex="-1">
                            <i class="fa-light fa-file-invoice-dollar fa-lg"></i>
                        </a>
                    @endcan                   

                </div>

                <div class="btn-group me-1" role="group">
                    @canany(['Ver Programas','Ver Cohortes'])
                        <a 
                            class="{{ ($ruta =='back/tablas_base') ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}"
                            href="{{ route('back.tablas.index') }}" title="Programas y Menciones" role="button" tabindex="-1">
                            <i class="fa-light fa-table-pivot fa-lg"></i>
                        </a>
                    @endcan
                    @canany(['Ver Aranceles','Ver Matrículas'])    
                        <a class="{{ ($ruta =='back/aranceles') ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}" href="{{ route('back.aranceles.index') }}" title="Aranceles y Matriculas" role="button" tabindex="-1">
                            <i class="fa-light fa-money-check-dollar-pen fa-lg"></i>
                        </a>
                    @endcan  
                    @canany(['Ver Estudiantes'])    
                        <a class="{{ ($ruta =='back/estudiantes') ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}" href="{{ route('back.estudiantes.index') }}" title="Estudiantes" role="button" tabindex="-1">
                            <i class="fa-light fa-screen-users fa-lg"></i>
                        </a>
                    @endcan                        
                </div>

                <div class="btn-group me-1" role="group">
                    @canany(['Ver Bancos'])
                        <a class="{{ (($ruta =='back/bancos') || ($ruta =='back/bancos/diario') ) ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}" href="{{ route('back.bancos.index') }}" title="Conciliación-Banco" role="button" tabindex="-1">
                            <i class="fa-light fa-building-columns fa-lg"></i>
                        </a>
                    @endcan
                    @canany(['Ver Reportes'])
                        <a class="{{ ($ruta =='back/reportes') ? 'btn btn-lg  btn-success' : 'btn btn-lg btn-outline-dark text-white'}}" href="{{ route('back.reportes.index') }}" title="Reportes" role="button" tabindex="-1">
                            <i class="fa-light fa-print fa-lg"></i>
                        </a>
                    @endcan
                </div>

                <a class="btn btn-lg btn-danger text-white" href="{{ route('logout') }}" title="Salir" role="button" tabindex="-1"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>

            {{-- Offcanvas Menu --}}
            @include('back.components.offcanvas')

            {{-- logout --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</header>
