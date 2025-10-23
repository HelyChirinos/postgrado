@extends('layouts.back')

@section('title')
    &vert; Users
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header text-white bg-primary text-center fs-5 d-print-none">
            <div class="row">
                <div class="col-11">Usuarios</div>

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
            <div class="row">
                <div class="col-1"></div>
                <div class="col">
                    <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col" class="text-primary">Log</th>
                                <th scope="col" width="4%">ID</th>
                                <th scope="col">Nombre(s)</th>
                                <th scope="col">Apellido(s)</th>
                                <th scope="col">C.I.</th>
                                <th scope="col">Decanato</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Permisos</th>

                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-1"></div>    
            </div>    
        </div>
    </div>

@endsection

@push('scripts')
    <script type="module">

        /* ---------------------------------------------------------------------- */
        /* -----------------------Determina Language (Location) ------------------------------------ */
        var locale = "{{ session('locale')}}";
        var url_locate = location.protocol+'//'+location.host;
        if (locale =='en') {
            url_locate = url_locate+'/json/datatables/i18n/en-GB.json';
        } else {
            url_locate = url_locate+'/json/datatables/i18n/es-ES.json';
        }
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
        /* -----------------------Botón Agregar ------------------------------------ */
        let createButton = {
            className: 'btn-success',
            text: '<i class="bi bi-plus"></i>',
            titleAttr: 'Add',
            enabled: true,
            action: function(e, dt, node, config) {
                document.location.href = '{{ route('back.users.create') }}';
            }
        }


        // let createButton = {
        //     className: 'btn-success',
        //     text: '<i class="bi bi-plus"></i>',
        //     titleAttr: 'Agregar',
        //     enabled: true,
        //     action: function(e, dt, node, config) 
        //     {
        //         $.ajax({
        //             method: 'GET',
        //             url: "{{ route('back.users.create')}}",
        //             success: function(response) {
        //                 bootbox.dialog({
        //                     locale: 'nl',
        //                     title: 'Agregar Usuario',
        //                     message: response,
        //                     size: 'xl',
        //                     onEscape: true,
        //                     backdrop: true
        //                 });
        //             } //success
        //         }); // ajax               
        //     }    
        // } // createButton

        
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

                document.location.href = '{{ route('back.users.edit', 'id') }}'.replace("id", id);
            } //action
        }
        dtButtonsCenter.push(editButton)

        let clearButton = {
            className: 'btn-secondary',
            text: '<i class="bi bi-arrow-counterclockwise"></i>',
            titleAttr: 'Reset filter and sort',
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
            titleAttr: 'Delete',
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
                        title: 'Eliminar user ' + ids.length + ' item(s) ...',
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
                url: "{{ route('back.users.index') }}",
                data: function(d) {}
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-forward" title="próximo"></i>',
                    previous: '<i class="fa fa-backward" title="anterior"></i>',
                    first: '<i class="fa fa-step-backward" title="primero"></i>',
                    last: '<i class="fa fa-step-forward" title="último"></i>',
                }

            },  
            columns: [{
                    data: 'userlogs_count',
                    name: "userlogs",
                    searchable: false,
                    sortable: false,
                    className: "text-center no-select no-export",
                    render: function(data, type, row, meta) {
                        if (data) {
                            return '<div class="getUserlogs" title="Show Log"><img src="{{ asset('img/icons/history.png') }}"/></div>';
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
                },
                {
                    data: 'decanato',
                    name: 'decanato',
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
                    data: 'roles',
                    name: 'roles',
                    searchable: false,
                    className: "text-center no-select",
                    render: function(data, type, row, meta) {
                      var a_roles = [];
                      var datos = '';  
                      if (data.length==0) {
                        return '<span class="badge text-bg-dark">Individual</span>';
                      }
                      $.each(data, function(index, value) {
                        if (value=="SuperAdmin") {
                            datos = '<span class="badge text-bg-danger">'+value+'</span>';
                            a_roles.push(datos);
                        } else {
                            if (value=="Administrador") {
                                datos='<span class="badge text-bg-warning">'+value+'</span>';
                                a_roles.push(datos);
                            } else {
                               datos = '<span class="badge text-bg-info">'+value+'</span>';
                               a_roles.push(datos);

                            }
                        }
                    });
                      return a_roles;

                       return data  
   
                    }
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
        $('#sqltable tbody').on('click', 'td.toggleIsDeveloper', function() {
            const table = 'users';
            const id = oTable.row($(this).closest("tr")).data().DT_RowId;
            const key = 'is_propietario';
            let value = oTable.cell(this).data();

            if (id <= 2) {
                bootbox.dialog({
                    title: "Editar ...",
                    message: '<div class="alert alert-info" role="alert">Este Item es solo lectura.</div>',
                    onEscape: true,
                    backdrop: true,
                });
            } else {
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
            }
        });
        /* ------------------------------------------- */
        $('#sqltable tbody').on('click', '.getUserlogs', function() {
            const data = oTable.row($(this).closest('tr')).data();

            $.ajax({
                method: 'GET',
                url: "{{ route('back.users.getUserlogs') }}",
                data: {
                    id: data.id,
                },
                success: function(response) {
                    bootbox.dialog({
                        locale: 'nl',
                        title: 'Información de Ingreso al Sistema: '+data['nombre']+' '+data['apellido'],
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
            strHTML += '<tr><th class="text-center">ID</th><th>Nombre</th><th>E-mail</th><th>Propietario ?</th></tr>';
            strHTML += '</thead>';
            strHTML += '<tbody>';
            strHTML += '<tr>';
            strHTML += '<td class="text-center">' + aRow['id'].toString().padStart(5, '0') + '</td>';
            strHTML += '<td>';
            if (aRow['nombre']) {
                strHTML += aRow['nombre'];
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

        /* ------------------------------------------------------------------------ */
        /* MODALS: Add_Modal y Update_Modal                     				    */
        /* ------------------------------------------------------------------------ */
        
    $('#add_modal').on('hide.bs.modal', function (e) {
            resetAddForm();
    })     

    $('#update_modal').on('hide.bs.modal', function (e) {
        $("#modal_body").empty();
    })      


    </script>
@endpush
