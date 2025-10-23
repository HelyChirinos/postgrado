<div>
    <div class="row">
        <div class="col-lg-7">
            <form method="POST" action="{{ route('back.programas.update', [$programa->id]) }}"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Actualizar - Programas</div>

                            <div class="col fs-5 text-end">
                                <img src="{{ asset('img/icons/person.png') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <label for="programa" class="col-md-3 col-form-label">Programa :</label>

                            <div class="col-md-8">
                                <input id="nombre" name="nombre" type="text"  class="form-control @error('programa') is-invalid @enderror" value="{{$programa->programa}}" required >

                                @error('programa')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
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
                        <li>Click boton <strong>Actualizar</strong> para Grabar.</li>
                        <li> El boton <a class="btn btn-secondary text-white btn-sm" href="" >
                            <i class="bi bi-arrow-left-short"></i>
                        </a> Es para Cancelar </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>