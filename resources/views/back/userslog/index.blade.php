@extends('layouts.back')

@section('title')
    &vert; Users - Log
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
    
    .styled-table tbody  tr.active-row {
        border-bottom: 2px solid #009879;

        font-weight: bold;
        color:#DDDD55;
    
    }
    
    .styled-table tfoot tD.escena-row {
     
        text-align: center;
        font-weight: bold;
    
    }
    
    </style>

    <div class="card mb-2">
        <div class="card-header text-white bg-primary text-center fs-5 d-print-none">
            <div class="row">
                <div class="col-10">Control de Usuarios (Ultimos {{ $months }} meses)</div>

                <div class="col fs-5 text-end">
                    <button type="button" class="btn btn-outline-secondary btn-sm me-2" title="Print" tabindex="-1" onclick="window.print();">
                        <img src="{{ asset('img/icons/printer.png') }}" class="img-fluid" />
                    </button>
                    <i class="bi bi-person-lines-fill nav-icon"></i>
                </div>
            </div>
        </div>

        <table class="styled-table table-sm mb-0 ">
            <thead class="table-primary">
                <tr>
                    <th class="text-center">Día</th>
                    <th class="text-center">Hora</th>
                    <th class="text-center">Usuario</th>
                    <th class="text-center">Decanato</th>
                    <th class="text-center">Administrador</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($userlogs_by_date as $day => $userlogs)
                    <tr class="table-secondary">
                        <td colspan="6">
                            <b>{{ $day }}</b> ({{ count($userlogs) }})
                        </td>
                    </tr>

                    @foreach ($userlogs as $userlog)
                        <tr>
                            <td></td>
                            <td>{{ $userlog->time }}</td>
                            <td>{{ $userlog->name }}</td>
                            <td>{{ $userlog->decanato }}</td>
                            @if ($userlog->is_propietario)
                                <td class="text-center"><i class="bi bi-check-lg"></i></td>
                            @else
                                <td class="text-center"></td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="p-3">Sin Información.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
