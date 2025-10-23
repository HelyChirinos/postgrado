<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="{{ public_path('css/bootstrap4.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ public_path('css/reports.css')}}">
    <title>Encabezado</title>
 
</head>

<body>

    @php
        $decanato = getSetup();
        $logo = 'img/logo'.$decanato->path_logo;
        $nom_decanato = $decanato->decanato;
    @endphp

    <div id="header" >
        <img class="img_header_landscape" src="{{public_path($logo)}}">
        <div class="info_header_landscape">
            <p>Universidad Centroccidental "Lisandro Alvarado"</p>
            @if ($decanato->cod_dec != '00')
                <p>{{$nom_decanato}}</p>
            @endif
            <p>Dirección de Postgrado</p>
        </div>
    </div>
    <div id="footer">
        <div class="container">
            <div style="width: 100%; font-size:10px; " ><span style="margin-right: 70%;">Fecha: {{ date('d-m-Y');}} </span> Pag: <span class="pagenum"></span> </div>
        </div>            
    </div>
  
    <div class="container">
        <h4 class="text-center">Titulo del Reporte</h4>
        @for ($i=1; $i<=40; $i++)
            <p>{{$i}}</p>
        @endfor
    </div>
  
</body>
</html>