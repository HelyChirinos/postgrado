
@extends('layouts.back')

@section('title')
    &vert; Usuarios
@endsection

@section('content')
     {{-- Se utiliza las Notificaciones de errores con validateWithBag nombre Updatepass --}}

    @if ($errors->updatePass->any())
        <script > 
            let errors = true;
            var lista = {!! json_encode($errors->updatePass->all()) !!};;
        </script> 

    @else
        <script > 
            let errors = false;
            var lista =[];
        </script> 
    @endif
 
    <div class="card">

        <form id="form_update" action="{{route('back.profile.updatePassword', Auth::user())}}" method="post" id="updatePassword" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header header-primary">Actualizar Contraseña</div> 
            <div class="card-body">  
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">Datos de la contraseña</div>
                            <div class="card-body">
                                <div class="row gy-3 mb-3">

                                    <div class="col-md-12">
                                        <label class="small mb-1  is_required" for="current_password">Contraseña Actual</label>
                                        <input class="form-control" id="current_password" type="password" name="current_password" required autocomplete="current-password">

                                    </div>

                                    <div class="col-md-12">
                                        <label class="small mb-1 is_required" for="password">Nueva Contraseña</label>
                                        <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password">

                                    </div>
                                    <div class="col-md-12">
                                        <label class="small mb-1 is_required" for="password_confirmation">Confirmar Contraseña</label>
                                        <input class="form-control" id="password" type="password" name="password_confirmation" required autocomplete="current-password">

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div id="u_help_card" class="card mb-2" style="display: block;">
                            <div   class="card-header bg-info text-white">
                                <div class="row">
                                    <div class="col">Ayuda</div>
                
                                    <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                                </div>
                            </div>
                
                            <div  class="card-body">
                                <ul>
                                    <li>Los Campos con (<span class="is_required"></span> ) son obligatorios.</li>
                                    <li>El Password debe tener al menos ocho (8) caracterea alfanumericos</li>
                                    <li>Se recomienda que su contraseña contenga un número, un caracter especial y una letra Mayuscula.  </li>
                                   <li>Click boton <strong>Actualizar</strong> para Grabar.</li>
    
                                </ul>
                            </div>
                        </div>
                        <div id="u_error_card" class="card mb-2 print-error-msg" style="display:none;">
                            <div   class="card-header bg-danger text-white">
                                <div class="row">
                                    <div class="col">Errores</div>
                
                                    <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul id="u_lista_error">
                                </ul>
                            </div>
                
                            
                        </div>                              
                    </div>                    
                </div>
            </div>    
            <div class="card-footer text-center">
                <button type="submit" id="u_botonSubmit" class="btn btn-primary " style="width:30%">Cambiar Contraseña</button>
            </div>    
        </form>

    </div>


@endsection

@push('styles')

    <style type="text/css">
    
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }
        .card .card-header {
            font-weight: 500;
        }           
        .header-primary {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color:#274D8F;
            color: white;
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }
    </style>
@endpush

@push('scripts')
    <script type="module">
        $( document ).ready(function() {
            if (errors) {
                console.log(lista.length)
                $("#u_error_card").css("display", "block");  
                $('#form_update').find(".print-error-msg").find("ul").html('');
                $('#form_update').find(".print-error-msg").css('display','block');

                $.each(lista, function( key, value ) {
                        console.log(key);
                        $('#form_update').find(".print-error-msg").find("ul").append('<li class="text-danger" >'+value+'</li>');
                });
            }
        });
    </script>
@endpush






