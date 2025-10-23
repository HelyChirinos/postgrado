<div>
    <form id="form_add" >
    @csrf
    <div class="row">
        <div class="col-lg-7">

                <input type="hidden" name="password">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Agregar - Divisas</div>

                            <div class="col fs-5 text-end">
                                <img src="{{ asset('img/icons/person.png') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <label for="fecha" class="col-md-3 col-form-label">Fecha:</label>

                            <div class="col-md-8">
                                <input id="fecha" name="fecha" type="date" class="form-control" required >

                            </div>
                        </div>
                        <hr class="narrow" />

                        <div class="row mb-2">
                            <label for="dolar" class="col-md-3 col-form-label">Dolar $ :</label>

                            <div class="col-md-8">
                                <input id="dolar" name="dolar" type="text" data-type="currency" 
                                class="form-control @error('dolar') is-invalid @enderror" required >
                            </div>
                        </div>
                        <hr class="narrow" />

                        <div class="row mb-2">
                            <label for="euro" class="col-md-3 col-form-label">Euro €:</label>

                            <div class="col-md-8">
                                <input id="euro" name="euro" type="text" data-type="currency" 
                                class="form-control @error('euro') is-invalid @enderror" required >
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
                                <button type="submit" class="btn btn-primary text-white btn-sm">Agregar</button>
                            </div>
                        </div>
                    </div>

                </div>

        </div>

        <div class="col-lg-5">

            <div id="help_card" class="card mb-2" style="display: block;">
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
<script type="text/javascript" src="{{URL::asset('js/currency_ve.js') }}"></script>
<script type="module">
 
    $('#form_add').submit(function(e) 
    {
        e.preventDefault();
        let datos = $('#form_add').serialize();
        $.ajax({
            url: "{{ route('back.divisas.store') }}",
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
                        var url_mensaje = '{{ route("back.divisas.message","Nuevo") }}';
                        window.location.href=url_mensaje;   
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