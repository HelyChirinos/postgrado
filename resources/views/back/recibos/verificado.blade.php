@extends('layouts.back')

@section('title')
    &vert; Recibos
@endsection

@section('content')

<style>

.styled-table {
    border-radius: 10px;
    border-spacing: 0;
    border-collapse: collapse;
    margin-top: 0px;
    margin-bottom: 10px;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}


.styled-table thead tr {
    background-color: #009879; 
    color: #ffffff;
    text-align: left;
}

.styled-table thead tr.titulo {
    background-color: #274D8F;
    color: #ffffff;
    text-align: center;

}

.styled-table th,
.styled-table td {
    padding: 8px 8px;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

.styled-table tfoot tD.active-row {
    border-bottom: 2px solid #009879;
    border-top: 2px solid #009879;
    font-weight: bold;

}

.styled-table tfoot tD.escena-row {
 
    text-align: center;
    font-weight: bold;

}

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
$dif_Bs = round($total_pago_Bs,2)-round($total_costo_Bs,2);
$dif_dolar = round($total_pago_dolar,2)-round($total_costo_dolar,2);
@endphp
<div class="card">
    <form id="form_recibo" >
        @csrf
    <div class="card-header header-primary text-center fs-5">Datos Recibo </div> 

        <div class="row">
            <div class="col-lg-5">

                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-center">DATOS DEL ESTUDIANTE</div>
                            </div>
                        </div>
    
                        <div class="card-body">
     
                            <div class="row mb-2">
                                {{-- DATOs OCULTOS --}}
                                <input type="hidden" name="estudiante_id" value="{{ $estudiante->id}}" >
                                <input type="hidden" name="tmp_recibo_id" value="{{ $tmp_recibo->id}}" >
                                <input type="hidden" name="dif_Bs" value="{{$dif_Bs}}">  
                                <input type="hidden" name="total_arancel" value="{{$total_arancel}}">
                                <input type="hidden" name="total_matricula" value="{{$total_matricula}}">  

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
                                <label for="programa" class="col-md-2 col-form-label" style="padding-right: 0px;">Programa:</label>
    
                                <div class="col-md-4">
                                    <input  type="text" class="form-control" value="{{ $estudiante->programa->programa}}" readonly>
                                </div>
                                <label for="mencion" class="col-md-2 col-form-label">Mención:</label>
    
                                <div class="col-md-4">
                                    <input  type="text" class="form-control" value="{{ $estudiante->mencion->mencion}}" readonly>
                                </div>                                
                            </div>     
    
                            <hr class="narrow" />
    
    
                        </div>

                    </div>
                    <div id="escenario_card" class="card mb-2 print-error-msg">
                        <div   class="card-header text-white" style="background: #274D8F;">
                            <div class="row">
                                <div class="col text-center">ESCENARIO</div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0px;">
                            <div class="row">
                                <table class="styled-table tex-center">
                                    <tfoot>
                                    <td class="escena-row" style="{{($dif_Bs>=0 ? 'color:green' :
                                        'color:#DA2B06')}}" >{{formatMoney(abs($dif_Bs))}} Bs.</td>
                                    <td class="escena-row" style="{{($dif_Bs>=0 ? 'color:green' :
                                        'color:#DA2B06')}}">{{formatMoney(abs($dif_dolar))}} $</td>
                                    </tfoot>    
                                </table>
                            </div>
                         

                                @if ($dif_Bs < 0 )
                                    <ul id="deudor">
                                        @if (abs($dif_Bs) > 1 )
                                            <li> No cumple requisito para Petitorio </li>
                                        @else
                                            <li> Click en botón "Petitorio" para realizar solicitud </li>
                                        @endif
                                        <li> Quitar solicitudes ( Botón Regresar) </li> 
                                        <li> Cancelar operación  ( Botón Cancelar) </li>
                                @endif
                                @if ($dif_Bs > 0 )    
                                    <ul id="acreedor">
                                        <li> Para Autorizar monto Click en botón "Aprobado" y culminar proceso</li>
                                        <li> Consultar si el monto alcanza para otra Solicitud ( Botón Sugerencia) </li> 
                                        <li> Realizar otra solicitud ( Botón Regresar) </li>
                                        <li> Cancelar operación  ( Botón Cancelar)</li>
                                    </ul>
                                @endif
                                @if ($dif_Bs == 0 )
                                    <ul id="exacto">
                                        <li> Cick en botón "Generar Recibo" para culminar </li>
                                        <li> Cancelar operación  ( Botón Cancelar)</li>
                                    </ul>                                 
                                @endif
                             
                        </div>

                       
                        
                    </div>     
               
            </div>
    
            <div class="col-lg-7">

                <div id="Solicitudes" class="card mb-1"  >

                    <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                        <div class="row mb-1">
                            <table class="styled-table" style="width: 100%">
                                <thead >
                                    <tr class="titulo">
                                        <th colspan="4">SOLICITUDES</th>
                                     </tr>
                                    <tr>
                                        <th scope="col">TIPO</th>
                                        <th scope="col">CONCEPTO</th>
                                        <th scope="col" width="15%" style="text-align: right">MONTO BS.</th>
                                        <th scope="col" width="15%" style="text-align: right">MONTO $</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($a_solicitud as $item)
                                    <tr>
                                        <td>{{$item->tipo}}</td>
                                        <td>{{$item->nombre}}</td>
                                        <td style="text-align: right">{{formatMoney($item->costo_Bs)}}</td>
                                        <td style="text-align: right">{{formatMoney($item->costo_dolar)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: right" > TOTAL</td>
                                        <td style="text-align: right">{{formatMoney($total_costo_Bs)}}</td>
                                        <td style="text-align: right">{{formatMoney($total_costo_dolar)}}</td>
                                    </tr>
                                </tfoot>
                            </table>                     
                        </div>
                    </div>    
                </div> 
                <div id="Depositos" class="card mb-1"  >
                    <div class="card-body"  style="padding-top: 0px;">
                        <div class="row mb-1">
                            <table class="styled-table" style="width: 100%">
                                <thead >
                                    <tr class="titulo">
                                        <th colspan="5">DEPOSITOS</th>
                                     </tr>
                                    <tr>
                                        <th scope="col">ITEM</th>
                                        <th scope="col">NUMERO</th>
                                        <th scope="col">FECHA</th>
                                        <th scope="col"  width="15%" style="text-align: right">MONTO BS.</th>
                                        <th scope="col" width="15%" style="text-align: right">MONTO $</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($a_pagos as $item)
                                        @php $i=$i+1; @endphp
                                        <tr>
                                            <td>{{$i}}</td>    
                                            <td>{{$item->deposito}}</td>
                                            <td>{{formatFecha($item->fecha)}}</td>
                                            <td style="text-align: right">{{formatMoney($item->pago_Bs)}}</td>
                                            <td style="text-align: right">{{formatMoney($item->pago_dolar)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right" > TOTAL</td>
                                        <td style="text-align: right">{{formatMoney($total_pago_Bs)}}</td>
                                        <td style="text-align: right">{{formatMoney($total_pago_dolar)}}</td>
                                    </tr>
                                    <tr class="active-row">
                                        <td colspan="3" style="text-align: right" >DIFERENCIA</td>
                                        <td class="active-row" style="{{($dif_Bs>=0 ? 'text-align: right; color:green' :
                                         'text-align: right; color:#DA2B06')}}" >{{formatMoney(abs($dif_Bs))}}</td>
                                        <td class="active-row" style="{{($dif_Bs>=0 ? 'text-align: right; color:green' :
                                         'text-align: right; color:#DA2B06')}}">{{formatMoney(abs($dif_dolar))}}</td>
                                    </tr>
                                </tfoot>
                            </table>                     
                        </div>
                    </div>    
                </div>           
            </div>
        </div>
        {{--                               BOTONES                           --}}
        <div class="card-footer">
            <div class="row">
                <div class="col" class="col text-start">
                    <button type="button"  class="btn btn-labeled btn-danger text-white btn-sm" onclick="cancelar()">
                        <span class="btn-label"><i class="fa fa-remove"></i></span>Cancelar</button>
                </div>
                <div  id="petitorio" class="col text-center" style="display:none" >
                    <button type="button" class="btn btn-labeled btn-warning btn-sm" onclick="petitorio ()" >
                        <span class="btn-label"><i class="fa-regular fa-hands-praying"></i></span>Petitorio</button>
                </div>
                <div id='regresar' class="col text-center"  style="display:none" >
                    <button type="button"  class="btn btn-labeled btn-secondary btn-sm" onclick="goBack()">
                        <span class="btn-label"><i class="fa-regular fa-reply"></i></span>Regresar</button>
                </div>
        
                <div id="sugerencias" class="col text-center" style="display:none" >
                    <button type="button"  class="btn btn-labeled btn-info btn-sm" onclick="showSugerencias()" >
                        <span class="btn-label"><i class="fa-regular fa-face-thinking"></i></span>Sugerencias</button>
                </div>
        
                <div  id="generar_recibo" class="col text-end"  style="display:none" >
                    <button type="submit" name="accion" value="generar" class="btn btn-labeled btn-success btn-sm">
                        <span class="btn-label"><i class="fa fa-check"></i></span>Generar Recibo</button>
                </div>
                
                <div id="donacion" class="col text-end"  style="display:none" >
                    <button type="submit" name="accion" value="donar" class="btn btn-labeled btn-success btn-sm">
                        <span class="btn-label"><i class="fa fa-thumbs-up"></i></span> Aprobado</button>
                </div>
            </div>
        
        </div>

    </form>
