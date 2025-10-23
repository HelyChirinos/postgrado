<div>
   <form id="form_add" >  
    <div class="row">
        <div class="col-lg-6">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Datos del Estudiante</div>

                            <div class="col fs-5 text-end">
                                <img src="{{ asset('img/icons/person.png') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <input type="hidden" id="ruta" name="ruta" value="estudiante">
                        <div class="row mb-2">
                            <label for="doc" class="col-md-3 col-form-label is_required">Documento:</label>
                            <div class="col-md-3">
                                <select class="form-select" name="tipo_doc" id="tipo_doc" required>
                                    <option value="CI" >C.I.</option>
                                    <option value="CE" >C.E.</option>
                                    <option value="PS" >Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input id="no_doc" name="no_doc" type="text" placeholder="Número Documento." class="form-control @error('no_doc') is-invalid @enderror" value="{{ old('no_doc') }}" required>

                                @error('no_doc')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>     

                        <div class="row mb-2">
                            <label for="nombres" class="col-md-3 col-form-label is_required">Nombres :</label>

                            <div class="col-md-9">
                                <input id="nombres" name="nombres" type="text" class="form-control  @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="apellidos" class="col-md-3 col-form-label is_required">Apellidos :</label>

                            <div class="col-md-9">
                                <input id="apellidos" name="apellidos" type="text" class="form-control  @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" required>
                            </div>
                        </div>

                        <hr class="narrow" />

                        <div class="row mb-2">
                            <label for="email" class="col-md-3 col-form-label ">E-mail :</label>

                            <div class="col-md-9">
                                <input id="email" name="email" type="email" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="direccion" class="col-md-3 col-form-label">Dirección:</label>

                            <div class="col-md-9">
                                <input id="direccion" name="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" >

                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="telefono" class="col-md-3 col-form-label">teléfono :</label>

                            <div class="col-md-9">
                                <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" >
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        @php $lugar = getcwd(); @endphp
                        <div class="row">
                            <div class="col">
                                @if ($lugar=='back/estudiantes')
                                    <a class="btn btn-secondary text-white btn-sm" href="{{ route('back.estudiantes.index') }}" role=" button" tabindex="-1">
                                        <i class="bi bi-arrow-left-short"></i>
                                    </a>
                                @else
                                    <a class="btn btn-secondary text-white btn-sm" href="{{ route('back.recibos.index') }}" role=" button" tabindex="-1">
                                        <i class="bi bi-arrow-left-short"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary text-white btn-sm">Agregar</button>
                            </div>
                        </div>
                    </div>

                </div>

        </div>

        <div class="col-lg-6">
        
            <div id="academico" class="card mb-2">
                <div class="card-header text-white">
                    <div class="row">
                        <div class="col">Datos Académicos</div>
                    </div>
                </div>
                <div class="card-body">     
                    <div class="row mb-3">         
                        <div class="col-md-6">
                            <label for="programa" class="form-label">Programa</label>
                            <select name="programa" id="programas" onchange="cargarMencion(this.value)" class="form-select" required>
                                <option value="">Programa? ...</option>
                                @foreach ($programas as $programa)
                                        <option value="{{ $programa->id }}">{{ $programa->programa }}</option>
                                @endforeach
                            </select>                    
                        </div>
                        <div class="col-md-6">
                            <label for="mencion" class="form-label">Mencion</label>
                            <select class="form-select" name="mencion" id="mencion" required>

                            </select>
                        </div>
                    
                    </div>
                    <div class="row mb-2">
                        <label for="cohorte" class="col-md-5 col-form-label text-end">Cohorte de Ingreso :</label>

                        <div class="col-md-3">
                            <input id="cohorte" name="cohorte" type="text" class="form-control" >
                        </div>
                    </div>                       
                </div>        
            </div>

            <div id="help_card" class="card mb-2">
                <div class="card-header bg-info text-white">
                    <div class="row">
                        <div class="col">Ayuda</div>

                        <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                    </div>
                </div>

                <div class="card-body">
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
   </form>   
</div>

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


<script type="module">

    $('#form_add').submit(function(e) 
        {
            e.preventDefault();
            let datos = $('#form_add').serialize();
            $.ajax({
                url: "{{ route('back.estudiantes.store') }}",
                method: 'post',
                data:  datos,
                success: function(result)
                {
                        $("#help_card").css("display", "block");
                        $("#error_card").css("display", "none");
                        $('#lista_error').html('');
                        bootbox.hideAll();
                        const currentPath = window.location.pathname;
                        console.log(currentPath);  
                        if (currentPath=='/back/estudiantes'){
                            var url_mensaje = '{{ route("back.estudiantes.message","Nuevo") }}';
                            window.location.href=url_mensaje;   
                        }
                        if (currentPath=='/back/recibos'){
                            let id_estudiante = result.id;
                            
                            var url = "{{ route('back.recibos.create', 'id') }}".replace("id", id_estudiante);
                            window.location.href=url;   
                        }
                                           
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
                     alert('Tipo de Error:' + result.status+' '+result.responseText);
    
                  }
                }        
            });
        });
    
    
    </script>