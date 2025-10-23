@extends('layouts.back')

@section('title')
    &vert; Reportes
@endsection




@section('content')
<div class="card mb-2">
    <div class="card-header text-white bg-primary text-center fs-5 d-print-none">
        <div class="row">
            <div class="col fs-5 text-center">Reportes </div>
        </div>
    </div>

    <div class="card-body ">

        <div class="row">
            <!-- Reportes Mensuales -->   
        <div class="col-4">
            <div class="card mb-2">
                <div class="card-header d-print-none">
                    <div class="row">
                        <div class="col fs-5 text-center">Mensuales</div>
                    </div>
                </div>
            
                <div class="card-body">
                    <form id="form_mensual" action="">
                        <table id="mensual" class="table table-bordered table-striped table-sm table-hover dataTable reporte" style="width: 80%">
                            <tbody>
                                <tr>
                                    <td>
                                        Mes:  
                                        <input type="month" id="mensual" name="periodo" min="2024-01" required>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_resumen').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Reporte Resumen (Conciliación) Mes</p>
                                            <button id="r_resumen" type="submit" formaction="{{route('back.reportes.resumen.mes')}}" style="display: none"></button>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_mes').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Reporte de Recibos por Mes</p>
                                            <button id="r_mes" type="submit" formaction="{{route('back.reportes.recibos.mes')}}" style="display: none"></button>
                                    </td>
                                </tr> 
                                <tr>   
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_completo').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Resumen de Recibos Mensual <br> (Cierre de Mes)</p>
                                        <button id="r_completo" type="submit" formaction="{{route('back.reportes.recibos_completo')}}" style="display: none"></button>
                                    </td>
                                </tr>
                                <tr>    
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_constancias').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            
                                            </a>
                                        </div>
                                        <p>Cuadro Resumen Constancias-Mes</p>

                                        <button id="r_constancias" type="submit" formaction="{{route('back.reportes.constancias_mes')}}" style="display: none"></button>

                                    </td>
                                </tr>
                                <tr>    
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_d_constancias').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            
                                            </a>
                                        </div>
                                        <p>Reporte Detalle Constancias por Mes</p>

                                        <button id="r_d_constancias" type="submit" formaction="{{route('back.reportes.recibos_constancias')}}" style="display: none"></button>

                                    </td>
                                </tr>

                                <tr>    
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_arancel').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            
                                            </a>
                                        </div>
                                        <p>Reporte de Aranceles por Mes</p>

                                        <button id="r_arancel" type="submit" formaction="{{route('back.reportes.recibos_aranceles')}}" style="display: none"></button>

                                    </td>
                                </tr>

                                <tr>    
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('r_matricula').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            
                                            </a>
                                        </div>
                                        <p>Reporte de Matrícula por Mes</p>
                                        <button id="r_matricula" type="submit" formaction="{{route('back.reportes.recibos_matriculas')}}" style="display: none"></button>

                                    </td>
                                </tr>
    
                            </tbody>
                        </table>
                    </form>    
                </div> 
            </div> <!-- fin Card -->    
             
        </div>
            <!-- Reportes Periodos -->   
        <div class="col-4">
            <div class="card mb-2">
                <div class="card-header d-print-none">
                    <div class="row">
                        <div class="col fs-5 text-center">Por Período</div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form_periodo" action="">
                        <table id="periodo" class="table table-bordered table-striped table-sm table-hover dataTable reporte" style="width: 80%">
                            <tbody>
                                <tr>
                                    <td>
                                        <span>Desde:</span>
                                        <input type="date" id="desde" name="desde" required>
                                        <span>Hasta:</span>
                                        <input type="date" id="hasta" name="hasta" required>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="boton">
                                            
                                            <a href="javascript:{}" onclick="document.getElementById('r_periodo').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Reporte de Recibos por Período</p>
                                            <button id="r_periodo" type="submit" formaction="{{route('back.reportes.recibos.periodo')}}" style="display: none"></button>
                                    </td>
                                </tr> 
                                <tr>   
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('peri_completo').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Resumen de Recibos Periodo <br> (Arancel - Matrícula)</p>
                                        <button id="peri_completo" type="submit" formaction="{{route('back.reportes.recibos_completo_periodo')}}" style="display: none"></button>
                                    </td>
                                </tr>
                                <tr>    
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('peri_arancel').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Reporte Aranceles Período</p>
                                        <button id="peri_arancel" type="submit" formaction="{{route('back.reportes.aranceles_periodo')}}" style="display: none"></button>
              
                                    </td>
                                </tr>
                                <tr>    
                                    <td>
                                        <div class="boton">
                                            <a href="javascript:{}" onclick="document.getElementById('peri_matricula').click();">
                                                <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                            </a>
                                        </div>
                                        <p>Reporte de Matrícula Período</p>
                                        <button id="peri_matricula" type="submit" formaction="{{route('back.reportes.matriculas_periodo')}}" style="display: none"></button>
                   
                                    </td>
                                </tr>
    
                            </tbody>
                        </table>
                    </form>    
                </div> 
            </div> <!-- fin Card -->    
        </div> 
         <!-- Reportes Generales -->         
        <div class="col-4">
            <div class="card mb-2">
                <div class="card-header d-print-none">
                    <div class="row">
                        <div class="col fs-5 text-center">Generales</div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="Generales" class="table table-bordered table-striped table-sm table-hover dataTable reporte" style="width: 80%">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="boton">
                                        
                                        <a href="javascript:{}" onclick="document.getElementById('r_periodo').click();">
                                            <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                        </a>
                                    </div>
                                    <p>Listado de Recibos Anulados</p>
                                        <button id="r_periodo" type="submit" formaction="{{route('back.reportes.recibos.periodo')}}" style="display: none"></button>
                                </td>
                            </tr> 
                            <tr>   
                                <td>
                                    <div class="boton">
                                        <a href="javascript:{}" >
                                            <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                        </a>
                                    </div>
                                    <p>Listado de estudiantes Egresados</p>
                                </td>
                            </tr>
                            <tr>   
                                <td>
                                    <div class="boton">
                                        <a href="javascript:{}" >
                                            <i class="fa-light fa-print fa-xl" style="color: white"></i>
                                        </a>
                                    </div>
                                    <p>Listado de Estudiantes por Especialidad-Activos</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>    
        </div>
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
        width: 40px;
        height: 40px;
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
