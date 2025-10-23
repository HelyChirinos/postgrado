<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dependent Dropdown using Ajax Example Laravel - LaravelTuts.com</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="bg-dark text-white mb-4 text-center py-4">
                   <h4 >Dependent Dropdown using Ajax Example Laravel - LaravelTuts.com</h4>
                </div> 
                <form>
                    <div class="form-group mb-3">
                        <select  id="programas" class="form-control" onchange="cargarMencion(this.value)">
                            <option value="">-- Select Programa --</option>
                            @foreach ($programas as $data)
                            <option value="{{$data->id}}">
                                {{$data->programa}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select id="mencion" class="form-control">
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        function cargarMencion (id){
            var idPrograma = id;
                $("#mencion").html('');
                $.ajax({
                    url: "{{route('back.estudiantes.dropdown')}}",
                    method: "POST",
                    data: {
                        programa_id: idPrograma,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
              
                        $('#mencion').html('<option value="">-- Mención?.. --</option>');
                        $.each(result, function (key, value) {
                            $("#mencion").append('<option value="' + value
                                .id + '">' + value.mencion + '</option>');
                        });
                        
                    },
                    error: function(result) {
                         alert('Tipo de Error:' + result.status+' '+result.responseText);
                    }

                });

        };

    </script>