@extends('layouts.back')

@section('title')
    &vert; Recibos-Aranceles
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header d-print-none">
            <div class="row">
                <div class="col-11 text-center fs-5">Resumén Constancias Emitidas: {{$periodo}}</div>

                <div class="col fs-5 text-end">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
                    <div id="botones" class="d-flex justify-content-between p-1 mt-3">
                        <div id="ToolbarLeft"></div>
                        <div id="ToolbarCenter">
                            <div class=" dt-buttons " role="group" aria-label="Second group">
                                <button type="button" class="btn btn-sm btn-primary" onclick="showExcel()">Excel</button>
                                <button type="button" class="btn btn-sm btn-success" onclick="showPDF()">PDF</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="printer()">Printer </button>
                              </div>                            
                        </div>
                        <div id="ToolbarRight"></div>
                    </div>
            <div class="row">
                <div class="d-flex justify-content-between p-1 mt-2">
                    <div id="barLeft"></div>
                    <div id="barCenterLeft">
                        <table id="resumen" class="table table-bordered table-striped datatable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Constancia</th>
                                    <th class="text-center"> Total</th>
                                    <th class="text-center"> 80%</th>
                                    <th class="text-center"> 20%</th>
                                     
                                </tr>    
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < $cont; $i++)
                                    <tr>
                                        <td>{{$a_constancias[$i]->constancia}}</td>
                                        <td style="text-align: right">{{formatMoney($a_constancias[$i]->total_constancia)}}</td>
                                        <td style="text-align: right">{{formatMoney($a_constancias[$i]->total80)}}</td>
                                        <td style="text-align: right">{{formatMoney($a_constancias[$i]->total20)}}</td>

                                    </tr>
                                @endfor
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align: right"><b>Sub-Total</b></td>
                                    <td style="text-align: right"><b>{{formatMoney($sumTotal)}}</b></td>
                                    <td style="text-align: right"><b>{{formatMoney($sum80)}}</b></td>
                                    <td style="text-align: right"><b>{{formatMoney($sum20)}}</b></td>

                                </tr>
                                <tr>
                                    <td style="text-align: right"><b>Total</b></td>
                                    <td style="text-align: right"><b>{{formatMoney($sumTotal)}}</b></td>
                                    <td colspan="2" style="text-align: center"><b>{{formatMoney($sum80+$sum20)}}</b></td>

                                </tr>

                            </tfoot>
                        </table>
                    </div>

                    <div id="barRight"></div>
                </div>
                    
            </div>
        </div>
        </div>
    </div>
@endsection



@push('styles')

<style>
    table thead {
        background-color: rgb(74, 190, 123);
        color:azure;
        text-align: center;
    }
    .page-item.active .page-link {
        background-color: rgb(74, 190, 123) !important;
        color: azure !important;
        /* border: 1px solid black; */
    }
    .page-link {
        color: black !important;
    }   

</style>

@endpush

@push('scripts')
<script type="module" src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" type="text/javascript"></script>


@endpush

<script>
  function showExcel(){
        let resumen ="";
        let periodo ="{{$periodo}}";
        let str = periodo.split("-");
        console.log(str[0]);
        let mes = str[0];
        let ano = str[1];  
        periodo = ano+'-'+mesAInt(mes);
        let url = '{{ route('back.excel.constancias.mes')}}'+'?periodo='+periodo
        document.location.href=url;               
        window.location = url;
  }
  function showPDF(){
        let resumen ="";
        let periodo ="{{$periodo}}";
        let url = "{{ route('back.bancos.showPdf') }}";
        url = url+'?periodo='+periodo+'&resumen='+resumen; 
        let newTab = document.createElement('a');
        newTab.href = url;
        newTab.target = "_blank";
        newTab.click();

    }
    function printer (win) {
        window.print();
    }

    function mesAInt(mesEscrito) {
        const meses = {
            "Enero": 1,
            "Febrero": 2,
            "Marzo": 3,
            "Abril": 4,
            "Mayo": 5,
            "Junio": 6,
            "Julio": 7,
            "Agosto": 8,
            "Septiembre": 9,
            "Octubre": 10,
            "Noviembre": 11,
            "Diciembre": 12
        };
        mesEscrito = mesEscrito.trim(); // Eliminar espacios al inicio y al final
        return meses[mesEscrito] || null; // Devuelve null si no se encuentra
    }


</script>





