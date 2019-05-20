<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url ('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/jquery-ui.js') }}" type="text/javascript"></script>

<script src="{{ url ('js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/buttons.print.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/jszip.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ url ('js/pdfmake.min.js') }}" type="text/javascript"></script>-->
<script src="{{ url ('js/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ url ('js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<!--

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
-->
<script>

      $('#table').DataTable(
      {
            dom: 'Bfrtip',
            columnDefs: [
                  {
                  // targets:-1,
                  //  "orderable": false
                  },
                  {
                  //  targets: 1,
                  //  "bVisible": true
                  },
                  {
                  //  targets: [2,6],
                  //  "bVisible": false
                  },
            ],
            buttons: [
                  {
                        extend: 'excel',
                        className: 'btn btn-info',
                        exportOptions: {columns: [ 0, 1, 2, 3]},
                        titleAttr: 'Exportar las Columnas Visibles a Excel',
                        text: 'Excel',
                        init: function(api, node, config) {
                              $(node).removeClass('dt-button')
                        }
                  },
                  {
                        extend: 'pdf',
                        className: 'btn btn-info',
                        exportOptions: {columns: [ 0, 1, 2, 3]},
                        titleAttr: 'Exportar las Columnas Visibles a PDF',
                        text: 'PDF',
                        init: function(api, node, config) {
                              $(node).removeClass('dt-button')
                        }
                  },
                  {
                        extend: 'print',
                        className: 'btn btn-info',
                        exportOptions: {columns: [ 0, 1, 2, 3]},
                        titleAttr: 'Imprimir la Grilla',
                        text: 'Imprimir',
                        init: function(api, node, config) {
                              $(node).removeClass('dt-button')
                        }
                  }
            ],
            //"sDom": '<"top"l>rt<"bottom"ip><"clear">',
            processing: true,
            language: {
                  "url": '{{ asset('js/Spanish.json') }}'
            },
            initComplete: function () {
            this.api().columns().every(function () {
                  var column = this;
                  var input = document.createElement("input");
                  input.setAttribute("class", "col-md-12");
                  $(input).appendTo($(column.header()))
                        .on('change', function () {
                              column.search($(this).val(), false, false, true).draw();
                        });
                  })
            }
      });


      function filePreview(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  jQuery('.nuevaImagen').attr('src', e.target.result)
              }
              reader.readAsDataURL(input.files[0]);
          }
      }

      $("#avatar").change(function () {
          filePreview(this);
      });

    $(document).ready(function(){
          $(function() {
                $( "#tabs" ).tabs();
          });
          $(".fecha").datepicker({
              dateFormat: "dd-mm-yy"
          });
    });
</script>
