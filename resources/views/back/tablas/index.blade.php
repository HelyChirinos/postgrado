@extends('layouts.back')
@push('style')
<link href="https://cdn.datatables.net/rowgroup/1.5.0/css/rowGroup.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
   
    @can ('Ver Programas') 
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-header text-white bg-primary d-print-none">
                            <div class="row">
                                <div class="col fs-5 text-center">Programas</div>
        
                            </div>
                        </div>
                
                        <div class="card-body ">
                            <div class="d-flex justify-content-between p-1">
                                <div id="ToolbarLeft"></div>
                                <div id="ToolbarCenter"></div>
                                <div id="ToolbarRight"></div>
                            </div>
                            <div class="row">
                            <div class="col">
                                <table id="tablePrograma" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" width="4%">ID</th>
                                            <th scope="col">Programa</th>
                                            <th scope="col">Fecha Creación</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-header text-white bg-primary d-print-none">
                            <div class="row">
                                <div class="col fs-5 text-center">Menciones</div>
                            </div>
                        </div> 
                        <div class="card-body ">
                            <div class="d-flex justify-content-between p-1">
                                <div id="ToolbarLeft2"></div>
                                <div id="ToolbarCenter2"></div>
                                <div id="ToolbarRight2"></div>
                            </div>
                            <div class="row">
                            <div class="col">
                                <table id="tableMencion" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" width="4%">ID</th>
                                            <th scope="col">Programa</th>
                                            <th scope="col">Mencion</th>
                                            <th scope="col">Fecha Creación</th>
                                        </tr>
                                    </thead>
                                </table>
        
                            </div>
                        </div>
                        </div>
                    </div>        </div>
            </div>
    @endcan
    @can ('Ver Cohortes') 
        
            <div class="row mb-2">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="card mb-2">
                        <div class="card-header text-white bg-primary d-print-none">
                            <div class="row">
                                <div class="col fs-5 text-center">COHORTES</div>
        
                            </div>
                        </div>
                
                        <div class="card-body ">
                            <div class="d-flex justify-content-between p-1">
                                <div id="ToolbarLeft"></div>
                                <div id="ToolbarCenter3"></div>
                                <div id="ToolbarRight"></div>
                            </div>
                            <div class="row">
                            <div class="col">
                                <table id="tableCohorte" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" width="4%">ID</th>
                                            <th scope="col">COHORTE</th>
                                            <th scope="col">Modalidad</th>
                                            <th scope="col">Inicio</th>
                                            <th scope="col">Termino</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>       
                <div class="col-md-2"></div>
            </div>
        
        
    @endcan
@endsection

@push('scripts')

<script type="module" src="https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.min.js"></script>
     {{-- DATATABLES PROGRAMAS --}}     
