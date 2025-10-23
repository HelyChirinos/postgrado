@extends('layouts.back')

@section('title')
    &vert; Roles y Permisos
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header text-white bg-primary d-print-none">
            <div class="row">
                <div class="col fs-5  text-center">Roles y Permisos BCV </div>
            </div>
        </div>

        <div class="card-body ">
            <div class="d-flex justify-content-between p-1">
                <div id="ToolbarLeft"></div>
                <div id="ToolbarCenter"></div>
                <div id="ToolbarRight"></div>
            </div>
            <div class="row">
            <div class="col-1">
     
            </div>
            <div class="col">
                <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 100%">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" width="4%">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Permisos</th>
                              <th scope="col">F.Creación</th>
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
        /* ------------------------------------------------------------------------ */
        let dtButtonsLeft = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        let dtButtonsCenter = [];
        let dtButtonsRight = [];
        let prohibidos  = [1,2];

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
                     url: "{{ route('back.roles.create')}}",
                     success: function(response) {
                         bootbox.dialog({
                             locale: 'nl',
                             title: 'Agregar Rol y Permisos',
                             message: response,
                             size: 'xl',
                             onEscape: true,
                             backdrop: true
                         });
                     } 
                 });
                
                
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
                if (prohibidos.includes(id)) {
                    let no_posible="<div class='text-center'><i class='fa-light fa-triangle-exclamation' style='color: red; font-size:50px; margin-bottom:20px;'></i> <br> !!! Los Roles Administrador y SuperAdmin No pueden ser Modificados !!! </div";
                    bootbox.alert(no_posible).find('.modal-content').css({'background-color': '#fff', 'font-weight' : 'bold',  'font-size': '14px', 'font-weight' : 'bold'} );
                } else {
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.roles.edit', 'id') }}".replace("id", id),
                        success: function(response) {
                            bootbox.dialog({
                                title: 'Editar Rol',
                                message: response,
                                size: 'lg',
                                onEscape: false,
                                backdrop: false
                            });
                        } //success
                    }); // ajax          
                }
            } //action
        }
        dtButtonsCenter.push(editButton)

        let clearButton = {
            className: 'btn-secondary',
            text: '<i class="bi bi-arrow-counterclockwise"></i>',
            titleAttr: 'Recargar Tabla',
            action: function(e, dt, node, config) {
                dt.state.clear();

                document.location.href = '{{ route('back.divisas.refresh')}}';
            }
        }
        dtButtonsRight.push(clearButton)

        let deleteButton = {
            extend: 'selected',
            className: 'btn-danger selectMultiple',
            text: '<i class="bi bi-trash"></i>',
            titleAttr: 'Eliminar',
            enabled: false,
            url: "{{ route('back.roles.massDestroy') }}",
            action: function(e, dt, node, config) {
                let ids = $.map(dt.rows({
                    selected: true
                }).data(), function(entry) {
                    return entry.id;
                });
                let prohibidos =[1, 2];
                if (ids.length > 0) {
                    if(ids.some(element => prohibidos.includes(element))) {
                        let no_posible="<div class='text-center'><i class='fa-light fa-triangle-exclamation' style='color: red; font-size:50px; margin-bottom:20px;'></i> <br> !! Los Roles Administrador y SuperAdmin No pueden ser Modificados !! </div";
                        bootbox.alert(no_posible).find('.modal-content').css({'background-color': '#fff', 'font-weight' : 'bold',  'font-size': '14px', 'font-weight' : 'bold'} );                        
                    } else 
                    {
                        bootbox.confirm({
                            title: 'Eliminar Role(es) ' + ids.length + ' item(s) ...',
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
                                    console.log('IDs: '+ids )
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
                                                message: 'La selección(es) (' + ids.length + ' items) ha sido eliminado.',
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }    
                }
            }
        }
        dtButtonsRight.push(deleteButton)
        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            ajax: {
                url: "{{ route('back.roles.index') }}",
                data: function(d) {},
                error: function(d) { alert(d.responseText) } 
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-forward" title="próximo"></i>',
                    previous: '<i class="fa fa-backward" title="anterior"></i>',
                    first: '<i class="fa fa-step-backward" title="primero"></i>',
                    last: '<i class="fa fa-step-forward" title="último"></i>',
                }

            },  
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                },
                {
                    data: 'name',
                    name: 'name',
                    type: 'text',
                },
                {
                    data: 'description',
                    name: 'description',
                    type: 'text',
                },
                {
                    data: 'permisos',
                    name: 'permisos',
                    type: 'text',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    type: "date",
                    searchable: false,
                    className: "text-center ",
                    render: function(data) {
                        return moment(data).utc().format('DD/MM/YYYY');
                    },
                },

            ],
            select: {
                selector: 'td:not(.no-select)',
            },
            preDrawCallback: function(settings) {
                oTable.columns.adjust();
            },
        };
        /* ------------------------------------------- */
        DataTable.datetime('DD-MM-YYYY');
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
    </script>
    
@endpush
