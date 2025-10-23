<div>
    <form method="POST" action="{{ route('back.cohortes.update', [$cohorte->id]) }}">
        @csrf
        @method('PUT')
    <div class="row">
        <div class="col-lg-7">

                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Actualizar - COHORTE</div>

                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row mb-2">
                            <label for="cohorte" class="col-md-3 col-form-label is_required">Cohorte :</label>

                            <div class="col-md-7">
                                <input id="cohorte" name="cohorte" type="text"  class="form-control " value="{{$cohorte->cohorte}}" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="modalidad" class="col-md-3 col-form-label">Modalidad: </label>
    
                            <div class="col-md-7">
                                <select class="form-select" name="modalidad" id="modalidad">
                                    <option value="">Seleccione</option>
                                    <option value="TRIMESTRAL"  @if ($cohorte->modalidad =="TRIMESTRAL" ) selected @endif>Trimestral</option>
                                    <option value="SEMESTRAL" @if ($cohorte->modalidad =="SEMESTRAL" ) selected @endif>Semestral</option>
                                    <option value="ANUAL" @if ($cohorte->modalidad =="ANUAL" ) selected @endif>Anual</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="row mb-2">
                            <label for="Inicio" class="col-md-3 col-form-label is_required">Inicio :</label>
    
                            <div class="col-md-7">
                                <input name="inicio" type="month"  class="form-control" value="{{$cohorte->inicio}}" required>
                            </div>
                        </div>
    
                        <div class="row mb-2">
                            <label for="termino" class="col-md-3 col-form-label is_required">Termino :</label>
    
                            <div class="col-md-7">
                                <input name="termino" type="month"  class="form-control" value="{{$cohorte->termino}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-secondary text-white btn-sm" href="{{ route('back.tablas.index') }}" role=" button" tabindex="-1">
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

            <div class="card mb-2">
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
        </div>
    </div>
</form>  
</div>