<script type="module">
       const userCanAdd = {{(auth()->user()->can('Agregar Programas')) ? "true" : "false" }};
       const userCanUpdate = {{ auth()->user()->can('Modificar Programas') ? "true" : "false" }};
       const userCanDelete = {{ auth()->user()->can('Eliminar Programas') ? "true" : "false" }};
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
                       url: "{{ route('back.programas.create')}}",
                       success: function(response) {
                           bootbox.dialog({
                               locale: 'nl',
                               title: 'Nuevo Programa',
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
                    const id = dt.row({ selected: true}).data().id;
                    console.log( dt.row().data() );
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.programas.edit', 'id') }}".replace("id", id),

                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Editar Programa',
                                message: response,
                                size: 'lg',
                                onEscape: false,
                                backdrop: false
                            });
                        }, //success
                        error: function(result) 
                        {
                        if (result.status == 422) {
                            $("#help_card").css("display", "none");
                            $('#form_add').find(".print-error-msg").find("ul").html('');
                            $('#form_add').find(".print-error-msg").css('display','block');
                            $.each( result.responseJSON.errors, function( key, value ) {
                                    $('#form_add').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                        } else {
                            alert('Tipo de Error:' + result.status+' '+result.responseText);

                        }
                        }      
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
                url: "{{ route('back.programas.Destroy') }}",
                action: function(e, dt, node, config) {
                    let ids = $.map(dt.rows({
                        selected: true
                    }).data(), function(entry) {
                        return entry.id;
                    });


                    if (ids.length > 0) {
                        bootbox.confirm({
                            title: 'Eliminar Programa ' + ids.length + ' item(s) ...',
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
       let dtGlobalsProgramas = {
           ajax: {
               url: "{{ route('back.programas.datos') }}",
               data: function(d) {}
           },
           order: [[1, 'asc']],
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
                   data: 'programa',
                   name: 'programa',
                   type: 'text',
                   className: "text-center ",
                   render: DataTable.render.number(null, null, 2),
               },                
               {
                   data: 'created_at',
                   name: 'fecha',
                   type: "date",
                   className: "text-center ",
                   render: function(data) {
                       return moment(data).utc().format('DD/MM/YYYY');
                   }
               },



           ],
           select: {
               selector: 'td:not(.no-select)',
           },
           ordering: true,

           preDrawCallback: function(settings) {
               oTable.columns.adjust();
           },
          
       };
       /* ------------------------------------------- */

       let oTable = $('#tablePrograma').DataTable(dtGlobalsProgramas);
       /* ------------------------------------------------------------------------ */
       new $.fn.dataTable.Buttons(oTable, {
           name: 'BtnGroupCenter',
           buttons: dtButtonsCenter
       });

       oTable.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter');
       /* ------------------------------------------------------------------------ */
       oTable.on('select deselect', function(e, dt, type, indexes) {
           const selectedRows = oTable.rows({
               selected: true
           }).count();

           oTable.buttons('.selectOne').enable(selectedRows === 1);
           oTable.buttons('.selectMultiple').enable(selectedRows > 0);
       });


</script>

     {{-- DATATABLES MENCIONES --}}

<script type="module">
        /* ------------------------------------------------------------------------ */
       const userCanAdd = {{(auth()->user()->can('Agregar Programas')) ? "true" : "false" }};
       const userCanUpdate = {{ auth()->user()->can('Modificar Programas') ? "true" : "false" }};
       const userCanDelete = {{ auth()->user()->can('Eliminar Programas') ? "true" : "false" }};

       let dtButtonsCentro = [];

       /* ------------------------------------------------------------------------ */
       if (userCanAdd) { 

            let nuevoButton = {
                className: 'btn-success',
                text: '<i class="bi bi-plus"></i>',
                titleAttr: 'Agregar',
                enabled: true,
                action: function(e, dt, node, config) 
                {
                    $.ajax({
                        method: 'GET',
                        url: "{{route('back.menciones.create')}}",
                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Nuevo Programa',
                                message: response,
                                size: 'lg',
                                onEscape: true,
                                backdrop: true
                            });
                        } //success
                    }); // ajax               
                }  // action  

            } // nuevoButton

            dtButtonsCentro.push(nuevoButton)
       }
        if (userCanUpdate) { 
     
            let editarButton = {
                extend: 'selectedSingle',
                className: 'btn-primary selectOne',
                text: '<i class="bi bi-pencil"></i>',
                titleAttr: 'Editar',
                enabled: false,

                action: function(e, dt, node, config) {
                    const id = dt.row({ selected: true}).data().id;
                    console.log( dt.row({ selected: true}).data() );
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.menciones.edit', 'id') }}".replace("id", id),

                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Editar Programa',
                                message: response,
                                size: 'lg',
                                onEscape: false,
                                backdrop: false
                            });
                        }, //success
                        error: function(result) 
                        {
                        if (result.status == 422) {
                            $("#help_card").css("display", "none");
                            $('#form_add').find(".print-error-msg").find("ul").html('');
                            $('#form_add').find(".print-error-msg").css('display','block');
                            $.each( result.responseJSON.errors, function( key, value ) {
                                    $('#form_add').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                        } else {
                            alert('Tipo de Error:' + result.status+' '+result.responseText);

                        }
                        }      
                            }); // ajax          
                    // document.location.href = '{{ route('back.users.edit', 'id') }}'.replace("id", id);
                } //action
            }
            dtButtonsCentro.push(editarButton)
        }    

        if (userCanDelete) { 
            let eliminarButton = {
                extend: 'selected',
                className: 'btn-danger selectMultiple',
                text: '<i class="bi bi-trash"></i>',
                titleAttr: 'Eliminar',
                enabled: false,
                url: "{{ route('back.menciones.Destroy') }}",
                action: function(e, dt, node, config) {
                    let ids = $.map(dt.rows({
                        selected: true
                    }).data(), function(entry) {
                        return entry.id;
                    });


                    if (ids.length > 0) {
                        bootbox.confirm({
                            title: 'Eliminar Programa ' + ids.length + ' item(s) ...',
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
            dtButtonsCentro.push(eliminarButton)
        }    
       /* ------------------------------------------------------------------------ */
       let dtGlobalsMenciones = {
           ajax: {
               url: "{{ route('back.menciones.datos') }}",
               data: function(d) {}
           },
           order: [[1, 'asc']],
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
                   data: 'programa',
                   name: 'programa',
                   type: 'text',
                   className: "text-center ",
               },                
               {
                   data: 'mencion',
                   name: 'mencion',
                   type: 'text',
                   className: "text-center ",
               },                
               {
                   data: 'fecha',
                   name: 'fecha',
                   type: "date",
                   className: "text-center ",
                   render: function(data) {
                       return moment(data).utc().format('DD/MM/YYYY');
                   }
               },



           ],
            // rowGroup: {
            // dataSrc: 'programa'
            // },   

           select: {
               selector: 'td:not(.no-select)',
           },
           ordering: true,

           preDrawCallback: function(settings) {
               oTableMenc.columns.adjust();
           },
          
       };
       /* ------------------------------------------- */

       let oTableMenc = $('#tableMencion').DataTable(dtGlobalsMenciones);
       /* ------------------------------------------------------------------------ */
       new $.fn.dataTable.Buttons(oTableMenc, {
           name: 'BtnGroupCenter',
           buttons: dtButtonsCentro
       });

       oTableMenc.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter2');
       /* ------------------------------------------------------------------------ */
       oTableMenc.on('select deselect', function(e, dt, type, indexes) {
           const selectedRows = oTableMenc.rows({
               selected: true
           }).count();

           oTableMenc.buttons('.selectOne').enable(selectedRows === 1);
           oTableMenc.buttons('.selectMultiple').enable(selectedRows > 0);
       });

</script>

     {{-- DATATABLES COHORTES --}}
 <script type="module">

        const userCanAddCorte = {{(auth()->user()->can('Agregar Cohortes')) ? "true" : "false" }};
       const userCanUpdateCorte = {{ auth()->user()->can('Modificar Cohortes') ? "true" : "false" }};
       const userCanDeleteCorte = {{ auth()->user()->can('Eliminar Cohortes') ? "true" : "false" }};


        /* ------------------------------------------------------------------------ */
        moment.defineLocale('es', {
            months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
            monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
            weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
            weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
            weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
        })
       let dtButtonsCentral = [];

       /* ------------------------------------------------------------------------ */
        if (userCanAddCorte) { 

            let agregarButton = {
                className: 'btn-success',
                text: '<i class="bi bi-plus"></i>',
                titleAttr: 'Agregar',
                enabled: true,
                action: function(e, dt, node, config) 
                {
                    $.ajax({
                        method: 'GET',
                        url: "{{route('back.cohortes.create')}}",
                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Nuevo Cohorte Académico',
                                message: response,
                                size: 'lg',
                                onEscape: true,
                                backdrop: true
                            });
                        } //success
                    }); // ajax               
                }  // action  

            } // agregarButton

            dtButtonsCentral.push(agregarButton)
        }    
        if (userCanUpdateCorte) { 

            let actualizButton = {
                extend: 'selectedSingle',
                className: 'btn-primary selectOne',
                text: '<i class="bi bi-pencil"></i>',
                titleAttr: 'Editar',
                enabled: false,

                action: function(e, dt, node, config) {
                    const id = dt.row({ selected: true}).data().id;
                    console.log( dt.row({ selected: true}).data() );
                    $.ajax({
                        method: 'GET',
                        url: "{{ route('back.cohortes.edit', 'id') }}".replace("id", id),

                        success: function(response) {
                            bootbox.dialog({
                                locale: 'nl',
                                title: 'Editar Cohorte',
                                message: response,
                                size: 'lg',
                                onEscape: false,
                                backdrop: false
                            });
                        }, //success
                        error: function(result) 
                        {
                        if (result.status == 422) {
                            $("#help_card").css("display", "none");
                            $('#form_add').find(".print-error-msg").find("ul").html('');
                            $('#form_add').find(".print-error-msg").css('display','block');
                            $.each( result.responseJSON.errors, function( key, value ) {
                                    $('#form_add').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                        } else {
                            alert('Tipo de Error:' + result.status+' '+result.responseText);

                        }
                        }      
                            }); // ajax          
                    // document.location.href = '{{ route('back.users.edit', 'id') }}'.replace("id", id);
                } //action
            }
            dtButtonsCentral.push(actualizButton)
        }    
        if (userCanDeleteCorte) { 
            let borrarButton = {
                extend: 'selected',
                className: 'btn-danger selectMultiple',
                text: '<i class="bi bi-trash"></i>',
                titleAttr: 'Eliminar',
                enabled: false,
                url: "{{ route('back.cohortes.Destroy') }}",
                action: function(e, dt, node, config) {
                    let ids = $.map(dt.rows({
                        selected: true
                    }).data(), function(entry) {
                        return entry.id;
                    });


                    if (ids.length > 0) {
                        bootbox.confirm({
                            title: 'Eliminar Cohorte ' + ids.length + ' item(s) ...',
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
            dtButtonsCentral.push(borrarButton)
        }    
       /* ------------------------------------------------------------------------ */
       let dtGlobalsCohortes = {
           ajax: {
               url: "{{ route('back.cohortes.datos') }}",
               data: function(d) {}
           },
           order: [[1, 'asc']],
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
                   data: 'cohorte',
                   name: 'cohorte',
                   type: 'text',
                   className: "text-center ",
               },                
               {
                   data: 'modalidad',
                   name: 'modalidad',
                   type: 'text',
                   className: "text-center ",
               },                
               {
                   data: 'inicio',
                   name: 'inicio',
                   type: "date",
                   className: "text-center ",
                   render: function(data) {

                        moment.locale('es');
                       return moment(data).format('MMMM-YYYY').toUpperCase();
                   }
               },
               {
                   data: 'termino',
                   name: 'termino',
                   type: "date",
                   className: "text-center ",
                   render: function(data) {
                       return moment(data).utc().format('MMMM-YYYY').toUpperCase();
                   }
               },



           ],
            // rowGroup: {
            // dataSrc: 'programa'
            // },   

           select: {
               selector: 'td:not(.no-select)',
           },
           ordering: true,

           preDrawCallback: function(settings) {
               oTableCohorte.columns.adjust();
           },
          
       };
       /* ------------------------------------------- */

       let oTableCohorte = $('#tableCohorte').DataTable(dtGlobalsCohortes);
       /* ------------------------------------------------------------------------ */
       new $.fn.dataTable.Buttons(oTableCohorte, {
           name: 'BtnGroupCentral',
           buttons: dtButtonsCentral
       });

       oTableCohorte.buttons('BtnGroupCentral', null).containers().appendTo('#ToolbarCenter3');
       /* ------------------------------------------------------------------------ */
       oTableCohorte.on('select deselect', function(e, dt, type, indexes) {
           const selectedRows = oTableCohorte.rows({
               selected: true
           }).count();

           oTableCohorte.buttons('.selectOne').enable(selectedRows === 1);
           oTableCohorte.buttons('.selectMultiple').enable(selectedRows > 0);
       });

</script>


@endpush

