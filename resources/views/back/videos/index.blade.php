@extends('layouts.back')

@section('title')
    &vert; Videos
@endsection
 

@section('content')
    <link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">    
    <style>
        #image {
            z-index: 9;
            width: 95%;
        }
        #play {
            background: url('http://cdn1.iconfinder.com/data/icons/iconslandplayer/PNG/64x64/CircleBlue/Play1Pressed.png') center center no-repeat;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 70px;
            height: 70px;
            margin: -35px 0 0 -35px;
            z-index: 10;
        }
        #container {
            position: relative;
            display: inline-block;
            width: 100%;
         }

    </style>


    <div class="card mb-2">
        <div class="card-header text-white bg-primary text-center fs-5 d-print-none">
            <div class="row">
                <div class="col-11 text-center fs-5">Videos Tutoriales</div>

                <div class="col fs-5 text-end">
                    <i class="fa-light fa-photo-film"></i>
                </div>
            </div>
        </div>

        <div class="card-body ">
            <div class="row mb-4">
                <div class="col-4 video-js" >
                    <div>  
                        <img id="image" height="264" src={{asset('img/logo/intro.jpg')}}/>
                        <button class="vjs-big-play-button" type="button" title="Reproducir" aria-disabled="false"
                         onclick="cargar_modal('video1')">
                            <span class="vjs-icon-placeholder" aria-hidden="true"></span>
                            <span class="vjs-control-text" aria-live="polite">Reproducir</span>
                        </button>
                    </div>    
                    <div class="text-center" style="font-size: 20px;  margin-top:20px;">
                        Introducción
                    </div>
                </div>

                <div class="col-4 video-js">
                    <div>  
                        <img id="image" width="" height="264" src={{asset('img/logo/divisas.jpg')}}/>
                        <button class="vjs-big-play-button" type="button" title="Reproducir" aria-disabled="false"
                         onclick="cargar_modal('video2')">
                            <span class="vjs-icon-placeholder" aria-hidden="true"></span>
                            <span class="vjs-control-text" aria-live="polite">Reproducir</span>
                        </button>
                    </div>    
                    <div class="text-center" style="font-size: 20px; margin-top:20px;">
                        <p>1. Divisas</p>
                    </div>
                    </div>
                <div class="col-4 video-js">
                    <div>  
                        <img id="image" height="264" src={{asset('img/logo/programas.jpg')}}/>
                        <button class="vjs-big-play-button" type="button" title="Reproducir" aria-disabled="false" onclick="cargar_modal('video3')">
                            <span class="vjs-icon-placeholder" aria-hidden="true"></span>
                            <span class="vjs-control-text" aria-live="polite">Reproducir</span>
                        </button>

                    </div>    
                    <div class="text-center" style="font-size: 19px;  margin-top:20px;">
                        <p>2. Programas, Menciones y Cohortes</p>
                    </div>
                    </div>

            </div>
            <div class="row mb-4">
                <div class="col-4 video-js" >
                    <div>  
                        <img id="image" height="264" src={{asset('img/logo/intro.jpg')}}/>
                        <button class="vjs-big-play-button" type="button" title="Reproducir" aria-disabled="false"
                         onclick="cargar_modal('video1')">
                            <span class="vjs-icon-placeholder" aria-hidden="true"></span>
                            <span class="vjs-control-text" aria-live="polite">Reproducir</span>
                        </button>
                    </div>    
                    <div class="text-center" style="font-size: 20px;  margin-top:20px;">
                        3. Aranceles y Matrículas
                    </div>
                </div>

                <div class="col-4 video-js">
                    <div>  
                        <img id="image" width="" height="264" src={{asset('img/logo/divisas.jpg')}}/>
                        <button class="vjs-big-play-button" type="button" title="Reproducir" aria-disabled="false"
                         onclick="cargar_modal('video2')">
                            <span class="vjs-icon-placeholder" aria-hidden="true"></span>
                            <span class="vjs-control-text" aria-live="polite">Reproducir</span>
                        </button>
                    </div>    
                    <div class="text-center" style="font-size: 20px; margin-top:20px;">
                        <p>4. Estudiantes</p>
                    </div>
                    </div>
                <div class="col-4 video-js">
                    <div>  
                        <img id="image" height="264" src={{asset('img/logo/programas.jpg')}}/>
                        <button class="vjs-big-play-button" type="button" title="Reproducir" aria-disabled="false" onclick="cargar_modal('video3')">
                            <span class="vjs-icon-placeholder" aria-hidden="true"></span>
                            <span class="vjs-control-text" aria-live="polite">Reproducir</span>
                        </button>

                    </div>    
                    <div class="text-center" style="font-size: 19px;  margin-top:20px;">
                        <p>5. Banco</p>
                    </div>
                    </div>

            </div>

        </div>
 
    </div>    
  
    <!-- Modal -->
    <div class="modal fade" id="modalVideos" tabindex="-1" aria-labelledby="titulo" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <video 
                            id="videos"
                            controls
                            height="400"
                            poster="{{asset('img/logo/principal_Direccion.jpg')}}"
                            src="" 
                            type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

@push('scripts')
<script type="module">
    
    const modalVideos = document.getElementById('modalVideos');
    const myVideo = document.getElementById('videos');
    const modalTitle = document.getElementById("modalTitulo");
    modalVideos.addEventListener('shown.bs.modal', event => {
        console.log('Abierto y autoplay');
        myVideo.play();
    });

    modalVideos.addEventListener('hidden.bs.modal', event => {
        console.log('Cerrado y stop');
        myVideo.pause();
    });    

    function cargar_modal(video){

        if (video == 'video1') {
            myVideo.src="{{asset('videos/intro1.mp4')}}";
            myVideo.load();
            modalTitle.textContent="Introducción";
        }
        if (video == 'video2') {
            myVideo.src="{{asset('videos/divisas.mp4')}}";
            myVideo.load();
            modalTitle.textContent="1. Divisas";
        }
        if (video == 'video3') {
            myVideo.src="{{asset('videos/programas.mp4')}}";
            myVideo.load();
            modalTitle.textContent="2. Programas, Menciones y Cohorte";
    
        }
        var myModal = new bootstrap.Modal(document.getElementById("modalVideos"), {});
        myModal.show();

    } 
    window.cargar_modal = cargar_modal;
</script>
@endpush





