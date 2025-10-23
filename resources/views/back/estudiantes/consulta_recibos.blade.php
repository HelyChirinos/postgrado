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
        background-color: #2F7127; 
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
    
    </style>


<div class="card mb-2">

    <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
        <div class="row mb-2">
            <div class="card-header d-print-none text-center fs-5">
                <div class="row">
                    <div class="col-12">Pagos realizados por : {{$estudiante->nombre. ' - '.$estudiante->tipo_doc.': '.$estudiante->no_doc }}</div>
                </div>
            </div>            
            <table class="styled-table mb-3" style="width: 100%">
                <thead >
                    <tr class="titulo">
                        <th colspan="4">PAGOS</th>
                     </tr>
                    <tr>
                        <th scope="col">Recibo No.</th>
                        <th scope="col">fecha</th>
                        <th scope="col">Concepto</th>
                     </tr>
                </thead>
                <tbody>
                    
                    @forelse($estudiante->recibos as $item)
                    <tr>
                        <td>{{ sprintf("%04s",$item->id)}}</td>
                        <td>{{formatFecha($item->fecha_recibo)}} </td>
                        <td >{{$item->concepto}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-3 text-center text-bold">NO HAY REGISTROS DE PAGOS.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>                     
        </div>

    </div>    
</div> 

</div>
