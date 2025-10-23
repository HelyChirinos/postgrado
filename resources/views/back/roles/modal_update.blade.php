
<div>
    <style>
        .styled-table th, .styled-table td {
            padding: 5px;
        }
    </style>
    <div class="row">
        <div class="col">
            <form method="POST" action="{{ route('back.roles.update', [$role->id]) }}">
                @csrf
            @method('PUT')
            <input type="hidden" id="id_update" name="id" value="{{$role->id}}">

                <div class="card mb-2">
                    <div class="card-body">

                        <div class="row mb-2">
                            <label for="name" class="col-md-2 col-form-label is_required text-end">Nombre :</label>

                            <div class="col-md-8">
                                <input id="name" name="name" type="text" placeholder="Nombre del Rol"
                                 class="form-control" value="{{$role->name}}" required >
                            </div>
                        </div>

                        <div class="row mb-1">
                            <label for="descripcion" class="col-md-2 col-form-label is_required text-end">Descripción :</label>

                            <div class="col-md-8">
                                <input id="descripcion" name="descripcion" type="text" placeholder="Descipción" 
                                class="form-control" value="{{$role->description}}" required >
                            </div>
                        </div>

                     <div class="row mb-2 mt-2">
                        <table id="sqltable" class="styled-table mb-3 mt-0" style="width: 100%">
                            <thead >
                                <tr class="titulo">
                                    <td class="text-center no-select fs-5" colspan="8" data-dt-order="disable">
                                       Permisos </td>
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
                                                    <td>
                                                        @if ($per_mod->id==1)
                                                            <input type="checkbox" name="permisos[]" checked value="{{$per_mod->name}}" disabled>
                                                            {{$per_mod->name}}
                                                         @else
                                                           @if (in_array($per_mod->id, $permisos_rol))
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

                    <div class="card-footer">
                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary text-white btn-sm">Actualizar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
    <script type="module" src="{{URL::asset('js/currency_ve.js') }}"></script>

</div>
