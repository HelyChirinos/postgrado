@extends('layouts.back')

@section('title')
    &vert; Videos
@endsection
 

@section('content')
    <link href="{{asset('css/playlist.css')}}" rel="stylesheet">
    <div class="card p-0">
       <div class="card-header text-white bg-primary d-print-none">
            <div class="row">
                <div class="col fs-5 text-center">Videos Tutoriales</div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="parent">
                <div class="child1">
                    <video id="main-video" style="width: 100%; height:550px; overflow: hidden;" src="{{asset('videos/intro1.mp4')}}" controls autoplay></video>
                    <p id="main-title">Introducción</p>
                </div>
                <div class="child2">
                    <div class="lista"
"                       >Lista de Videos</div>
                    <div class="videos" onclick="playVideo('intro')">
                        <video src="https://postgradoucla.freemyip.com/videos/intro1.mp4"></video>
                        <p>Introducción</p>
                    </div>
                    <div class="videos" onclick="playVideo('video1')">
                        <video src="https://postgradoucla.freemyip.com/videos/divisas.mp4"></video>
                        <p>1. Divisas</p>
                    </div>
                    <div class="videos" onclick="playVideo('video2')">
                        <video src="https://postgradoucla.freemyip.com/videos/programas.mp4"></video>
                        <p>2. Programas, Menciones y Cohortes</p>
                    </div>
                    <div class="videos" onclick="playVideo('video3')">
                        <video src="https://postgradoucla.freemyip.com/videos/aranceles.mp4"></video>
                        <p>3. Aranceles y Matrículas</p>
                    </div>
                    <div class="videos" onclick="playVideo('video4')">
                        <video src="https://postgradoucla.freemyip.com/videos/estudiantes.mp4"></video>
                        <p>4. Estudiantes</p>
                    </div>
                    <div class="videos" onclick="playVideo('video5')">
                        <video src="https://postgradoucla.freemyip.com/videos/recibos1.mp4"></video>
                        <p>5. Recibos (Parte No.1)</p>
                    </div>
                    <div class="videos" onclick="playVideo('video6')">
                        <video src="https://postgradoucla.freemyip.com/videos/recibos2.mp4"></video>
                        <p>6. Recibos (Parte No.2)</p>
                    </div>
                    <div class="videos" onclick="playVideo('video7')">
                        <video src="https://postgradoucla.freemyip.com/videos/recibos3.mp4"></video>
                        <p>7. Recibos (Parte No.3) Impresión de Programas</p>
                    </div>
                    <div class="videos" onclick="playVideo('video8')">
                        <video src="https://postgradoucla.freemyip.com/videos/bancos1.mp4"></video>
                        <p>8. Bancos (Parte No.1) Archivo Diario</p>
                    </div>

                </div>
            </div>
        </div>   
    </div>
    <script>
        function playVideo(video){
            let mainVideo = document.getElementById("main-video");
            let mainTitle = document.getElementById("main-title");
            let myVideo='';
            if (video == 'intro') {
                    myVideo="https://postgradoucla.freemyip.com/videos/intro1.mp4";
                    title="Introducción";
                }
                if (video == 'video1') {
                    myVideo="https://postgradoucla.freemyip.com/videos/divisas.mp4";
                    title="1. Divisas";
                }
                if (video == 'video2') {
                    myVideo="https://postgradoucla.freemyip.com/videos/programas.mp4";
                    title="2. Programas, Menciones y Cohorte";
                }
                if (video == 'video3') {
                    myVideo="https://postgradoucla.freemyip.com/videos/aranceles.mp4";
                    title="3. Aranceles y Matrículas";
                }
                if (video == 'video4') {
                    myVideo="https://postgradoucla.freemyip.com/videos/estudiantes.mp4";
                    title="4. Estudiantes";
                }

                if (video == 'video5') {
                    myVideo="https://postgradoucla.freemyip.com/videos/recibos1.mp4";
                    title="5. Recibos (Parte No.1)";
                }
                if (video == 'video6') {
                    myVideo="https://postgradoucla.freemyip.com/videos/recibos2.mp4";
                    title="6. Recibos (Parte No.2)";
                }
                if (video == 'video7') {
                    myVideo="https://postgradoucla.freemyip.com/videos/recibos3.mp4";
                    title="7. Recibos (Parte No.3) Impresión de Programas";
                }
                if (video == 'video8') {
                    myVideo="https://postgradoucla.freemyip.com/videos/bancos1.mp4";
                    title="8. Bancos (Parte No.1) Archivo Diario";
                }

            mainVideo.src = myVideo;
            // mainVideo.load();
            mainTitle.innerHTML = title;
        }
    </script>
    
    
@endsection