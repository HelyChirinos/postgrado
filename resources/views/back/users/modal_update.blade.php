<div class="modal-content">
    <link href="{{asset('css/multi-select-tag.css')}}" rel="stylesheet">
    <form id="form_update"  >
        @csrf
        @method('PUT')
            <div class="row">
                <input type="hidden" id="id_update" name="id" value="{{$user->id}}">
                <input id="permisos" type="hidden" name="roles">

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
                                        <input id="telefono" name="telefono" type="text" 
                                        class="form-control @error('telefono') is-invalid @enderror" 
                                        value="{{$user->telefono}}" >

                                        @error('telefono')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="narrow" />

                                    <div class="row">
                                        <label for="rol" class="col-md-3 col-form-label is_required">Rol:</label>
                                        <div class="col-md-8">
                                            <select name="rol[]" id="roles" class="form-select" multiple required>
                                                @foreach ($roles as $rol)
                                                    @if ($user->hasRole($rol->name))
                                                        <option value="{{ $rol->name }}" selected >{{ $rol->name }} </option>
                                                    @else
                                                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>                    

                                        </div>
                                    </div>
                            </div>
                        </div>

                </div>

                <div class="col-lg-6">

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
                                <li>Click boton <strong>Actualizar</strong> para Grabar.</li>
                                <li> El boton <a class="btn btn-secondary text-white btn-sm" href="" >
                                    <i class="bi bi-arrow-left-short"></i>
                                </a> Es para Cancelar </li>
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
            <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary text-white btn-sm" href="" data-bs-dismiss="modal" role="button" tabindex="-1">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
                <button type="submit" id="u_botonSubmit" class="btn btn-primary text-white btn-sm">Actualizar</button>
            </div>

    </form>
</div>
    <script src="{{asset('js/multi-select-tag.js')}}"></script>
    <script>
        $(document).ready(function() {
            var str = @json($userRoles);
            console.log('Roles:'+str);
            var userRoles=@json($userRoles);
            document.getElementById('permisos').value=userRoles;
            console.log(document.getElementById('permisos').value);
            var tagSelector = new MultiSelectTag('roles', {
                required: true,               // default false.
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
    $('#form_update').submit(function(e)
    {
        e.preventDefault();
        let datos = $('#form_update').serialize();
        let id = $('#id_update').val()
        $.ajax({
            url: "{{ route('back.users.update', 'id') }}".replace("id", id),
            method: 'post',
            data:  datos,
            success: function(result)
            {
                    console.log('Resultado: '+result.success);
                    $("#u_help_card").css("display", "block");
                    $("#u_error_card").css("display", "none");
                    $('#u_lista_error').html('');                  
                    $('#update_modal').modal('hide');
                    $("#modal_body").empty();
                    var url_mensaje = '{{ route("back.users.message","Actualizar") }}';
                     window.location.href=url_mensaje;
            },
            error: function(result) 
            {
              if (result.status == 422) {
                  $("#u_help_card").css("display", "none");
                  $("#u_error_card").css("display", "block");                  
                  $('#form_update').find(".print-error-msg").find("ul").html('');
                  $('#form_update').find(".print-error-msg").css('display','block');
                  $.each( result.responseJSON.errors, function( key, value ) {
                        $('#form_update').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                  });
              } else {
                 alert('Tipo de Error:' + result.status+' - '+result.responseText);

              }
            }        
        });
    });



</script>