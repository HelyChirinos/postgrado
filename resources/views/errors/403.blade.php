@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('code', '403')

@section('message')
    <h4 class="card-text">No esta Autorizado para ingresar a esta página.</h4>
    <hr />
    <ul>
        <li>Click en el botón
            <button class="btn btn-success btn-sm" type="button" tabindex="-1" disabled>
                <i class="bi bi-house-fill"></i>
            </button>
            para salir del Sistema,
        </li>
        <br />
        <li>O click en el Icono
            <img src="{{ asset('img/general/helpdesk-035.png') }}" class="img-fluid" alt="KREAWEB.be" />
            para contactar al Administrador.
        </li>
    </ul>
@endsection
