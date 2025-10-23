<div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-center">DATOS DEL ESTUDIANTE</div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row mb-2">
                         <div class="col-md-2">
                            <input id="tipo_doc" name="tipo_doc" type="text"  class="form-control" value="{{ $estudiante->tipo_doc}}" readonly>
                        </div>
                        <div class="col-md-3">
                            <input id="no_doc" name="no_doc" type="text" class="form-control" value="{{ $estudiante->no_doc}}" readonly>
                        </div>
                        <div class="col-md-7">
                            <input id="nombre" name="nombre" type="text" class="form-control" value="{{ $estudiante->nombre}}" readonly>
                        </div>
                    </div>     
              
                    <hr class="narrow" />
                    <div class="row mb-2">
                        <label for="programa" class="col-md-2 col-form-label" style="padding-right: 0px;">Prog.:</label>

                        <div class="col-md-4">
                            <input  type="text" class="form-control" value="{{ $estudiante->programa->programa}}" readonly>
                        </div>
                        <label for="mencion" class="col-md-2 col-form-label">Menc.:</label>

                        <div class="col-md-4">
                            <input  type="text" class="form-control" value="{{ $estudiante->mencion->mencion}}" readonly>
                        </div>                                
                    </div>     

                    <hr class="narrow" />


                </div>

            </div>
        </div>

        <div class="col-lg-5">

            <div id="help_card" class="card mb-2" style="display: block">
                <div class="card-header text-white">
                    <div class="row">
                        <div class="col text-center">DATOS DE LA SOLICITUD</div>
          
                    </div>
                </div>

                <div class="card-body">
                   <table class="table table-bordered table-striped table-sm table-hover dataTable">
                        <thead>
                            <tr>
                                <td class="text-center">
                                    CODIGO
                                </td>
                                <td class="text-center">
                                    MONTO
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    {{$codigo}}
                                </td>
                                <td class="text-center">
                                {{round(abs($dif_Bs),2)}} Bs.
                                </td>
                            </tr>
                        </tbody>
                   </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col text-end">
                            <a class="btn btn-primary text-white btn-sm" href="{{ route('back.recibos.index') }}" role=" button" tabindex="-1">
                              Continuar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
         
        </div>
    </div>

</div>