</div>

<script>

    
    function goBack() {
        let id = "{{$tmp_recibo->id }}";
        var url_locate = "{{ route('back.recibos.goBack', 'id') }}".replace("id", id);
        console.log(url_locate);
        window.location.href = url_locate;

    }

    function cancelar() {
        var url_locate ="{{ route('back.recibos.index') }}";
        window.location.href = url_locate;

    }

    function showSugerencias () {
        let nac = "{{$estudiante->tipo_doc}}";
        let dif_Bs = "{{$dif_Bs}}";
        var url_locate ="{{ route('back.recibos.sugerencias') }}";
        $.ajax({
            method: 'GET',
            url: url_locate,
            data: {
                nac: nac,
                dif_Bs : dif_Bs
            },
            success: function(response) {
                bootbox.dialog({
                            locale: 'es',
                            title: 'SUGERENCIAS',
                            message: response,
                            size: 'lg',
                            onEscape: true,
                            backdrop: true
                        });
            },
            error: function(result) {
                alert('Tipo de Error:' + result.status+' '+result.responseText);
            }
        });
    }

    function petitorio () {
        let id_estudent = "{{$estudiante->id}}";
        let dif_Bs = "{{$dif_Bs}}";
        let recibo_id = "{{$tmp_recibo->id}}";
        var url_locate = "{{ route('back.recibos.petitorio') }}";
        $.ajax({
            method: 'post',
            url: url_locate,
            data: {
                id_estudent: id_estudent,
                dif_Bs : dif_Bs,
                recibo_id: recibo_id
            },
            success: function(response) {
                console.log('success');
                bootbox.dialog({
                            locale: 'es',
                            title: 'SOLICITUD PETITORIO',
                            message: response,
                            size: 'lg',
                            onEscape: true,
                            backdrop: true
                        });
            },
            error: function(result) {
                alert('Tipo de Error:' + result.status+' '+result.responseText);
            }
        });
    }   

