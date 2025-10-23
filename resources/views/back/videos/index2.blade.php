@extends('layouts.back')

@section('title')
    Videos-Turorial
@endsection

@section('content')
    <link href="https://vjs.zencdn.net/8.22.0/video-js.css" rel="stylesheet" />
    <div class="card">
        <div class="card-header header-primary">Videos Tutoriales</div> 
        <div class="card-body">    
        <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            width="640"
            height="264"
            poster={{ asset('img/logo/principal_Direccion.jpg') }}
            data-setup="{}"
        >
            <source src="{{asset('videos/banco_exceL.mp4')}}" type="video/mp4" />
            <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
                >supports HTML5 video</a
            >
            </p>
        </video>

            
        </div>    

    </div>
@endsection

  <script src="https://vjs.zencdn.net/8.22.0/video.min.js"></script>

