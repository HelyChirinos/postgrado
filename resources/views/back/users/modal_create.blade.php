    <div>
        <link href="{{asset('css/multi-select-tag.css')}}" rel="stylesheet">
 
        <form id="form_add"  >
            @csrf
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
                                            <input id="nombre"  name="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required autofocus>
                
                                            @error('nombre')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="apellido" class="col-md-3 col-form-label is_required">Apellidos :</label>
                
                                        <div class="col-md-8">
                                            <input  name="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}" required>
                
                                            @error('apellido')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <label for="decanato" class="col-md-3 col-form-label is_required">Decanato :</label>
                                        <div class="col-md-8">
                                            <select name="cod_dec" id="decanato" class="form-select" required>
                                                <option value="" hidden>Decanato? ...</option>
                                                @foreach ($decanatos as $decanato)
                                                        <option value="{{ $decanato->cod_dec }}">{{ $decanato->decanato }}</option>
                                                @endforeach
                                            </select>                    
                                        </div>    
                                    </div>

                                    
                                    <div class="row mb-2">
                                        <label for="cedula" class="col-md-3 col-form-label is_required">Cédula :</label>
                
                                        <div class="col-md-8">
                                            <input  name="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" value="{{ old('cedula') }}" required>
                
                                            @error('cedula')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                
                                    <div class="row mb-2">
                                        <label for="email" class="col-md-3 col-form-label is_required">E-mail :</label>
                
                                        <div class="col-md-8">
                                            <input  name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                
                                    <div class="row mb-2">
                                        <label for="telefono" class="col-md-3 col-form-label">teléfono :</label>
                
                                        <div class="col-md-8">
                                            <input  name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" >
                
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                
                                    <hr class="narrow" />
                
                                    <div class="row">
                                        <label for="roles" class="col-md-3 col-form-label is_required">Rol:</label>
                
                                        <div class="col-md-8">
                                            <select name="rol[]" id="roles" class="form-select" multiple required>
                                                @foreach ($roles as $rol)
                                                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                                @endforeach
                                            </select>                    

                                        </div>
                                    </div>
                                </div>
                
                            </div>
                
                    </div>
                
                    <div class="col-lg-6">
                        <div class="card mb-2">
                            <div class="card-header bg-primary text-white">
                                <div class="row">
                                    <div class="col">Claves de Ingreso</div>
                
                                    <div class="col fs-5 text-end"><i class="bi bi-unlock"></i></div>
                                </div>
                            </div>
                
                            <div class="card-body">
                
                                <div class="row mb-2">
                                    <label for="password" class="col-md-4 col-form-label is_required">Password :</label>
                
                                    <div class="col-md-7">
                                        <input  name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                
                                <div class="row">
                                    <label for="password_confirmation" class="col-md-4 col-form-label is_required">Confirm password :</label>
                
                                    <div class="col-md-7">
                                        <input  name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="narrow" />
                
                            </div>
                        </div>
                        <div id="help_card" class="card mb-2" style="display: block;">
                            <div   class="card-header bg-info text-white">
                                <div class="row">
                                    <div class="col">Ayuda</div>
                
                                    <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                                </div>
                            </div>
                
                            <div  class="card-body">
                                <ul>
                                    <li>Los Campos con (<span class="is_required"></span> ) son obligatorios.</li>
                                    <li>Click boton <strong>Agregar</strong> para Grabar.</li>
                                    <li> El boton <a class="btn btn-secondary text-white btn-sm" href="" >
                                        <i class="bi bi-arrow-left-short"></i>
                                    </a> Es para Cancelar </li>
                                </ul>
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
                
            </div>
            <div class="modal-footer justify-content-between">
                <a class="btn btn-secondary text-white btn-sm" href="" data-bs-dismiss="modal" role="button" tabindex="-1">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
                <button type="submit" id="botonSubmit" class="btn btn-primary text-white btn-sm">Agregar</button>
            </div>
        </form>    
    </div>

    <script src="{{asset('js/multi-select-tag.js')}}"></script>
    <script>
        var str = '';
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
    </script>

    <script type="module">

        $('#form_add').submit(function(e) 
        {
            e.preventDefault();
            let datos = $('#form_add').serialize();
            var myUrl = '/pruebas?' + datos;
            $.ajax({
                url: "{{ route('back.users.store') }}",
                method: 'post',
                data:  datos,
                success: function(result)
                {
                    $("#help_card").css("display", "block");
                    $("#error_card").css("display", "none");
                    $('#lista_error').html('');                  
                    $('#add_modal').modal('hide');
                    resetAddForm();
                    var url_mensaje = '{{ route("back.users.message","Nuevo") }}';
                    window.location.href=url_mensaje;
                },
                error: function(result) 
                {
                if (result.status == 422) {
                    $("#help_card").css("display", "none");
                    $('#form_add').find(".print-error-msg").find("ul").html('');
                    $('#form_add').find(".print-error-msg").css('display','block');
                    $.each( result.responseJSON.errors, function( key, value ) {
                            $('#form_add').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });
                } else {
                    alert('Tipo de Error:' +result.responseText);               
    
                }
                }        
            });
        });

        function resetAddForm() 
        {
            $('#form_add')[0].reset();
        }

    </script>