</script>

<script type="module">
    $( document ).ready(function() {
        let dif_Bs = "{{$dif_Bs}}";
        console.log('DIF. BS: '+dif_Bs);
        if (dif_Bs>0){
            $('#sugerencias').show();
            $('#regresar').show();
            $('#donacion').show()
        }
        if (dif_Bs<0){
            if (Math.abs(dif_Bs)<1) {
                $('#petitorio').show();
            }
            $('#regresar').removeClass("text-center");
            $('#regresar').css('text-align', 'right');
            $('#regresar').show();
        }

        if (dif_Bs == 0){
         $('#generar_recibo').show();
        }
        

    });

</script>

<script type="module">

    $('#form_recibo').submit(function(e) 
        {
            e.preventDefault();
            let dif_Bs = "{{$dif_Bs}}";
            let datos = $('#form_recibo').serialize();
            if (dif_Bs>0){
                datos=datos+ "&accion=donar";
            }
            $.ajax({
                url: "{{ route('back.recibos.ajax_store') }}",
                method: 'post',
                data:  datos,
                success: function(result)
                {
                    let id = result.recibo_id;
                    console.log(id);
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.recibos.consulta', 'id') }}".replace("id", id),
                        success: function(response) {
                            bootbox.dialog({
                                locale: 'es',
                                scrollable: true,
                                title: 'Consulta Recibo',
                                message: response,
                                size: 'lg',
                                onHide: function(e) {
                                    var url_locate ="{{ route('back.recibos.index') }}";
                                    window.location.href = url_locate;                                    
                                },
                                onEscape: false,
                                backdrop: false
                            });
                        } //success
                    }); // ajax 


        
                },
                error: function(result) 
                {
                  alert('Tipo de Error:' + result.status+' '+result.responseText);
                }        
            });
        });
    
    
    </script>

@endsection

