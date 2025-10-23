
@extends('layouts.back')

@section('title')
    &vert; Usuarios
@endsection

@section('content')
   
    <div class="card">
        <form action="{{route('back.profile.update',$user)}}" method="post" id="updateDatos" enctype="multipart/form-data">
        @csrf    
        @method('PUT')
        <div class="card-header header-primary">Perfil de Usuario</div> 
        <div class="card-body">    
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">Datos Personales</div>
        
                                <div class="col fs-5 text-end">
                                    <img src="{{ asset('img/icons/person.png') }}" />
                                </div>
                            </div>
                        </div>
        
                        <div class="card-body">
                            <div class="row mb-2">
                                <label for="nombre" class="col-md-3 col-form-label is_required">Nombre :</label>
        
                                <div class="col-md-8">
                                    <input id="nombre" name="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror"  value="{{ $user->nombre }}" required autofocus>
        
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="apellido" class="col-md-3 col-form-label is_required">Apellido :</label>
        
                                <div class="col-md-8">
                                    <input id="apellido" name="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" value="{{ $user->apellido }}" required>
        
                                    @error('apellido')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="cedula" class="col-md-3 col-form-label is_required">Cédula :</label>
        
                                <div class="col-md-8">
                                    <input id="cedula" name="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" value="{{ $user->cedula }}" required>
        
                                    @error('cedula')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
        
                            <div class="row mb-2">
                                <label for="email" class="col-md-3 col-form-label is_required">E-mail :</label>
        
                                <div class="col-md-8">
                                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email}}" required>
        
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
        
                            <div class="row mb-2">
                                <label for="telefono" class="col-md-3 col-form-label">teléfono :</label>
        
                                <div class="col-md-8">
                                    <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{$user->telefono}}" >
        
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
        
                            <div class="row mb-4">
                                <label for="fecha_nac" class="col-md-3 col-form-label">Fecha Nac. :</label>
        
                                <div class="col-md-8">
                                    <input id="fecha_nac" name="fecha_nac" type="date" class="form-control @error('fecha_nac') is-invalid @enderror" 
                                    value="{{$user->fecha_nac != null ? $user->fecha_nac->toDateString() : ' '}}">
        
                                    @error('fecha_nac')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr class="narrow" />
        
                            <div class="row">
                                <label for="is_propietario" class="col-md-3 col-form-label">Administrador ?</label>
        
                                <div class="col-md-8">
                                    @if ($user->is_propietario == 0) 
                                       <p class="mt-2">NO</p>
                                    @else
                                        <p class="mt-2">SI</p>
                                    @endif
                          
                                </div>
                            </div>
                        </div>
                    </div>
        
            </div>               
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">Foto de Perfil</div>
                        <div class="card-body text-center">
                            <img id="preview" class="img-account-profile rounded-circle mb-2 mt-2"
                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" onclick="$('#foto').click()">
                            <input type="file" hidden id="foto" name="foto">
                        </div>
                    </div>
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
                                <li> <strong>Click</strong> en la imagen para cambiar</li>
                                <li> Formatos de imagen permitidos: <strong>PNG, JPG, GIF</strong> </li>
                                <li> El tamaño máximo del archivo de imagen es: <strong>1 MB</strong> </li>
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
            <button type="submit" id="u_botonSubmit" class="btn btn-primary " style="width:30%">Actualizar Información</button>
        </div>    
        </form>

    </div>
@endsection


@push('styles')
    <style type="text/css">
    
        .img-account-profile {
            height: 10rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

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
        $(document).ready(function (e) {
            $('#foto').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]); 
            });
        });        
    </script>   
@endpush






