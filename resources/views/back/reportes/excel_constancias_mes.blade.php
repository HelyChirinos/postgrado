<table>
    <th>

    </th>
</table>
<table id="sqltable" class="styled-table table-bordered mb-3 mt-0" style="width: 100%">
    <thead >
        <tr class="titulo">
            <th  colspan="4" style="text-align: center; border-top: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                CONSTANCIAS EMITIDAS</th>
        </tr>
        <tr class="titulo">
            <th  colspan="4" style="text-align: center; border-bottom: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                PERIODO: {{$periodo}} </th>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Constancias</th>
            <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Total Bs. </th>
            <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">80% Bs.</th>
            <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">20% Bs.</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < $cont; $i++)
            <tr>
                <td style="border: solid black;">{{$a_constancias[$i]->constancia}}</td>
                <td style="border: solid black; text-align: right">{{$a_constancias[$i]->total_constancia}}</td>
                <td style="border: solid black; text-align: right">{{$a_constancias[$i]->total80}}</td>
                <td style="border: solid black; text-align: right">{{$a_constancias[$i]->total20}}</td>

            </tr>
        @endfor
    </tbody>
    <tfoot>
        <tr>
            <td style="border: solid black; text-align: right"><b>Sub-Total</b></td>
            <td style="border: solid black; text-align: right"><b>{{$sumTotal}}</b></td>
            <td style="border: solid black; text-align: right"><b>{{$sum80}}</b></td>
            <td style="border: solid black; text-align: right"><b>{{$sum20}}</b></td>

        </tr>
        <tr>
            <td style="border: solid black; text-align: right"><b>Total</b></td>
            <td style="border: solid black; text-align: right"><b>{{$sumTotal}}</b></td>
            <td colspan="2" style="border: solid black; text-align: center"><b>{{$sum80+$sum20}}</b></td>

        </tr>

    </tfoot>

</table> 







