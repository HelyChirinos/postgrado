@extends('layouts.back')

@section('title')
    &vert; Test
@endsection

<style>
.btn-label {
	position: relative;
	left: -12px;
	display: inline-block;
	padding: 6px 12px;
	background: rgba(0, 0, 0, 0.15);
	border-radius: 3px 0 0 3px;
}

.btn-labeled {
	padding-top: 0;
	padding-bottom: 0;
}

.btn {
	margin-bottom: 10px;
}


</style>

@php
    
@endphp

@section('content')
    <p>Use this page to test (new) features ...</p>

    <div class="container">
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul class="mb-0 p-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-12 py-5">
                <div class="card my-5">
                    <div class="card-header">
                       <h3>Laravel File Uploader</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="mb-3">
                                <label for="formFileLg" class="form-label">File input example</label>
                                <input name="file" class="form-control form-control-lg" id="formFileLg"
                                       type="file">
                            </div>
                            <div class="mb-3">
                                <button type="submit" value="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col" class="col text-start">
            <button type="button"  class="btn btn-labeled btn-danger text-white btn-sm" onclick="cancelar()">
                <span class="btn-label"><i class="fa fa-remove"></i></span>Cancelar</button>
        </div>
        <div  id="petitorio" class="col text-center" >
            <button type="button" class="btn btn-labeled btn-warning btn-sm" >
                <span class="btn-label"><i class="fa-regular fa-hands-praying"></i></span>Petitorio</button>
        </div>
        <div id='regresar' class="col text-center"  >
            <button type="button"  class="btn btn-labeled btn-secondary btn-sm" onclick="goBack()">
                <span class="btn-label"><i class="fa-regular fa-reply"></i></span>Regresar</button>
        </div>

        <div id="sugerencias" class="col text-center" >
            <button type="button"  class="btn btn-labeled btn-info btn-sm" onclick="showSugerencias()" >
                <span class="btn-label"><i class="fa-regular fa-face-thinking"></i></span>Sugerencias</button>
        </div>

        <div  id="generar_recibo" class="col text-end" >
            <button type="submit" name="accion" value="generar" class="btn btn-labeled btn-success btn-sm">
                <span class="btn-label"><i class="fa fa-check"></i></span>Generar Recibo</button>
        </div>
        
        <div id="donacion" class="col text-end" >
            <button type="submit" name="accion" value="donar" class="btn btn-labeled btn-success btn-sm">
                <span class="btn-label"><i class="fa fa-thumbs-up"></i></span> Donación</button>
        </div>
    </div>




@endsection


@push('scripts')
     {{-- DATATABLES LAPSOS --}}



    <script type="module">
        /* -------------------------------------------------------------------------------------------- */
        /* ------------------------------------------- */
        /* -------------------------------------------------------------------------------------------- */
    </script>
@endpush
