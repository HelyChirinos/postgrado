@extends('layouts.back')

@section('title')
    &vert; Reportes
@endsection




@section('content')
<div class="card mb-2">
    <div class="card-header d-print-none">
        <div class="row">
            <div class="col fs-5 text-center">Reportes</div>
        </div>
    </div>

    <div class="card-body ">

        <div class="row">
        <div class="col-2">
 
        </div>
        <div class="col">
            <table class="table table-bordered table-striped table-sm table-hover dataTable reporte" style="width: 80%">
                <tbody>
                    <tr >
                        <td >
                            <form id="form_recibo" action="{{route('back.reportes.recibos.mes')}}">
                            <div class="boton" >
                                
                                <a  href="javascript:{}" onclick="document.getElementById('r_mes').click();">
                                    <i class="fa-light fa-print fa-4x" style="color: white" ></i>
                                </a>
                            </div>
                             <p>Reporte de Recibos por Mes</p>
                                <input type="month" id="periodo" name="periodo" min="2024-01" required>
                                <button id="r_mes" type="submit" style="display: none"></button>
                            </form>
                        </td>
                        <td >
                            <form id="form_recibo_completo" action="{{route('back.reportes.recibos_completo')}}">
                            <div class="boton" >
                                
                                <a  href="javascript:{}" onclick="document.getElementById('r_completo').click();">
                                    <i class="fa-light fa-print fa-4x" style="color: white" ></i>
                                </a>
                            </div>
                             <p>Resumen de Recibos Periodo <br> (Arancel - Matrícula)</p>
                                <input type="month" id="periodo" name="periodo" min="2024-01" required>
                                <button id="r_completo" type="submit" style="display: none"></button>
                            </form>
                        </td>
                        <td>
                            <div class="boton">
                                <a href="">
                                    <i class="fa-light fa-print fa-4x" style="color: white" ></i>
                                
                                </a>
                            </div>
                        </td>
                        <td  >
                            <div class="boton">
                                <a href="{{route('back.reportes.prueba')}}" target="_blank" >
                                    <i class="fa-light fa-print fa-4x" style="color: white" ></i>
                                </a>
                            </div>
                            <p>Reporte de Prueba</p>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-2"></div>
    </div>
    </div>
</div>

@endsection

@push('styles')

<style type="text/css">

    .reporte td { text-align: center;}

    .reporte .boton { 
        text-align: center;
        color:red;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .reporte a {
        background-color: hsl(0, 2%, 16%);
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid #0ebac5;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 1em;
        transition: all 500ms ease;
    }

    .reporte a:hover {
        box-shadow: 0 0 20px #0ebac5;
    }

    .reporte a:hover ion-icon{
        color: #0ebac5;
        box-shadow: 0 0 12px #0ebac5;
    }

</style>
@endpush    
