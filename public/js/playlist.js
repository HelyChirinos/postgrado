function playVideo(video){
    let mainVideo = document.getElementById("main-video");
    let mainTitle = document.getElementById("main-title");
    let myVideo='';
      if (video == 'intro') {
            myVideo="{{asset('videos/intro1.mp4')}}";
            title="Introducción";
        }
        if (video == 'video1') {
            myVideo="{{asset('videos/divisas.mp4')}}";
            title="1. Divisas";
        }
        if (video == 'video2') {
            myVideo="{{asset('videos/programas.mp4')}}";
            title="2. Programas, Menciones y Cohorte";
        }
    mainVideo.src = myVideo;
    mainVideo.load();
    mainTitle.innerHTML = title;


}