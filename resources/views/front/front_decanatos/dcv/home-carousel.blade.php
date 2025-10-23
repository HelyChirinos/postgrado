<div class="card mb-2">
    <div class="card-header">
        <div class="row">
            <div class="col-11">Coordinación de Postgrado-Decanato de Ciencias Veterinarias</div>
            <div class=" col fs-5 text-end">
                <i class="bi bi-camera-fill"></i>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div id="MyCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="0" aria-label="Slide 1" aria-current="true" class="active"></button>
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="4" aria-label="Slide 4"></button>
                 
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/decanatos/veterinaria/portatil_dcv.webp') }}" class="d-block w-100" alt="006">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 >Sistema Administrativo de Postgrado</h3>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/decanatos/veterinaria/vet1.jpg') }}" class="d-block w-100" alt="001">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Especialización Medicina Veterinaría Preventiva</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/decanatos/veterinaria/vet2.jpg') }}" class="d-block w-100" alt="002">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Maestría Producción Animal - Mencion: Producción de Leche</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/decanatos/veterinaria/vet3.webp') }}" class="d-block w-100" alt="003">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Maestría en Producción de Ovínos y Caprinos</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/decanatos/veterinaria/vet4.jpg') }}" class="d-block w-100" alt="003">
                    <div class="carousel-caption d-none d-md-block">
                        <h5> </h5>
                    </div>
                </div>
                 
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#MyCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#MyCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="card-footer">
        @if(session('locale')=='en')

        @else
            <div class="row ">
                <div class="col small">
                    <a href="https://www.ucla.edu.ve" target="_blank">www.dcv.postrado-ucla.edu.ve</a>
                    <a href="mailto://post_dcv@ucla.edu.ve" target="_blank">.post_dcv@ucla.edu.ve</a>

                </div>

                <div class="col small text-end d-none d-md-block">
                    Teléfono : +58 0251 259-24-61<br />
                    Celular : +58 414 5XX-XX-XX
                </div>

                <div class="col text-end">
                    Núcleo Hector Ochoa Zuleta, Edif. G<br/>Tarabana-Cabudare, Lara<br />Venezuela
                </div>
            </div>
        @endif
    </div>
</div>
@if(session('locale')=='en')
    <div class="alert alert-info p-2">
        Welcome <b>guest</b>. Click the
        <button type="button" class="btn btn-sm btn-success text-white" disabled>
            <i class="bi bi-box-arrow-in-right"></i>
        </button>
        button in the upper right corner to log in.
    </div>
@else
<div class="alert alert-info p-2">
    Bienvenido . Click en el boton
    <button type="button" class="btn btn-sm btn-success text-white" disabled>
        <i class="bi bi-box-arrow-in-right"></i>
    </button>
    en la esquina superior derecha para ingresar al Sistema .
</div>
@endif
