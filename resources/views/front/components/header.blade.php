<header>
    <nav class="navbar bg-secondary fixed-top">
        <div class="container-fluid">
            {{-- left --}}
            <div>


                <a class="btn btn-lg btn-light me-1" href="https://www.ucla.edu.ve" target="_blank" title="yourcompany.com" role="button" tabindex="-1">
                    <img src="{{ asset('img/logo/logoucla035.png') }}" alt="UCLA">
                </a>
            </div>

            {{-- center --}}
            <div>
                @include('components.switch')
            </div>

            {{-- right --}}
            <div class="d-flex align-items-center justify-content-end">
  

                {{-- <a class="btn btn-lg btn-success text-white me-1" href="/" title="Home" role="button" tabindex="-1">
                    <i class="bi bi-house-fill"></i>
                </a> --}}

                <a class="btn btn-lg btn-success text-white" href="{{ route('login') }}" title="Login" role="button" tabindex="-1">
                    <i class="bi bi-box-arrow-in-right"></i>
                </a>
            </div>
        </div>
    </nav>
</header>
