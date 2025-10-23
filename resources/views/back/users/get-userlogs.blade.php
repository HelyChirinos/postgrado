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
                <th class="text-center">Día</th>
                <th class="text-center">Hora</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($userlogs_by_date as $day => $userlogs)
                <tr class="table-secondary">
                    <td colspan="2">
                        <b>{{ $day}}</b> ({{ count($userlogs) }})
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
                    <td colspan="2" class="p-3">No ha ingresado al Sistema.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
