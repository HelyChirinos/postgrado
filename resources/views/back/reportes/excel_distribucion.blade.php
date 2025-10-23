<div class="container">
    <table id="100porcent" class="table table-bordered table-striped datatable" style="width: 100%; margin-bottom: 30px;">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:16px;" >DISTRIBUCIÓN {{$periodo}}</th>

            </tr>
            <tr></tr>
            <tr> 
                <th colspan="3" style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:14px;" > Recaudación del Mes</th>
                <th style="text-align: right; border: solid black; font-size:16px;">{{formatMoney($resumen[0]->total_depositos)}} Bs.</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
            <tr>
                <th rowspan="2" style="text-align: center; border: solid; vertical-align: middle; background-color:#D9DADB;">Aranceles</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Facturado</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Coordinación - 80% </th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Dirección - 20% </th>
            </tr>
            <tr>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_arancel)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_arancel*0.8)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_arancel*0.2)}} Bs.</td>
            </tr>
            <tr>
                <th rowspan="2" style="text-align: center; border: solid; vertical-align: middle; background-color:#D9DADB;">Matrículas</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Facturado</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Coordinación - 80% </th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Dirección - 20% </th>
            </tr>
            <tr>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_matricula)}} Bs.</td>
                <td style="text-align: right; border: solid; ">{{formatMoney($resumen[0]->total_matricula*0.8)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_matricula*0.2)}} Bs.</td>
            </tr>

        </tbody>
    </table>

    <table style="width: 100%; margin-bottom: 30px;">    
        <thead>
            <tr> 
                <th colspan="3" style="text-align: center; border: solid; background-color:#C5D9F1; font-size:14px;"> Recaudación Otro Mes</th>
                <th style="text-align: right; center; border: solid; font-size:16px;">{{formatMoney($resumen[0]->total_depositos_ant)}} Bs.</th>
            </tr>
        </thead>    
        <tbody>
            <tr>
                <th rowspan="2" style="text-align: center; border: solid; vertical-align: middle; background-color:#D9DADB;">Aranceles</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Facturado</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Coordinación - 80% </th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Dirección - 20% </th>
            </tr>
            <tr>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_arancel_ant)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_arancel_ant*0.8)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_arancel_ant*0.2)}} Bs.</td>
            </tr>
            <tr>
                <th rowspan="2" style="text-align: center; border: solid; vertical-align: middle; background-color:#D9DADB;">Matrículas</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Facturado</th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Coordinación - 80% </th>
                <th style="text-align: center; border: solid; background-color:#D9DADB;">Dirección - 20% </th>
            </tr>
            <tr>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_matricula_ant)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_matricula_ant*0.8)}} Bs.</td>
                <td style="text-align: right; border: solid;">{{formatMoney($resumen[0]->total_matricula_ant*0.2)}} Bs.</td>
            </tr>

        </tbody>
    </table>
</div>



