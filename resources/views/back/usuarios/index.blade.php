@extends('layouts.back')

@section('title')
    &vert; Usuarios
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header d-print-none">
            <div class="row">
                <div class="col">Perfiles de Usuarios</div>

                <div class="col fs-5 text-end">
                    <i class="bi bi-people-fill nav-icon"></i>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="d-flex justify-content-between p-1">
                <div id="ToolbarLeft"></div>
                <div id="ToolbarCenter"></div>
                <div id="ToolbarRight"></div>
            </div>

            <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-primary">Log</th>
                        <th scope="col" width="4%">ID</th>
                        <th scope="col">Decanato</th>

                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Cedula</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">F.Nacimiento</th>
                        <th scope="col" class="text-danger">Propietario ?</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        /* ------------------------------------------------------------------------ */
        let dtButtonsLeft = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        let dtButtonsCenter = [];
        let dtButtonsRight = [];
        /* ------------------------------------------------------------------------ */

        let createButton = {
            className: 'btn-success',
            text: '<i class="bi bi-plus"></i>',
            titleAttr: 'Agregar',
            enabled: true,
            action: function(e, dt, node, config) 
            {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('back.usuarios.create') }}",
                    success: function(response) {
                        bootbox.dialog({
                            locale: 'nl',
                            title: 'Nuevo',
                            message: response,
                            size: 'lg',
                            onEscape: true,
                            backdrop: true
                        });
                    } //success
                }); // ajax               
            }  // action  

        } // createButton



        dtButtonsCenter.push(createButton)

        let editButton = {
            extend: 'selectedSingle',
            className: 'btn-primary selectOne',
            text: '<i class="bi bi-pencil"></i>',
            titleAttr: 'Editar',
            enabled: false,

            action: function(e, dt, node, config) {
                const id = dt.row({
                    selected: true
                }).data().id;
                var var_url = "{{ route('back.usuarios.edit', 'id') }}".replace("id", id);
                console.log(var_url);
                $.ajax({
                    method: 'GET',
                    
                    url: "{{ route('back.usuarios.edit', 'id') }}".replace("id", id),
                    success: function(response) {
                        bootbox.dialog({
                            locale: 'nl',
                            title: 'Editar Usuario',
                            message: response,
                            size: 'xl',
                            onEscape: true,
                            backdrop: true
                        });
                    } //success
                }); // ajax          
                // document.location.href = '{{ route('back.users.edit', 'id') }}'.replace("id", id);
            } //action
        }
        dtButtonsCenter.push(editButton)

        let clearButton = {
            className: 'btn-secondary',
            text: '<i class="bi bi-arrow-counterclockwise"></i>',
            titleAttr: 'Recargar Tabla',
            action: function(e, dt, node, config) {
                dt.state.clear();
                window.location.reload();
            }
        }
        dtButtonsRight.push(clearButton)

        let deleteButton = {
            extend: 'selected',
            className: 'btn-danger selectMultiple',
            text: '<i class="bi bi-trash"></i>',
            titleAttr: 'Eliminar',
            enabled: false,
            url: "{{ route('back.users.massDestroy') }}",
            action: function(e, dt, node, config) {
                let ids = $.map(dt.rows({
                    selected: true
                }).data(), function(entry) {
                    return entry.id;
                });

                // remove protected users from selection
                for (let i = 1; i <= 2; i++) {
                    if (ids.includes(i)) {
                        ids = ids.filter(item => item !== i);

                        dt.row('#' + i).deselect();

                        showToast({
                            type: 'warning',
                            title: 'Eliminado ...',
                            message: 'Un item (ID = ' + i + ') removed from selection due to protection.',
                        });
                    }
                }

                if (ids.length > 0) {
                    bootbox.confirm({
                        title: 'Eliminar Usuario ' + ids.length + ' item(s) ...',
                        message: '<div class="alert alert-danger" role="alert">Seguro de Eliminar?</div>',
                        buttons: {
                            confirm: {
                                label: 'Si',
                                className: 'btn-primary'
                            },
                            cancel: {
                                label: 'No',
                                className: 'btn-secondary'
                            }
                        },
                        callback: function(confirmed) {
                            if (confirmed) {
                                $.ajax({
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    },
                                    success: function(response) {
                                        dt.draw();

                                        showToast({
                                            type: 'success',
                                            title: 'Eliminado ...',
                                            message: 'La selección (' + ids.length + ' items) ha sido eliminado.',
                                        });
                                    }
                                });
                            }
                        }
                    });
                }
            }
        }
        dtButtonsRight.push(deleteButton)
        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            ajax: {
                url: "{{ route('back.usuarios.index') }}",
                data: function(d) {}
            },
            columns: [{
                    data: 'userlogs_count',
                    name: "userlogs",
                    searchable: false,
                    sortable: false,
                    className: "text-center no-select no-export",
                    render: function(data, type, row, meta) {
                        if (data) {
                            return '<div class="getUserlogs" title="Mostrar Log"><img src="{{ asset('img/icons/history.png') }}"/></div>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data.toString().padStart(5, '0');
                    }
                },
                {
                    data: 'decanato',
                    name: 'decanato',
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                },
                {
                    data: 'apellido',
                    name: 'apellido',
                },
                {
                    data: 'cedula',
                    name: 'cedula',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data.toString();
                    }
                },

                {
                    data: 'email',
                    name: 'email',
                    sortable: false,
                    render: function(data, type, row, meta) {
                        if (data) {
                            return '<a a href="mailto:' + data +
                                '?SUBJECT=MyApplication - User">' +
                                data + '</a>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'telefono',
                    name: 'telefono',
                },
                {
                    data: 'fecha_nac',
                    name: 'fecha_nac',
                },
                {
                    data: 'is_propietario',
                    name: 'is_propietario',
                    searchable: false,
                    className: "text-center no-select toggleIsPropietario",
                    render: function(data, type, row, meta) {
                        if (data == 1) {
                            return '<i class="bi bi-check-lg"></i>';
                        } else {
                            return '&nbsp;';
                        }
                    },
                    createdCell: function(td, cellData, rowData, row, col) {
                        if (cellData == 1) {
                            $(td).addClass('table-success');
                        }
                    },
                },
            ],
            select: {
                selector: 'td:not(.no-select)',
            },
            ordering: true,
            order: [
                [1, 'asc']
            ],
            preDrawCallback: function(settings) {
                oTable.columns.adjust();
            },
        };
        /* ------------------------------------------- */
        let oTable = $('#sqltable').DataTable(dtOverrideGlobals);
        /* ------------------------------------------------------------------------ */
        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupLeft',
            buttons: dtButtonsLeft
        });
        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupCenter',
            buttons: dtButtonsCenter
        });
        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupRight',
            buttons: dtButtonsRight
        });

        oTable.buttons('BtnGroupLeft', null).containers().appendTo('#ToolbarLeft');
        oTable.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter');
        oTable.buttons('BtnGroupRight', null).containers().appendTo('#ToolbarRight');
        /* ------------------------------------------------------------------------ */
        oTable.on('select deselect', function(e, dt, type, indexes) {
            const selectedRows = oTable.rows({
                selected: true
            }).count();

            oTable.buttons('.selectOne').enable(selectedRows === 1);
            oTable.buttons('.selectMultiple').enable(selectedRows > 0);
        });
        /* ------------------------------------------------------------------------ */
        /* DATATABLE - CELL - Action					   						    */
        /* ------------------------------------------------------------------------ */
        $('#sqltable tbody').on('click', 'td.toggleIsPropietario', function() {
            const table = 'usuarios';
            const id = oTable.row($(this).closest("tr")).data().DT_RowId;
            const key = 'is_propietario';
            let value = oTable.cell(this).data();
            bootbox.confirm({
                title: 'Editar ...',
                message: MyItem(id, key, value),
                size: 'xl',
                onEscape: true,
                backdrop: true,
                buttons: {
                    confirm: {
                        label: 'Si',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-secondary'
                    }
                },
                callback: function(confirmed) {
                    if (confirmed) {
                        value = value == 0 ? 1 : 0;

                        setValue(table, id, key, value);
                    }
                }
            });

        });
        /* ------------------------------------------- */
        $('#sqltable tbody').on('click', '.getUserlogs', function() {
            const data = oTable.row($(this).closest('tr')).data();

            $.ajax({
                method: 'GET',
                url: "{{ route('back.usuarios.getUserlogs') }}",
                data: {
                    id: data.id,
                },
                success: function(response) {
                    bootbox.dialog({
                        locale: 'nl',
                        title: data['name'],
                        message: response,
                        size: 'lg',
                        onEscape: true,
                        backdrop: true
                    });
                }
            });
        });
        /* ------------------------------------------------------------------------ */
        /* FUNCTIONS - MyItem, setValue                     					    */
        /* ------------------------------------------------------------------------ */
        function MyItem(id, key, value) {
            const aRow = oTable.row('#' + id).data();
            let from, to;

            if (value == 1) {
                from = '1';
                to = '0';
            } else {
                from = '0';
                to = '1';
            }

            let strHTML = '';
            strHTML += '<table class="table table-bordered table-sm myTable">';
            strHTML += '<thead class="table-primary">';
            strHTML += '<tr><th class="text-center">ID</th><th>Name</th><th>E-mail</th><th>Propietario ?</th></tr>';
            strHTML += '</thead>';
            strHTML += '<tbody>';
            strHTML += '<tr>';
            strHTML += '<td class="text-center">' + aRow['id'].toString().padStart(5, '0') + '</td>';
            strHTML += '<td>';
            if (aRow['name']) {
                strHTML += aRow['name'];
            }
            strHTML += '</td>';
            strHTML += '<td>';
            if (aRow['email']) {
                strHTML += aRow['email'];
            }
            strHTML += '</td>';
            strHTML += '<td class="text-center">';
            strHTML += from + ' <i class="bi bi-arrow-right"></i> ' + to;
            strHTML += '</td>';
            strHTML += '</tr>';
            strHTML += '</tbody>';
            strHTML += '</table>';
            strHTML += '<br/>';
            strHTML += '<div class="alert alert-warning" role="alert">Seguro quiere editar el item arriba?</div>';
            return strHTML;
        };
        /* ------------------------------------------- */
        function setValue(table, id, key, value) {
            $.ajax({
                method: 'POST',
                url: "{{ route('back.general.setValueDB') }}",
                data: {
                    table: table,
                    id: id,
                    key: key,
                    value: value,
                },
                success: function(response) {
                    oTable.rows(id).invalidate().draw(false);

                    showToast(response);
                }
            });
        };
        /* ------------------------------------------------------------------------ */
    </script>
@endpush
