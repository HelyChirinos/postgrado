@extends('layouts.back')

@section('title')
    &vert; Customers
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header d-print-none">
            <div class="row">
                <div class="col">Customers</div>

                <div class="col fs-5 text-end">
                    <img src="{{ asset('img/icons/persons.png') }}" />
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
                        <th scope="col" width="4%">ID</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Compañia</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">País</th>
                        <th scope="col">Lugar</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col" class="text-danger">Newsletter ?</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        
        /* -----------------------Determina Language (Location) ------------------------------------ */
        var locale = "{{ session('locale')}}";
        var url_locate = location.protocol+'//'+location.host;
        if (locale =='en') {
            url_locate = url_locate+'/json/datatables/i18n/en-GB.json';
        } else {
            url_locate = url_locate+'/json/datatables/i18n/es-ES.json';
        }
        const currentUrl = window.location.href;

       $.extend(true, $.fn.dataTable.defaults, {
            language: {
            url: url_locate,
            },
        });

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
            action: function(e, dt, node, config) {
                document.location.href = '{{ route('back.customers.create') }}';
            }
        }
        dtButtonsCenter.push(createButton)

        let showButton = {
            extend: 'selectedSingle',
            className: 'btn-secondary selectOne',
            text: '<i class="bi bi-eye"></i>',
            titleAttr: 'Mostrar',
            enabled: false,
            action: function(e, dt, node, config) {
                const id = dt.row({
                    selected: true
                }).data().id;

                document.location.href = '{{ route('back.customers.show', 'id') }}'.replace("id", id);
            }
        }
        dtButtonsCenter.push(showButton)

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

                document.location.href = '{{ route('back.customers.edit', 'id') }}'.replace("id", id);
            }
        }
        dtButtonsCenter.push(editButton)

        let clearButton = {
            className: 'btn-secondary',
            text: '<i class="bi bi-arrow-counterclockwise"></i>',
            titleAttr: 'Recargar tabla',
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
            url: "{{ route('back.customers.massDestroy') }}",
            action: function(e, dt, node, config) {
                const ids = $.map(dt.rows({
                    selected: true
                }).data(), function(entry) {
                    return entry.id;
                });

                bootbox.confirm({
                    title: 'Borrar Regisro(s) ...',
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
                                        message: 'La selección ha sido eliminada.',
                                    });
                                }
                            });
                        }
                    }
                });
            }
        }
        dtButtonsRight.push(deleteButton)
        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            ajax: {
                url: "{{ route('back.customers.index') }}",
                data: function(d) {}
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data.toString().padStart(5, '0');
                    }
                },
                {
                    data: 'customer_last_name',
                    name: 'customer_last_name',
                },
                {
                    data: 'customer_first_name',
                    name: 'customer_first_name',
                },
                {
                    data: 'company_name',
                    name: 'company_name',
                },
                {
                    data: 'address_street',
                    name: 'address_street',
                },
                {
                    data: 'address_country',
                    name: 'address_country',
                    className: 'text-center',
                },
                {
                    data: 'address_place',
                    name: 'address_place',
                },
                {
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'send_newsletter',
                    name: 'send_newsletter',
                    searchable: false,
                    className: "text-center no-select toggleSendNewsletter",
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
                }
            ],
            select: {
                selector: 'td:not(.no-select)',
            },
            ordering: true,
            order: [
                [1, "asc"],
                [2, "asc"],
                [3, "asc"],
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
        $('#sqltable tbody').on('click', 'td.toggleSendNewsletter', function() {
            const table = 'customers';
            const id = oTable.row($(this).closest("tr")).data().DT_RowId;
            const key = 'send_newsletter';
            let value = oTable.cell(this).data();

            bootbox.confirm({
                title: 'Editar...',
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
        /* ------------------------------------------------------------------------ */
        /* FUNCTIONS - MyItem, setValue         			            		    */
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
            strHTML +=
                '<tr><th class="text-center">ID</th><th>Customer</th><th>Company</th><th>Place</th><th class="text-center">Send newsletter ?</th></tr>';
            strHTML += '</thead>';
            strHTML += '<tbody>';
            strHTML += '<tr>';
            strHTML += '<td class="text-center">' + aRow['id'].toString().padStart(5, '0') + '</td>';
            strHTML += '<td>';
            if (aRow['customer'] == null) {
                strHTML += '&nbsp;';
            } else {
                strHTML += aRow['customer'];
            }
            strHTML += '</td>';
            strHTML += '<td>';
            if (aRow['company_name'] == null) {
                strHTML += '&nbsp;';
            } else {
                strHTML += aRow['company_name'];
            }
            strHTML += '</td>';
            strHTML += '<td>';
            if (aRow['place'] == null) {
                strHTML += '&nbsp;';
            } else {
                strHTML += aRow['place'];
            }
            strHTML += '</td>';
            strHTML += '<td class="text-center">';
            strHTML += from + ' <i class="bi bi-arrow-right"></i> ' + to;
            strHTML += '</td>';
            strHTML += '</tr>';
            strHTML += '</tbody>';
            strHTML += '</table>';
            strHTML += '<br/>';
            strHTML += '<div class="alert alert-warning" role="alert">Seguro de Editar el Item arriba?</div>';
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
