@extends('layouts.back')

@section('title')
    &vert; Actualizar User
@endsection

@section('content')
    <link href="{{asset('css/multi-select-tag.css')}}" rel="stylesheet">

    <style>
        .styled-table th, .styled-table td {
            padding: 5px;
        }
     </style>   
    <div>
        <link href="{{asset('css/multi-select-tag.css')}}" rel="stylesheet">
 
        <form id="form_update" method="POST" action="{{ route('back.users.update', [$user->id]) }}" enctype="multipart/form-data"  >
            @method('PUT')
            @csrf
            <input type="hidden" id="id_update" name="id" value="{{$user->id}}">
            <input id="permisos" type="hidden" name="roles">
            <div class="modal-body">
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
                                        <label for="nombre" class="col-md-3 col-form-label is_required">Nombres:</label>
                
                                        <div class="col-md-8">
                                            <input id="nombre"  name="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror"  value="{{ $user->nombre }}" required autofocus>
                
                                            @error('nombre')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="apellido" class="col-md-3 col-form-label is_required">Apellidos :</label>
                
                                        <div class="col-md-8">
                                            <input  name="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" 
                                            value="{{ $user->apellido }}" required>
                
                                            @error('apellido')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <label for="decanato" class="col-md-3 col-form-label is_required">Decanato :</label>
                                        <div class="col-md-8">
                                        <select name="cod_dec" id="decanato" class="form-select" required>
                                            @foreach ($decanatos as $decanato)
                                                @if ($decanato->cod_dec == $user->cod_dec)
                                                    <option value="{{ $decanato->cod_dec }}" selected >{{ $decanato->decanato }}</option>
                                                @else
                                                    <option value="{{ $decanato->cod_dec }}">{{ $decanato->decanato }}</option>
                                                @endif
                                            @endforeach
                                        </select>                    
                                        </div>    
                                    </div>

                                    
                                    <div class="row mb-2">
                                        <label for="cedula" class="col-md-3 col-form-label is_required">Cédula :</label>
                
                                        <div class="col-md-8">
                                            <input  name="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" value="{{ $user->cedula }}" required>
                
                                            @error('cedula')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                
                                    <div class="row mb-2">
                                        <label for="email" class="col-md-3 col-form-label is_required">E-mail :</label>
                
                                        <div class="col-md-8">
                                            <input  name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email}}" required>
                
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                
                                    <div class="row mb-2">
                                        <label for="telefono" class="col-md-3 col-form-label">teléfono :</label>
                
                                        <div class="col-md-8">
                                            <input  name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{$user->telefono}}">
                
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                
                            </div>
                
                    </div>
                
                    <div class="col-lg-6">
                        <div id="rol_card" class="card mb-2 " style="display: block;">
                            <div class="card-header text-white" style="background-color: #274d8f;">
                                <div class="row">
                                    <div class="col">Permisos por ROLES o GRUPOS</div>
                
                                    <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                                </div>
                            </div>
                            <div  class="card-body">
                                <ul>
                                    <li>Los permisos por "Roles" son permisos definidos a grupos de usuarios.</li>
                                    <li>Si selecciona un permiso por "Roles", no se tomarán en cuenta los permisos individuales.</li>
                                </ul>
                                <div class="row">
                                    <label for="roles" class="col-md-3 col-form-label is_required">Rol(es):</label>
            
                                    <div class="col-md-8">
                                        <select name="rol[]" style="width: 100%" id="roles" class="form-select" multiple>
                                                @foreach ($roles as $rol)
                                                    @if ($user->hasRole($rol->name))
                                                        <option value="{{ $rol->name }}" selected >{{ $rol->name }} </option>
                                                    @else
                                                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>                    
                                        </select>                    
                                    </div>
                                </div>

                            </div>
                
                            
                        </div>


                        <div id="error_card" class="card mb-2 print-error-msg" style="display:none;">
                            <div   class="card-header bg-danger text-white">
                                <div class="row">
                                    <div class="col">Errores</div>
                
                                    <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul id="lista_error">
                                </ul>
                            </div>
                
                            
                        </div>            
                    </div>
                </div>
                <div class="row">
                     <div class="row mb-2 mt-2">
                        <table id="sqltable" class="styled-table mb-3 mt-0" style="width: 100%">
                            <thead >
                                <tr class="titulo">
                                    <td class="text-center no-select fs-5" colspan="8" data-dt-order="disable">
                                       Permisos Individuales</td>
                                 </tr>
                                <tr>
                                    <th scope="col">Modulo</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Crear</th>
                                    <th scope="col">Modificar</th>
                                    <th scope="col">Eliminar</th>
 
                                 </tr>
                            </thead>
                            <tbody>
                                @foreach ($modulos as $modulo )
                                   @php
                                       $permisos_mod = $permisos->where('modulo',$modulo);
                                   @endphp
                                   <tr>
                                      <td style="background: #607D57;  font-weight: bold; color:white; text-align:center;">{{$modulo}}</td>

                                        @foreach ($permisos_mod as $per_mod)
                                                    <td style="background: #fff;">
                                                        @if ($per_mod->id==1)
                                                            <input type="checkbox" name="permisos[]" checked value="{{$per_mod->name}}" disabled>
                                                            {{$per_mod->name}}
                                                         @else
                                                           @if (in_array($per_mod->name, $user_permisos))
                                                                 <input type="checkbox" checked name="permisos[]" value="{{$per_mod->name}}">
                                                                {{$per_mod->name}}
                                                           @else
                                                                <input type="checkbox" name="permisos[]" value="{{$per_mod->name}}">
                                                                {{$per_mod->name}}

                                                           @endif 
                                                        @endif
                                                    </td>
                                        @endforeach 
                                   </tr>                                 
                                @endforeach
                            </tbody>
                        </table>                     
                    </div>


                </div>
                
            </div>
            <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary text-white btn-sm" href="{{route('back.users.index')}}">
                    <i class="bi bi-arrow-left-short"></i>
                    Regresar
                </a>
                <button type="submit" id="botonSubmit" class="btn btn-primary text-white btn-sm">Actualizar</button>

            </div>

        </form>    
    </div>
    <script src="{{asset('js/multi-select-tag.js')}}"></script>

    <script type="module">
        $(document).ready(function() {
            var str = @json($userRoles);
            console.log('Roles:'+str);
            var userRoles=@json($userRoles);
            document.getElementById('permisos').value=userRoles;
            console.log(document.getElementById('permisos').value);
            var tagSelector = new MultiSelectTag('roles', {
                required: false,               // default false.
                placeholder: '  ',   // default 'Search'.
                onChange: function(selected) { // Callback when selection changes.
                    console.log('Selection changed:', selected);
                    str=tagSelector.getSelectedTags().map(object => object.id);
                    document.getElementById('permisos').value=JSON.stringify(str); 
                    console.log('Valor: ',document.getElementById('permisos').value);
                }
             });
        });     
    </script>

    <script type="module">
        $('#roles').select2('destroy');
    </script>


@endsection
