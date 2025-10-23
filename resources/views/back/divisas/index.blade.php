@extends('layouts.back')

@section('title')
    &vert; Divisas
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header text-white bg-primary d-print-none">
            <div class="row">
                <div class="col fs-5  text-center">Divisas - BCV </div>
            </div>
        </div>

        <div class="card-body ">
            <div class="d-flex justify-content-between p-1">
                <div class="col-4" id="ToolbarLeft"></div>
                <div class="col-4 d-flex justify-content-center" id="ToolbarCenter"></div>
                <div class="col-4" id="ToolbarRight"></div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col" width="4%">ID</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Dolar-Bs.</th>
                                <th scope="col">Variación $</th>
                                <th scope="col">Euro-Bs.</th>
                                <th scope="col">Variación €</th>

                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-2"></div>
             </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
            var exist = '{{Session::has('alert')}}';
            if(exist){
                let no_divisa="<div class='text-center'><i class='fa-light fa-triangle-exclamation' style='color: red; font-size:50px; margin-bottom:20px;'></i> <br> !!! Las Divisas del día NO estan Actualizadas !!! </div";
                bootbox.alert(no_divisa).find('.modal-content').css({'background-color': '#fff', 'font-weight' : 'bold',  'font-size': '14px', 'font-weight' : 'bold'} );
            }
    </script>     

    <script type="module">
       const userCanAdd = {{(auth()->user()->can('Agregar Divisas')) ? "true" : "false" }};
       const userCanUpdate = {{ auth()->user()->can('Modificar Divisas') ? "true" : "false" }};
       const userCanDelete = {{ auth()->user()->can('Eliminar Divisas') ? "true" : "false" }};
        console.log ('Puede Agregar :'+userCanAdd);
        console.log ('Puede Modificar :'+userCanUpdate);
        console.log ('Puede Eliminar :'+userCanDelete);

        /* ------------------------------------------------------------------------ */
        let dtButtonsLeft = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        let dtButtonsCenter = [];
        let dtButtonsRight = [];
        /* ------------------------------------------------------------------------ */
        if (userCanAdd) {
            let createButton = {
                className: 'btn-success',
                text: '<i class="bi bi-plus"></i>',
                titleAttr: 'Agregar',
                enabled: true,
                action: function(e, dt, node, config) 
                {
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.divisas.create')}}",
                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Ingresar Divisa',
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
        }
        if (userCanUpdate) {

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
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.divisas.edit', 'id') }}".replace("id", id),
                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Editar Dolar',
                                message: response,
                                size: 'lg',
                                onEscape: false,
                                backdrop: false
                            });
                        } //success
                    }); // ajax          
                    // document.location.href = '{{ route('back.users.edit', 'id') }}'.replace("id", id);
                } //action
            }
            dtButtonsCenter.push(editButton)
        }    
        if (userCanDelete) {
            let deleteButton = {
                extend: 'selected',
                className: 'btn-danger selectMultiple',
                text: '<i class="bi bi-trash"></i>',
                titleAttr: 'Eliminar',
                enabled: false,
                url: "{{ route('back.divisas.massDestroy') }}",
                action: function(e, dt, node, config) {
                    let ids = $.map(dt.rows({
                        selected: true
                    }).data(), function(entry) {
                        return entry.id;
                    });



                    if (ids.length > 0) {
                        bootbox.confirm({
                            title: 'Eliminar Dolar ' + ids.length + ' item(s) ...',
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
            dtButtonsCenter.push(deleteButton)
        }    
        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            ajax: {
                url: "{{ route('back.divisas.index') }}",
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
                    render: function(data, type, row, meta) {
                        return data.toString().padStart(4, '0');
                    }
                },
                {
                    data: 'fecha',
                    name: 'fecha',
                    type: "date",
                    className: "text-center ",
                    render: DataTable.render.date('DD-MM-YYYY'),
                },
                {
                    data: 'dolar',
                    name: 'dolar',
                    type: 'numeric',
                    className: "text-center ",
                    render: DataTable.render.number(null, null, 2),
                },
                {
                    data: 'variacion_dolar',
                    name: 'variacion_dolar',
                    searchable: false,
                    className: "text-center ",
                    render: function(data, type, row, meta) {
                        if (data == 0) {
                            return data+'%   ' +'<i class="bi bi-arrows" style="color: yellow;font-size: 20px;"></i>';
                        }; 
                        if (data > 0) {
                            return data+'%   ' +'<i class="bi bi-arrow-up" style="color:green;font-size:20px;"></i>';
                        }; 
                        if (data < 0) {
                            return data+'%   '+'<i class="bi bi-arrow-down" style="color:red; font-size:20px;"></i>';
                        };                            
                    },
                },
                {
                    data: 'euro',
                    name: 'euro',
                    type: 'numeric',
                    className: "text-center ",
                    render: DataTable.render.number(null, null, 2),
                },
                {
                    data: 'variacion_euro',
                    name: 'variacion_euro',
                    searchable: false,
                    className: "text-center ",
                    render: function(data, type, row, meta) {
                        if (data == 0) {
                            return data+'%   ' +'<i class="bi bi-arrows" style="color: yellow;font-size: 20px;"></i>';
                        }; 
                        if (data > 0) {
                            return data+'%   ' +'<i class="bi bi-arrow-up" style="color:green;font-size:20px;"></i>';
                        }; 
                        if (data < 0) {
                            return data+'%   '+'<i class="bi bi-arrow-down" style="color:red; font-size:20px;"></i>';
                        };                            
                    },
                }                
            ],
            select: {
                selector: 'td:not(.no-select)',
            },
            ordering: true,
            order: [
                [1, 'desc']
            ],
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
