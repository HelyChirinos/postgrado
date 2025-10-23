    <div class="container">
        @php
          
        @endphp
        <div class="row">
            <div class="card mb-2">
                <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                    <div class="row mb-2 mt-2">

                        <table id="sqltable" class="styled-table table-bordered mb-3 mt-0" style="width: 100%">
                            <thead >
                                <tr class="titulo">
                                    <th></th>
                                    <th  colspan="3" style="text-align: center; border-top: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                                        DEPOSITOS EN TRANSITO</th>
                                </tr>
                                <tr class="titulo">
                                    <th></th>
                                    <th  colspan="3" style="text-align: center; border-bottom: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                                        PERIODO: {{$periodo}}</th>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">F.Operación</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">F.valor</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Referencia</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Descripción</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Importe Bs.</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transito as $item )
                                    <tr>
                                       <td >{{ formatFecha($item->fecha_operacion)}}</td>
                                       <td>{{ formatFecha($item->fecha_valor)}}</td>
                                       <td style="text-align: center;">{{ $item->referencia}}</td>
                                       <td>{{ $item->descripcion}}</td>
                                       <td  data-format="0,00" style="text-align: right;">{{ $item->abono}}</td>
                                          
                                    </tr>
                                @empty
                                    <tr>
                                        <td></td><td></td><td>Sin Información</td><td></td><td></td>
                                    </tr>
                                    
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td><td></td><td></td>
                                    <td style="border: solid black; text-align: right">Total en Transito</td>
                                    <td style="border: solid black; text-align: center; font-weight: bold;">{{($total)}}</td>
                                </tr>

                            </tfoot>    
                        </table> 
                    </div>

                </div>    
            </div> 
        </div>
    </div>




