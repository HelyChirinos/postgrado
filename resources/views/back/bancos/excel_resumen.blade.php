    <div class="container">
        @php
            $sub_total_mas = $resumen_cierre->ingresos + $resumen_cierre->transito+$resumen_cierre->saldo_anterior;
            $sub_total_menos = $resumen_cierre->comisiones+$resumen_cierre->ingreso_anterior+$resumen_cierre->transferencias;
            $sub_total = $sub_total_mas-$sub_total_menos;
        @endphp
        <div class="row">
            <div class="card mb-2">
                <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                    <div class="row mb-2 mt-2">

                        <table id="sqltable" class="styled-table table-bordered mb-3 mt-0" style="width: 100%">
                            <thead >
                                <tr class="titulo">
                                    <th  colspan="3" style="text-align: center; border-top: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                                        CONCILIACION DE LOS INGRESOS RECAUDADOS</th>
                                </tr>
                                <tr class="titulo">
                                    <th  colspan="3" style="text-align: center; border-bottom: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                                        PERIODO: {{$periodo}} </th>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Concepto</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Monto Bs. (Más)</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Monto Bs. (Menos)</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: solid black;" >Saldo Anterior</td>
                                    <td style="border: solid black; text-align: right">{{$resumen_cierre->saldo_anterior}}</td>
                                    <td style="border: solid black;"></td>
                                </tr>
                                <tr>
                                    <td style="border: solid black;" >Relación de Ingresos enterados</td>
                                    <td style="border: solid black; text-align: right">{{$resumen_cierre->ingresos}}</td>
                                    <td style="border: solid black;"></td>
                                </tr>

                                <tr>
                                    <td style="border: solid black;"> Depositos No Relacionados(Transito)</td>
                                    <td style="border: solid black; text-align: right">{{$resumen_cierre->transito}} </td>
                                    <td style="border: solid black;"></td>
                                </tr>
                                <tr>
                                    <td style="border: solid black;"> Comisiones</td>
                                    <td style="border: solid black;"></td>
                                    <td style="border: solid black; text-align: right">{{$resumen_cierre->comisiones}}</td>
                                </tr>
                                 <tr>
                                    <td style="border: solid black;"> Depositos generados en meses anteriores</td>
                                    <td style="border: solid black;"></td>
                                    <td style="border: solid black; text-align: right">{{$resumen_cierre->ingreso_anterior}}</td>
                                </tr>
                                       
                                <tr>
                                    <td style="border-top: solid black; border-left: solid black; border-right: solid black;">Otros Cargos</td>
                                    <td style="border-top: solid black; border-left: solid black; border-right: solid black;"></td>
                                    <td style="border-top: solid black; border-left: solid black; border-right: solid black; text-align: right ">{{$resumen_cierre->transferencias}}</td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="border-top: 15px double #5CB85C; border-bottom: solid black; border-left: solid black; border-right: solid black; text-align: right">Subtotal</td>
                                    <td style="border-top: 15px double #5CB85C; border-bottom: solid black; border-left: solid black; border-right: solid black; text-align: right">{{$sub_total_mas}}</td>
                                    <td style="border-top: 15px double #5CB85C; border-bottom: solid black; border-left: solid black; border-right: solid black; text-align: right">{{$sub_total_menos}}</td>
                                </tr>
                                <tr>
                                    <td style="border: solid black; text-align: right">Total Monto Transferido</td>
                                    <td colspan="2" style="border: solid black; text-align: center; font-weight: bold;">{{$sub_total}}</td>
                                </tr>

                            </tfoot>    
                        </table> 
                    </div>

                </div>    
            </div> 
        </div>
    </div>




