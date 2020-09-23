<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>



<div class="container">
       <div class="row">
           <div class="col-lg-12 bg-light shadow-lg rounded">

           <div class="col-auto text-center p-3 mb-3">
                            <h1 class="font text-success  ">LISTADO DE USUARIOS
                            </h1>
                            <!-- <p class="lead p-3 ">Ingrese los resultados del analisis del suelo obtenido para brindar recomendaciones para su cultivo.</p> -->
                        </div>
           <div class="col-auto table-responsive">
            <table id="tablaTodosUsuarios" class="table table-hover dt-responsive nowrap" style="width:100%">
                <thead class="thead-dark text-uppercase">
                 <tr class="text-center">
                    <th>id</th>
                    <th>email </th>
                    <th>nombre</th>
                    <th>apellido </th>
                    <th>telefono</th>                    
                </tr>
                </thead>
                <tbody class="bg-light"> 
                    <?php while($usuario = $todos_los_usuarios->fetch_object()):// recorre como un arreglo, guarda cada usuario en la variable $usuario?>
                    <tr class="text-center">
                        <td>
                            <?=$usuario->id?> 
                        </td>                        
                        <td>
                            <?=$usuario->email ?>
                        </td>
                        <td>
                            <?=$usuario->nombre ?>
                        </td>
                        <td>
                            <?=$usuario->apellido ?>
                        </td>
                        <td>
                            <?=$usuario->telefono?>
                        </td>                                              
                      
                    </tr>
                <?php endwhile; ?>

                </tbody>
                <tfoot class="thead-dark text-uppercase">
                    <tr class="text-center">
                        <th>id</th>
                        <th>email </th>
                        <th>nombre</th>
                        <th>apellido </th>
                        <th>telefono</th> 
                    </tr>
                </tfoot>
            </table>
            </div>
           </div>
       </div> 
    </div>

<?php require_once 'views/layout/footer.php'; ?>
    
    <script>
      $(document).ready(function() {
          $('#tablaTodosUsuarios').DataTable({
            dom: 'Bfrtilp',
            buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            titleAttr: 'Exportar a Excel',
            title: 'Exportacion de datos - usuarios - ARCOIRISFRUTAL',
            text: '<i class="far fa-file-excel"></li>',
            className: 'btn btn-success'
            } ],
            language: {
          "decimal":        "",
          "emptyTable":     "No hay datos disponibles en la tabla",
          "info":           "Mostrando _START_ para _END_ de _TOTAL_ entradas",
          "infoEmpty":      "Mostrando 0 para 0 de 0 entradas",
          "infoFiltered":   "(Filtrando desde _MAX_ total entradas)",
          "infoPostFix":    "",
          "thousands":      ",",
          "lengthMenu":     "Mostrando _MENU_ entradas",
          "loadingRecords": "Cargando...",
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "zeroRecords":    "No se encontraron registros coincidentes",
          "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
            }
            }
          });
      });
    </script> 

