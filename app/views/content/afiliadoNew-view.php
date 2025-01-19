<?php
	use app\controllers\afiliadoController;
	$insAfiliado = new afiliadoController();

	$foto = APP_URL.'app/views/dist/img/Logos/logo.png';
	$cantonid=0;
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo APP_NAME; ?> | Registro nuevo afiliado</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/fontawesome-free/css/all.min.css">	
	<!-- daterange picker -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/daterangepicker/daterangepicker.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<!-- BS Stepper -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/bs-stepper/css/bs-stepper.min.css">
	<!-- dropzonejs -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/dropzone/min/dropzone.min.css">	
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/css/adminlte.css">
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/css/sweetalert2.min.css">
	
	<!-- fileinput -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/fileinput/fileinput.css">
	<style>
        .custom-checkbox {
            margin-bottom: 20px; /* Ajusta este valor según el espacio deseado */
        }
    </style>
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
							<h1 class="m-0">Nuevo Afiliado</h1>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">				
				<!-- /.container-fluid información alumno -->
				<div class="container-fluid">						
					<div class="card">
						<div class="card-body">
							<div class="tab-content">
								<!-- Tab de información personal del alumno -->
								<div class="active tab-pane" id="informacionp"> 
									<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/afiliadoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
										<input type="hidden" name="modulo_afiliado" value="registrar">																				

										<!-- Primera sección foto-->
										<div class="row">
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_foto">Foto (250KB)</label>		
													<div class="input-group">											
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 130px; height: 158px;" data-trigger="fileinput"><img src="<?php echo $foto; ?>">
																<img src=""></div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 130px; max-height: 158px"></div>
															<div>
																<span class="bton bton-white bton-file">
																	<span class="fileinput-new">Seleccionar Foto</span>
																	<span class="fileinput-exists">Cambiar</span>
																	<input type="file" name="afiliado_foto" id="foto" accept="image/*">
																</span>
																<a href="#" class="bton bton-orange fileinput-exists" data-dismiss="fileinput">Remover</a>
															</div>
														</div>
													</div>		
												</div>
												<!-- /.form-group -->	
											</div>
											<div class="col-md-10"> 
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="afiliado_identificacion">Identificación</label>                        
															<input type="text" class="form-control" id="afiliado_identificacion" name="afiliado_identificacion" placeholder="Identificación" required="required">
														</div>
													</div>											
													<div class="col-md-4">                        
														<div class="form-group">
															<label for="afiliado_apellido1">Apellido paterno</label>
															<input type="text" class="form-control" id="afiliado_apellido1" name="afiliado_apellido1" placeholder="Primer apellido" required="required">
														</div>
													</div>
													<div class="col-md-4">
														<label for="afiliado_apellido2">Apellido materno</label>
														<input type="text" class="form-control" id="afiliado_apellido2" name="afiliado_apellido2" placeholder="Segundo apellido">
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label for="afiliado_tipoidentificacion">Tipo identificación</label>
															<select id="afiliado_tipoidentificacion" class="form-control select2" name="afiliado_tipoidentificacion">																					
																<?php echo $insAfiliado->listarCatalogoTipoDocumento(); ?>
															</select>
														</div>          
													</div>
													<div class="col-md-4">                        
														<div class="form-group">
															<label for="afiliado_nombre1">Primer nombre</label>
															<input type="text" class="form-control" id="afiliado_nombre1" name="afiliado_nombre1" placeholder="Primer nombre" required="required">
														</div>
													</div>
													<div class="col-md-4">
														<label for="afiliado_nombre2">Segundo nombre</label>
														<input type="text" class="form-control" id="afiliado_nombre2" name="afiliado_nombre2" placeholder="Segundo nombre">
													</div>    
													<div class="col-md-4">
														<div class="form-group">
															<label for="afiliado_nacionalidadid">Nacionalidad</label>
															<select class="form-control select2" style="width: 100%;" id="afiliado_nacionalidadid" name="afiliado_nacionalidadid">
																<?php echo $insAfiliado->listarCatalogoNacionalidad(); ?>
															</select>
														</div> 
													</div>
													<div class="col-md-4">									
														<div class="form-group">
															<label for="afiliado_fechanacimiento">Fecha nacimiento</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
																</div>
																<input type="date" class="form-control" name="afiliado_fechanacimiento" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required="required">
															</div>
														<!-- /.input group -->
														</div>												
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="afiliado_genero">Género</label>
															<div class="form-check">
																<input class="col-sm-1 form-check-input" type="radio" id="afiliado_generoM" name="afiliado_genero" value="M" required="required">
																<label class="col-sm-5 form-check-label" for="afiliado_generoM">Masculino</label>
																<input class="col-sm-1 form-check-input" type="radio" id="afiliado_generoF" name="afiliado_genero" value="F">
																<label class="col-sm-4 form-check-label" for="afiliado_generoF">Femenino</label>
															</div> 
														</div>
													</div>													
												</div>
												<!-- Fin primera sección foto-->
											</div>
										</div> <!--fin col md 10-->

										<!-- Segunda sección foto-->
										<div class="row">										
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_cantonid">Cantón</label>
													<select class="form-control select2" id="afiliado_cantonid" name="afiliado_cantonid" required="required">									
														<?php echo $insAfiliado->listarCatalogoCanton($cantonid); ?>
													</select>	
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_ciudadid">Ciudad</label>
													<select class="form-control select2" id="afiliado_ciudadid" name="afiliado_ciudadid" required="required">									
														<?php echo $insAfiliado->listarCatalogoCiudad(); ?>
													</select>	
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_correo">Correo</label>
													<input type="text" class="form-control" id="afiliado_correo" name="afiliado_correo" placeholder="Correo" required="required">
												</div> 
											</div>											
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_celular">Celular</label>
													<input type="text" class="form-control" id="afiliado_celular" name="afiliado_celular" data-inputmask='"mask": "0999999999"' data-mask placeholder="Celular" required="required">
												</div> 
											</div> 
											<div class="col-md-4">
												<div class="form-group">
													<label for="afiliado_direccion">Dirección</label>
													<textarea class="form-control" id="afiliado_direccion" name="afiliado_direccion" placeholder="Barrio, Calle principal, #casa, calle secundaria"></textarea>
												</div>	
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_sedeid">Sede</label>
													<select class="form-control select2" id="afiliado_sedeid" name="afiliado_sedeid">									
														<?php echo $insAfiliado->listarOptionSede($_SESSION['rol'], $_SESSION['usuario']); ?>
													</select>	
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_fechaafiliacion">Fecha de afiliación</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
														</div>
														<input type="date" class="form-control" name="afiliado_fechaafiliacion" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required="required">
													</div>
												<!-- /.input group -->
												</div>								
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="afiliado_rolid">Rol en el partido</label>
													<select class="form-control select2" id="afiliado_rolid" name="afiliado_rolid">									
														<?php echo $insAfiliado->listarCatalogoRol(); ?>
													</select>	
												</div>
											</div> 
											
											<div class="col-sm-5">
												<!-- checkbox -->	
												<label for="afiliado_redsocial">Redes Sociales</label>
												<div class="d-flex">
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" type="checkbox" id="customCheckboxFace" name="opciones[]" value="Facebook">
														<label for="customCheckboxFace" class="custom-control-label">Facebook</label>				
													</div>
													<div class="custom-control custom-checkbox">									
														<input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckboxInst" name="opciones[]" value="Instagram">
														<label for="customCheckboxInst" class="custom-control-label">Instagram</label>													
													</div>
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input" type="checkbox" id="customCheckboxTik" name="opciones[]" value="Tik tok">
														<label for="customCheckboxTik" class="custom-control-label">Tik Tok</label>												
													</div>
													<div class="custom-control custom-checkbox">
														<input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="customCheckboxYou" name="opciones[]" value="Youtube">
														<label for="customCheckboxYou" class="custom-control-label">Youtube</label>
													</div>
												</div>	
											</div>       
										</div>  <!--./row line 874--> 
										<!-- Fin segunda sección foto-->			
								</div>						
								<div class="card-footer">						
									<button type="submit" class="btn btn-success btn-sm">Guardar</button>
									<button type="reset" class="btn btn-dark btn-sm">Limpiar</button>						
								</div>	
									</form>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</section>
			<!-- /.content -->      
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
	<!-- Select2 -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/select2/js/select2.full.min.js"></script>
	<!-- Bootstrap4 Duallistbox -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<!-- InputMask -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/moment/moment.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/inputmask/jquery.inputmask.min.js"></script>
	<!-- date-range-picker -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap color picker -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Bootstrap Switch -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
	<!-- BS-Stepper -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/bs-stepper/js/bs-stepper.min.js"></script>
	<!-- dropzonejs -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/dropzone/min/dropzone.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo APP_URL; ?>app/views/dist/js/adminlte.min.js"></script>		
	<script src="<?php echo APP_URL; ?>app/views/dist/js/ajax.js" ></script>
	<script src="app/views/dist/js/main.js" ></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/js/sweetalert2.all.min.js" ></script>
	
	<!-- fileinput -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/fileinput/fileinput.js"></script>
    
	<script>
		$(function () {
			//Initialize Select2 Elements
			$('.select2').select2()

			//Initialize Select2 Elements
			$('.select2bs4').select2({
			theme: 'bootstrap4'
			})

			//Datemask dd/mm/yyyy
			$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
			//Datemask2 mm/dd/yyyy
			$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
			//Money Euro
			$('[data-mask]').inputmask()

			//Date picker
			$('#reservationdate').datetimepicker({
				format: 'L'
			});

			//Date and time picker
			$('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

			//Date range picker
			$('#reservation').daterangepicker()
			//Date range picker with time picker
			$('#reservationtime').daterangepicker({
			timePicker: true,
			timePickerIncrement: 30,
			locale: {
				format: 'MM/DD/YYYY hh:mm A'
			}
			})
			//Date range as a button
			$('#daterange-btn').daterangepicker(
			{
				ranges   : {
				'Today'       : [moment(), moment()],
				'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month'  : [moment().startOf('month'), moment().endOf('month')],
				'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(29, 'days'),
				endDate  : moment()
			},
			function (start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
			}
			)

			//Timepicker
			$('#timepicker').datetimepicker({
			format: 'LT'
			})

			//Bootstrap Duallistbox
			$('.duallistbox').bootstrapDualListbox()

			//Colorpicker
			$('.my-colorpicker1').colorpicker()
			//color picker with addon
			$('.my-colorpicker2').colorpicker()

			$('.my-colorpicker2').on('colorpickerChange', function(event) {
			$('.my-colorpicker2 .fa-square').css('color', event.color.toString());
			})

			$("input[data-bootstrap-switch]").each(function(){
			$(this).bootstrapSwitch('state', $(this).prop('checked'));
			})

		})
		// BS-Stepper Init
		document.addEventListener('DOMContentLoaded', function () {
			window.stepper = new Stepper(document.querySelector('.bs-stepper'))
		})

		// DropzoneJS Demo Code Start
		Dropzone.autoDiscover = false

		// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
		var previewNode = document.querySelector("#template")
		previewNode.id = ""
		var previewTemplate = previewNode.parentNode.innerHTML
		previewNode.parentNode.removeChild(previewNode)

		var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
			url: "/target-url", // Set the url
			thumbnailWidth: 80,
			thumbnailHeight: 80,
			parallelUploads: 20,
			previewTemplate: previewTemplate,
			autoQueue: false, // Make sure the files aren't queued until manually added
			previewsContainer: "#previews", // Define the container to display the previews
			clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
		})

		myDropzone.on("addedfile", function(file) {
			// Hookup the start button
			file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
		})

		// Update the total progress bar
		myDropzone.on("totaluploadprogress", function(progress) {
			document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
		})

		myDropzone.on("sending", function(file) {
			// Show the total progress bar when upload starts
			document.querySelector("#total-progress").style.opacity = "1"
			// And disable the start button
			file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
		})

		// Hide the total progress bar when nothing's uploading anymore
		myDropzone.on("queuecomplete", function(progress) {
			document.querySelector("#total-progress").style.opacity = "0"
		})

		// Setup the buttons for all transfers
		// The "add files" button doesn't need to be setup because the config
		// `clickable` has already been specified.
		document.querySelector("#actions .start").onclick = function() {
			myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
		}
		document.querySelector("#actions .cancel").onclick = function() {
			myDropzone.removeAllFiles(true)
		}
		// DropzoneJS Demo Code End
	</script>
  </body>
</html>