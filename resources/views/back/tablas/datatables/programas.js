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
                   data: 'nombre',
                   name: 'nombre',
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
