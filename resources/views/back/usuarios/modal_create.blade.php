<div>
    <div class="row">
        <div class="col-lg-7">
            <form method="POST" action="{{ route('back.usuarios.store') }}">
                @csrf
                <input type="hidden" name="password">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Agregar - Usuario</div>

                            <div class="col fs-5 text-end">
                                <img src="{{ asset('img/icons/person.png') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-2">
                            <label for="nombre" class="col-md-3 col-form-label is_required">Nombre :</label>

                            <div class="col-md-8">
                                <input id="nombre" name="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required autofocus>

                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="apellido" class="col-md-3 col-form-label is_required">Apellido :</label>

                            <div class="col-md-8">
                                <input id="apellido" name="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}" required>

                                @error('apellido')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="cedula" class="col-md-3 col-form-label is_required">Cédula :</label>

                            <div class="col-md-8">
                                <input id="cedula" name="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" value="{{ old('cedula') }}" required>

                                @error('cedula')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="email" class="col-md-3 col-form-label is_required">E-mail :</label>

                            <div class="col-md-8">
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="telefono" class="col-md-3 col-form-label">teléfono :</label>

                            <div class="col-md-8">
                                <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" >

                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="fecha_nac" class="col-md-3 col-form-label">Fecha Nac. :</label>

                            <div class="col-md-8">
                                <input id="fecha_nac" name="fecha_nac" type="date" class="form-control @error('fecha_nac') is-invalid @enderror" >

                                @error('fecha_nac')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="narrow" />

                        <div class="row">
                            <label for="is_propietario" class="col-md-4 col-form-label">Propietario ?</label>

                            <div class="col-md-3">
                                <select class="form-select" name="is_propietario" id="is_propietario">
                                    <option value="0" @if (old('is_propietario') == '0') selected @endif>No</option>
                                    <option value="1" @if (old('is_propietario') == '1') selected @endif>Si</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-secondary text-white btn-sm" href="{{ route('back.usuarios.index') }}"" role=" button" tabindex="-1">
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
                        <li>Click boton <strong>Agregar</strong> para Grabar.</li>
                        <li> El boton <a class="btn btn-secondary text-white btn-sm" href="" >
                            <i class="bi bi-arrow-left-short"></i>
                        </a> Es para Cancelar </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>