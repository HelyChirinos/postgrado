<div class="card mb-2">
    <div class="card-header">
        <div class="row">
            <div class="col">Ingreso (Ultimos 3 meses)</div>

            <div class="col text-end"><img src="{{ asset('img/icons/history.png') }}" /></div>
        </div>
    </div>

    <table class="table table-bordered table-sm myTable">
        <thead class="table-primary">
            <tr>
                <th class="text-center">Fecha</th>
                <th class="text-center">Hora</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($userlogs_by_date as $day => $userlogs)
                <tr class="table-secondary">
                    <td colspan="2">
                        <b>{{ strtoupper(Carbon\Carbon::parse($day)->locale('es')->translatedFormat('l j F Y')) }} </b> ({{ count($userlogs) }})
                    </td>
                </tr>

                @foreach ($userlogs as $userlog)
                    <tr>
                        <td></td>
                        <td>{{ $userlog->time }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="2" class="p-3">No Hay Información</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
