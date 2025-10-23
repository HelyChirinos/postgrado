$(document).ready(function () {
  
  var checkSearch = [];

  $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
      
      var displayRow = true;
      
      // Skip if no checkbox searches defined
      if ( checkSearch.length > 0 ) { 
      
        var row = table.row(dataIndex).node();

        for (i=0; i<checkSearch.length; i++) {

          // Get checkbox name
          var name = checkSearch[i];
          
          // Find checkbeck in the row by name and get checked property
          var displayRow = $(row).find('input[name="' + name + '"]').prop('checked');

          // If not checked then hide the row and stop processing any other checkbox searches
          if ( displayRow === false  ) {
            break;
          }
        }
      }

      return displayRow;
    }
  );

  // Setup - add a text input to each footer cell
  $('#PluginsTable tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text"  class="form-control" placeholder="Search ' + title + '" />');
  });

  // DataTable
  var table = $('#PluginsTable').DataTable({
    'pageLength': 25,    // where you choose the default number of row displayed
    "initComplete": function () {
      // Apply the search
      //this.api().columns().every( function () {     // If you want to only show certain columns you can use a array, see below : 
      this.api().columns([0]).every(function () {
        var that = this;

        $('#PluginsTable tfoot tr').appendTo('#PluginsTable thead');   // To displays the search boxs at the top instead to the bottom of the table
        $('input', this.footer()).on('keyup change clear', function () {
          if (that.search() !== this.value) {
            that
            .search(this.value)
            .draw();
          }
        });
      });


      // -------------- here we add dropdown selectors filters to specified columns  --------------
      this.api().columns([1]).every(function () {
        var column = this;
        var select = $('<select class="form-control"><option  value=""></option></select>')
        .appendTo($(column.footer()).empty())
        .on('change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
          );

          column
          .search(val ? '^' + val + '$' : '', true, false)
          .draw();
        });

        column.data().unique().sort().each(function (d, j) {
          select.append('<option value="' + d + '">' + d + '</option>');
        });
      });


      // -------------- here we add dropdown selectors specific for preview files  --------------
      this.api().columns([2]).every(function () {
        var column = this;
        var select = $('<select class="form-control"><option  value=""></option></select>')
        .appendTo($(column.footer()).empty())
        .on('change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
          );

          column
          .search(this.value)
          .draw();
        });

        {
          select.append('<option value="jpg">jpg</option>');
          select.append('<option value="png">png</option>');
          select.append('<option value="gif">gif</option>');
          select.append('<option value="mp4">mp4</option>');
        }
      });

      // -------------- here we add checkbox state   --------------
      // Define names based on column index as the key
      // Maybe use clasname or some other mechanism in the thead to make this more programatic
      var checkboxNames = {
        3: 'agree',
        4: 'disagree'
      }
      this.api().columns([3, 4]).every(function () {
        var column = this;
        
        // Get checbox name to apply to checkboxes in the cells
        var name = checkboxNames[ column.index() ];
        var select = $('<input type="checkbox" name="' + name + '">')
        .appendTo($(column.footer()).empty())
        .on('change', function () {
          var name = $(this).attr('name');
          var ischecked = $(this).is(':checked');
          if (ischecked) {
            // Add checkbox name to columns to search
            if ( ! checkSearch.includes(name) ) {
              checkSearch.push(name)
            }
          } else {
            // Remove chckbox name from columns to search
            checkSearch = checkSearch.filter(e => e !== name);
          }
          table.draw();
        });


      });





    },
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]   //Page length options , cf. https://datatables.net/examples/advanced_init/length_menu
  });

});