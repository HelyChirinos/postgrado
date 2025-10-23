<div>
    <div class="row">
        <div class="col-lg-7">
            <form method="POST" action="{{ route('back.paginas.store') }}">
                @csrf
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Agregar - Rango de Páginas</div>

                            <div class="col fs-5 text-end">
                                <img src="{{ asset('img/icons/person.png') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row mb-2">
                            <label for="paginas" class="col-md-4 col-form-label is_required text-end">Título :</label>

                            <div class="col-md-8">
                                <input id="paginas" name="paginas" type="text" placeholder="Rango de Páginas" class="form-control @error('paginas') is-invalid @enderror"  required >

                                @error('paginas')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row ">
                            <label for="limite" class="col-md-4 col-form-label is_required text-end">Limite :</label>

                            <div class="col-md-8">
                                <input id="limite" name="limite" type="text" placeholder="Limite Max. de páginas " class="form-control @error('limite') is-invalid @enderror"  required >

                                @error('limite')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="narrow" />

                        <div class="row mb-2">
                            <label for="costo_v" class="col-md-4 col-form-label is_required text-end">Al Venezolano :</label>

                            <div class="col-md-8">
                                <input id="costo_v" name="costo_v" type="numeric" placeholder="Monto en Divisas" 
                                data-type="currency" class="form-control @error('costo_v') is-invalid @enderror" required >

                                @error('costo_v')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="costo_e" class="col-md-4 col-form-label is_required text-end">Al Extranjero :</label>

                            <div class="col-md-8">
                                <input id="costo_e" name="costo_e" type="numeric" placeholder="Monto en Divisas" 
                                data-type="currency" class="form-control @error('costo_e') is-invalid @enderror" required >

                                @error('costo_e')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-secondary text-white btn-sm" href="{{ route('back.aranceles.index') }}" role=" button" tabindex="-1">
                                    <i class="bi bi-arrow-left-short"></i>
                                </a>
                            </div>

                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary text-white btn-sm">Agregar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
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
                        <li>Todos los montos son en Dolares ($).</li>
                        <li>Click boton <strong>Agregar</strong> para Grabar.</li>
                        <li> El boton <a class="btn btn-secondary text-white btn-sm" href="" >
                            <i class="bi bi-arrow-left-short"></i>
                        </a> Es para Cancelar </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="{{URL::asset('js/currency_ve.js') }}"></script>

</div>