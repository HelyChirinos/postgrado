<div>
    <form id="form_update" >
        @csrf
        @method('PUT')
        <input type="hidden" id="id_update" name="id" value="{{$divisa->id}}">
    <div class="row">
        <div class="col-lg-7">

              
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Actualizar -Divisa</div>

                            <div class="col fs-5 text-end">
                                <img src="{{ asset('img/icons/person.png') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <label for="fecha" class="col-md-3 col-form-label">Fecha:</label>

                            <div class="col-md-8">
                                <input id="fecha" name="fecha" type="date" 
                                class="form-control @error('fecha') is-invalid @enderror" 
                                value="{{$divisa->fecha->toDateString()}}" required >

                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="narrow" />

                        <div class="row mb-2">
                            <label for="dolar" class="col-md-3 col-form-label">Dolar $ :</label>

                            <div class="col-md-8">
                                <input id="dolar" name="dolar" type="text" data-type="currency"
                                class="form-control @error('dolar') is-invalid @enderror" 
                                value="{{formatMoney($divisa->dolar)}}"  required >
                            </div>
                        </div>
                        <hr class="narrow" />

                        <div class="row mb-2">
                            <label for="euro" class="col-md-3 col-form-label">Euro €:</label>

                            <div class="col-md-8">
                                <input id="euro" name="euro" type="text" data-type="currency"
                                class="form-control @error('euro') is-invalid @enderror" 
                                value="{{formatMoney($divisa->euro)}}" required >
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-secondary text-white btn-sm" href="{{ route('back.divisas.index') }}"" role=" button" tabindex="-1">
                                    <i class="bi bi-arrow-left-short"></i>
                                </a>
                            </div>

                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary text-white btn-sm">Actualizar</button>
                            </div>
                        </div>
                    </div>

                </div>
         
        </div>

        <div class="col-lg-5">

            <div id="help_card" class="card mb-2" style="display: block">
                <div class="card-header bg-info text-white">
                    <div class="row">
                        <div class="col">Ayuda</div>

                        <div class="col fs-5 text-end"><i class="bi bi-question"></i></div>
                    </div>
                </div>

                <div class="card-body">
                    <ul>
                        <li>Los Campos con (<span class="is_required"></span> ) son obligatorios.</li>
                        <li>Click boton <strong>Actualizar</strong> para Grabar.</li>
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
<script type="text/javascript" src="{{URL::asset('js/currency_ve.js') }}"></script>
<script type="module">

    $('#form_update').submit(function(e) 
        {
            e.preventDefault();
            let datos = $('#form_update').serialize();
            let id = $('#id_update').val();
            $.ajax({
                url: "{{ route('back.divisas.update', 'id') }}".replace("id", id),
                method: 'post',
                data:  datos,
                success: function(result)
                {
                        $("#help_card").css("display", "block");
                        $("#error_card").css("display", "none");
                        $('#lista_error').html('');
                        bootbox.hideAll();
                        const currentPath = window.location.pathname;
                        console.log(currentPath);   //   back/divisas  
                        if (currentPath=='/back/divisas'){
                            var url_mensaje = '{{ route("back.divisas.message","Actualizar") }}';
                            window.location.href=url_mensaje;   
                        }
                                           
                },
                error: function(result) 
                {
                  if (result.status == 422) {
    
                      $("#help_card").css("display", "none");
                      $('#form_update').find(".print-error-msg").find("ul").html('');
                      $('#form_update').find(".print-error-msg").css('display','block');
                      $.each( result.responseJSON.errors, function( key, value ) {
                            $('#form_update').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                      });
                  } else {
                     alert('Tipo de Error:' + result.status+' '+result.responseText);
    
                  }
                }        
            });
        });
    
    
</script>