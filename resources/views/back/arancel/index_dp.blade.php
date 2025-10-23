@extends('layouts.back')

@section('title')
    &vert; Aranceles
@endsection

@section('content')
<div class="row">
    <div id="aranceles_card" class="card mb-3">
        <div class="card-header text-white bg-primary d-print-none">
            <div class="row">
                <div class="col fs-5 text-center">Aranceles Admin</div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="d-flex justify-content-between p-1">
                <div id="ToolbarLeft"></div>
                <div id="ToolbarCenter"></div>
                <div id="ToolbarRight"></div>
            </div>
            <div class="row">
            <div class="col-2">
     
            </div>
            <div class="col">
                <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" width="4%">ID</th>
                            <th scope="col">Arancel</th>
                            <th scope="col">Monto Venezolano</th>
                            <th scope="col">Monto Extranjero</th>
                            <th scope="col">Fecha Creación</th>
                            <th scope="col">Normativa</th>

                         </tr>
                    </thead>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
        </div>
    </div>
</div>

<div class="row">
    <div id="matricula_card" class="card mb-3">
        <div class="card-header text-white bg-primary d-print-none">
            <div class="row">
                <div class="col fs-5 text-center">Matrículas</div>


            </div>
        </div>

        <div class="card-body p-0">
            <div class="d-flex justify-content-between p-3">
                <div></div>
                <div id="ToolbarCenter2"></div>
                <div></div>

            </div>
            <div class="row">
            <div class="col-2">
     
            </div>
            <div class="col">
                <table id="tableMatricula" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                    <thead class="table-primary">
                        <tr >
                            <th scope="col" width="4%">ID</th>
                            <th scope="col">Nombre Matrícula</th>
                            <th scope="col">Monto Venezolano</th>
                            <th scope="col">Monto Extranjero</th>
                            <th scope="col">Fecha Creación</th>

                         </tr>
                    </thead>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
        </div>
    </div>   
</div>  

<div class="row">
    <div id="paginas_card" class="card mb-5">
        <div class="card-header text-white bg-primary d-print-none">
            <div class="row">
                <div class="col fs-5 text-center">Costos Páginas - Impresión de Programas</div>

            </div>
        </div>

        <div class="card-body p-0">
            <div class="d-flex justify-content-between p-3">
                <div></div>
                <div id="ToolbarCenter3"></div>
                <div></div>

            </div>
            <div class="row">
            <div class="col-2">
     
            </div>
            <div class="col">
                <table id="tablePaginas" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" width="4%">ID</th>
                            <th scope="col">Nº de Páginas</th>
                            <th scope="col">Limite</th>
                            <th scope="col">Costo Venezolano</th>
                            <th scope="col">Costo Extranjero</th>

                         </tr>
                    </thead>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
        </div>
    </div>   
</div>  


@endsection

