<?php
	use app\controllers\afiliadoController;
	$insAfiliado = new afiliadoController();	

	if(isset($_POST['afiliado_sedeid'])){
		$afiliado_sedeid = $insAfiliado->limpiarCadena($_POST['afiliado_sedeid']);		
	} ELSE{
		$afiliado_sedeid = "";		
	}

	if(isset($_POST['afiliado_identificacion'])){
		$afiliado_identificacion = $insAfiliado->limpiarCadena($_POST['afiliado_identificacion']);
	} ELSE{
		$afiliado_identificacion = "";
	}

	if(isset($_POST['afiliado_nombre1'])){
		$afiliado_primernombre = $insAfiliado->limpiarCadena($_POST['afiliado_nombre1']);
	} ELSE{
		$afiliado_primernombre = "";
	}

	if(isset($_POST['afiliado_apellido1'])){
		$afiliado_apellidopaterno = $insAfiliado->limpiarCadena($_POST['afiliado_apellido1']);
	} ELSE{
		$afiliado_apellidopaterno = "";
	}
?>


<html lang="es">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo APP_NAME; ?>| Afiliados</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/fontawesome-free/css/all.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/css/adminlte.css">
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/css/sweetalert2.min.css">
	<script src="<?php echo APP_URL; ?>app/views/dist/js/sweetalert2.all.min.js" ></script>
    
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <?php require_once "app/views/inc/navbar.php"; ?>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <?php require_once "app/views/inc/main-sidebar.php"; ?>
      <!-- /.Main Sidebar Container -->  

      <!-- vista -->
      <div class="content-wrapper">

		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				<h1 class="m-0">Búsqueda de afiliado</h1>
			</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Section listado de alumnos -->
		<section class="content">
			<form action="<?php echo APP_URL."afiliadoList/" ?>" method="POST" autocomplete="off" enctype="multipart/form-data" >			
			<div class="container-fluid">
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Criterios de búsqueda</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>  

					<!-- card-body -->                
					<div class="card-body">
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group">
									<label for="afiliado_identificacion">Identificación</label>                        
									<input type="text" class="form-control" id="afiliado_identificacion" name="afiliado_identificacion" placeholder="Identificación" value="<?php echo $afiliado_identificacion; ?>">
								</div>        
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<label for="afiliado_apellido1">Apellido paterno</label>
									<input type="text" class="form-control" id="afiliado_apellido1" name="afiliado_apellido1" placeholder="Primer apellido" value="<?php echo $afiliado_apellidopaterno; ?>">
								</div>         
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="afiliado_nombre1">Primer nombre</label>
									<input type="text" class="form-control" id="afiliado_nombre1" name="afiliado_nombre1" placeholder="Primer nombre" value="<?php echo $afiliado_primernombre; ?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="afiliado_sedeid">Sede</label>
									<select class="form-control select2" id="afiliado_sedeid" name="afiliado_sedeid">
										<?php
											if($rolid == 1 || $rolid == 2){
												if($afiliado_sedeid == 0){	
													echo "<option value='0' selected='selected'>Todas</option>";
												}else{
													echo "<option value='0'>Todas</option>";	
												}
											}
										?>																		
										<?php echo $insAfiliado->listarSedebusqueda($afiliado_sedeid, $_SESSION['rol'], $_SESSION['usuario']); ?>
									</select>	
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="afiliado_sedeid">.</label>
									<button type="submit" class="form-control btn btn-warning">Buscar</button>
								</div>
							</div>

						</div>
					
					</div>
				</div>
            </div>  
			</form>

			<div class="container-fluid">
			<!-- Small boxes (Stat box) -->
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Resultado de la búsqueda</h3>
						<div class="card-tools">
							<a href="<?php echo APP_URL.'afiliadoListaPDF/'.$afiliado_sedeid; ?> " class="btn btn-success btn-sm" style="margin-right: 10px;" target="_blank"> <i class="fas fa-print"></i> Imprimir</a>
							<a href="<?php echo APP_URL; ?>afiliadoNew/" class="btn btn-warning btn-sm" >Nuevo Afiliado</a>
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>

					<div class="card-body">
						<table id="example1" class="table table-bordered table-striped table-sm">
							<thead>
								<tr>
									<th>Sede</th>	
									<th>Identificación</th>
									<th>Nombres</th>
									<th>Apellidos</th>								
									<th style="width: 220px;">Opciones</<th>
								</tr>
							</thead>
							<tbody>
								<?php 
									echo $insAfiliado->listarAfiliados($afiliado_sedeid, $afiliado_identificacion,$afiliado_apellidopaterno, $afiliado_primernombre); 
								?>								
							</tbody>
						</table>	
					</div>
				</div>
			<!-- /.row -->
			</div><!-- /.container-fluid -->

		</section>
		<!-- /.section -->
      
      </div>
      <!-- /.vista -->

      <?php require_once "app/views/inc/footer.php"; ?>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    
	<!-- jQuery -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- DataTables  & Plugins -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/jszip/jszip.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo APP_URL; ?>app/views/dist/js/adminlte.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/js/ajax.js" ></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/js/main.js" ></script>	
	<script src="<?php echo APP_URL; ?>app/views/dist/js/ajax.js" ></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/js/main.js" ></script>
     <!-- Page specific script -->
	<script>
	$(function () {
		$("#example1").DataTable({
		"responsive": true, "lengthChange": false, "autoWidth": false,
		"language": {
			"decimal": "",
			"emptyTable": "No hay datos disponibles en la tabla",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
			"infoEmpty": "Mostrando 0 a 0 de 0 entradas",
			"infoFiltered": "(filtrado de _MAX_ entradas totales)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar:",
			"zeroRecords": "No se encontraron registros coincidentes",
			"paginate": {
				"first": "Primero",
				"last": "Último",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"aria": {
				"sortAscending": ": activar para ordenar la columna ascendente",
				"sortDescending": ": activar para ordenar la columna descendente"
			},
			"buttons": {
				"copy": "Copiar",
				"print": "Imprimir",
                "text": 'Imprimir Tabla',
                "title": 'Datos de Alumnos',
                "messageTop": 'Generado por el sistema de gestión de alumnos.',
                "messageBottom": 'Página generada automáticamente.',
                customize: function(win) {
                    $(win.document.body)
                        .css('font-family', 'Arial')
                        .css('background-color', '#f3f3f3');

                    // Cambiar el estilo de la tabla impresa
                    $(win.document.body).find('table')
                        .addClass('display')  // Añadir una clase CSS a la tabla impresa
                        .css('font-size', '12pt')
                        .css('border', '1px solid black');

                    // Agregar logotipo al principio
                    $(win.document.body).prepend(
                        '<img src="https://example.com/logo.png" style="position:absolute; top:0; left:0; width:100px;" />'
                    );

                    // Modificar título y agregar estilos CSS adicionales
                    $(win.document.body).find('h1')
                        .css('text-align', 'center')
                        .css('color', '#4CAF50');
				}
			}
		},
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		$('#example2').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
		});
	});
	</script>
  </body> 
</html>








