
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


<div class="card">

    <div class="card-header header-primary text-center fs-5">Recibo Nº {{$no_recibo}} </div> 
        {{--                              DATOS ESTUDIANTE                          --}}
        <div class="row">

            <div class="col-lg-12">

                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-center">DATOS DEL ESTUDIANTE</div>
                            </div>
                        </div>
    
                        <div class="card-body">
     
                            <div class="row">
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
                    
                            <div class="row">
                                <label for="programa" class="col-md-2 col-form-label" style="padding-right: 0px;">Programa:</label>
    
                                <div class="col-md-4">
                                    <input  type="text" class="form-control" value="{{ $estudiante->programa->programa}}" readonly>
                                </div>
                                <label for="mencion" class="col-md-2 col-form-label">Mención:</label>
    
                                <div class="col-md-4">
                                    <input  type="text" class="form-control" value="{{ $estudiante->mencion->mencion}}" readonly>
                                </div>                                
                            </div>     
                        </div>

                    </div>
               
            </div>
        {{--                               DATOS RECIBO                           --}}    
            <div class="col-lg-12">

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
                                     </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($depositos as $item)
                                        @php $i=$i+1; @endphp
                                        <tr>
                                            <td>{{$i}}</td>    
                                            <td>{{$item->numero}}</td>
                                            <td>{{formatFecha($item->fecha)}}</td>
                                            <td style="text-align: right">{{formatMoney($item->monto)}}</td>
                                        
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right" > TOTAL</td>
                                        <td style="text-align: right">{{formatMoney($total_pago_Bs)}}</td>
                                       
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
                        <span class="btn-label"><i class="fa fa-remove"></i></span>Cerrar</button>
                </div>
                <div  id="imprimir_recibo" class="col text-end" >
                    <button type="submit" name="accion" value="generar" onclick="imprimir()" class="btn btn-labeled btn-success btn-sm">
                        <span class="btn-label"><i class="fa fa-print"></i></span>Imprimir Recibo</button>
                </div>
                
            </div>
        
        </div>

</div>

<script>

    function cancelar() {
        bootbox.hideAll();
    }
    function imprimir() {
        let id = '{{$id_recibo}}';
        console.log(id);
        let url= "{{ route('back.recibos.Pdf', 'id') }}".replace("id", id);
            console.log(url);
            let newTab = document.createElement('a');
            newTab.href = url;
            newTab.target = "_blank";
            newTab.click();

    }

</script>