@push('scripts')
          {{-- DATATABLES ARANCELES --}}
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
                    url: "{{ route('back.aranceles.create')}}",
                    success: function(response) {
                        bootbox.dialog({
                            locale: 'nl',
                            title: 'Nuevo Arancel',
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
                $.ajax({
                    method: 'GET',
                    url: "{{ route('back.aranceles.edit', 'id') }}".replace("id", id),
                    success: function(response) {
                        bootbox.dialog({
                            locale: 'nl',
                            title: 'Editar Arancel',
                            message: response,
                            size: 'lg',
                            onEscape: false,
                            backdrop: false
                        });
                        
                    } 
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
            url: "{{route('back.aranceles.Destroy') }}",
            action: function(e, dt, node, config) {
                let ids = $.map(dt.rows({
                    selected: true
                }).data(), function(entry) {
                    return entry.id;
                });


                if (ids.length > 0) {
                    bootbox.confirm({
                        title: 'Eliminar Arancel ' + ids.length + ' item(s) ...',
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
                                    },
                                    error: function(result) {
                                        alert('Tipo de Error:' + result.status+' '+result.responseText);
                                    }
                                });
                            }
                        }
                    });
                }
            }
        }
        dtButtonsCenter.push(deleteButton)
        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            ajax: {
                url: "{{ route('back.aranceles.index') }}",
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
                    data: 'arancel',
                    name: 'arancel',
                    type: "text",
                    className: "text-center ",

                },
                {
                    data: 'monto_venezolano',
                    name: 'monto_venezolano',
                    type: 'numeric',
                    className: "text-center ",
                    render: DataTable.render.number(null, null, 2 ,null, '' ), 
                },
                {
                    data: 'monto_extranjero',
                    name: 'monto_extranjero',
                    type: 'numeric',
                    className: "text-center ",
                    render: DataTable.render.number(null, null, 2, null, ''),
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
                {
                    data: 'constancia',
                    name: 'constancia',
                    searchable: false,
                    orderable: false, 
                    className: "text-center esSolicitud ",
                    render: function (data, type, full, meta){
                        if(data==1){
                           return '<input type="checkbox" checked>';
                        }else {
                            return '<input type="checkbox" >';
                        }    
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

        oTable.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter');
        /* ------------------------------------------------------------------------ */
        oTable.on('select deselect', function(e, dt, type, indexes) {
            const selectedRows = oTable.rows({
                selected: true
            }).count();

            oTable.buttons('.selectOne').enable(selectedRows === 1);
            oTable.buttons('.selectMultiple').enable(selectedRows > 0);
        });

        $('#sqltable tbody').on('click', 'td.esSolicitud', function() {
            const id = oTable.row($(this).closest("tr")).data().DT_RowId;
            let value = oTable.cell(this).data();
            value = value == 0 ? 1 : 0;
            console.log('ID: '+id);
            $.ajax({
                method: 'POST',
                url: "{{ route('back.arancel.setValueDB') }}",
                data: {
                    id: id,
                    value: value,
                },
                success: function(response) {
                    console.log('El valor: '+response.mensaje);
  
                }
            });
            
        });
        /* ------------------------------------------- */


    </script>

     {{-- DATATABLES MATRICULA --}}

     <script type="module">
        /* ------------------------------------------------------------------------ */

       let dtButtonsCentro = [];

       /* ------------------------------------------------------------------------ */

       let nuevoButton = {
           className: 'btn-success',
           text: '<i class="bi bi-plus"></i>',
           titleAttr: 'Agregar',
           enabled: true,
           action: function(e, dt, node, config) 
           {
               $.ajax({
                   method: 'GET',
                   url: "{{route('back.matriculas.create')}}",
                   success: function(response) {
                       bootbox.dialog({
                           locale: 'nl',
                           title: 'Nueva Matrícula',
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
                   url: "{{ route('back.matriculas.edit', 'id') }}".replace("id", id),

                   success: function(response) {
                       bootbox.dialog({
                           locale: 'nl',
                           title: 'Editar Matrícula',
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


       let eliminarButton = {
           extend: 'selected',
           className: 'btn-danger selectMultiple',
           text: '<i class="bi bi-trash"></i>',
           titleAttr: 'Eliminar',
           enabled: false,
           url: "{{ route('back.matriculas.Destroy') }}",
           action: function(e, dt, node, config) {
               let ids = $.map(dt.rows({
                   selected: true
               }).data(), function(entry) {
                   return entry.id;
               });


               if (ids.length > 0) {
                   bootbox.confirm({
                       title: 'Eliminar Matrícula ' + ids.length + ' item(s) ...',
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
       /* ------------------------------------------------------------------------ */
       let dtGlobalsmatriculas = {
           ajax: {
               url: "{{ route('back.matriculas.index') }}",
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
                   data: 'nombre',
                   name: 'nombre',
                   type: 'text',
                   className: "text-center ",
               },                
               {
                   data: 'monto_venezolano',
                   name: 'monto_venezolano',
                   type: 'numeric',
                   className: "text-center ",
                   render: DataTable.render.number(null, null, 2, null, ''),

               },
               {
                   data: 'monto_extranjero',
                   name: 'monto_extranjero',
                   type: 'numeric',
                   className: "text-center ",
                   render: DataTable.render.number(null, null, 2, null, ''),

               },                                  
               {
                   data: 'created_at',
                   name: 'create_at',
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
               oTableMatricula.columns.adjust();
           },
          
       };
       /* ------------------------------------------- */

       let oTableMatricula = $('#tableMatricula').DataTable(dtGlobalsmatriculas);
       /* ------------------------------------------------------------------------ */
       new $.fn.dataTable.Buttons(oTableMatricula, {
           name: 'BtnGroupCenter',
           buttons: dtButtonsCentro
       });

       oTableMatricula.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter2');
       /* ------------------------------------------------------------------------ */
       oTableMatricula.on('select deselect', function(e, dt, type, indexes) {
           const selectedRows = oTableMatricula.rows({
               selected: true
           }).count();

           oTableMatricula.buttons('.selectOne').enable(selectedRows === 1);
           oTableMatricula.buttons('.selectMultiple').enable(selectedRows > 0);
       });

    </script>

     {{-- DATATABLES PAGINAS-PROGRAMAS --}}

     <script type="module">
        /* ------------------------------------------------------------------------ */

       let dtBotonesCentro = [];

       /* ------------------------------------------------------------------------ */

       let crearBoton = {
           className: 'btn-success',
           text: '<i class="bi bi-plus"></i>',
           titleAttr: 'Agregar',
           enabled: true,
           action: function(e, dt, node, config) 
           {
               $.ajax({
                   method: 'GET',
                   url: "{{route('back.paginas.create')}}",
                   success: function(response) {
                       bootbox.dialog({
                           locale: 'nl',
                           title: 'Nuevo rango de Páginas',
                           message: response,
                           size: 'lg',
                           onEscape: true,
                           backdrop: true
                       });
                   } //success
               }); // ajax               
           }  // action  

       } // nuevoButton

       dtBotonesCentro.push(crearBoton)

       let editarBoton = {
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
                   url: "{{ route('back.paginas.edit', 'id') }}".replace("id", id),

                   success: function(response) {
                       bootbox.dialog({
                           locale: 'nl',
                           title: 'Editar Matrícula',
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
       dtBotonesCentro.push(editarBoton)


       let eliminarBoton = {
           extend: 'selected',
           className: 'btn-danger selectMultiple',
           text: '<i class="bi bi-trash"></i>',
           titleAttr: 'Eliminar',
           enabled: false,
           url: "{{ route('back.paginas.Destroy') }}",
           action: function(e, dt, node, config) {
               let ids = $.map(dt.rows({
                   selected: true
               }).data(), function(entry) {
                   return entry.id;
               });


               if (ids.length > 0) {
                   bootbox.confirm({
                       title: 'Eliminar Rango de Páginas ' + ids.length + ' item(s) ...',
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
       dtBotonesCentro.push(eliminarBoton)
       /* ------------------------------------------------------------------------ */
       let dtGlobalsPaginas = {
           ajax: {
               url: "{{ route('back.paginas.index') }}",
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
                   data: 'paginas',
                   name: 'paginas',
                   type: 'text',
                   className: 'text-center',
               }, 
               {
                   data: 'limite',
                   name: 'limite',
                   type: 'numeric',
                   className: 'text-center',
               },                              
               {
                   data: 'costo_v',
                   name: 'costo_v',
                   type: 'numeric',
                   className: 'text-center',
                   render: DataTable.render.number(null, null, 2, null, ''),

               },
               {
                   data: 'costo_e',
                   name: 'costo_e',
                   type: 'numeric',
                   className: 'text-center',
                   render: DataTable.render.number(null, null, 2, null, ''),

               },                                  

           ],
           select: {
               selector: 'td:not(.no-select)',
           },
           ordering: true,

           preDrawCallback: function(settings) {
               oTablePaginas.columns.adjust();
           },
          
       };
       /* ------------------------------------------- */

       let oTablePaginas = $('#tablePaginas').DataTable(dtGlobalsPaginas);
       /* ------------------------------------------------------------------------ */
    
       new $.fn.dataTable.Buttons(oTablePaginas, {
           name: 'BtnGroupCenter',
           buttons: dtBotonesCentro
       });

       oTablePaginas.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter3');
       /* ------------------------------------------------------------------------ */
       oTablePaginas.on('select deselect', function(e, dt, type, indexes) {
           const selectedRows = oTablePaginas.rows({
               selected: true
           }).count();

           oTablePaginas.buttons('.selectOne').enable(selectedRows === 1);
           oTablePaginas.buttons('.selectMultiple').enable(selectedRows > 0);
       });
   
    </script>

@endpush
