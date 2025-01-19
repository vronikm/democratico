<?php
	use app\controllers\afiliadoController;
	$insAfiliado = new afiliadoController();	

	$afiliadoid=$insAfiliado->limpiarCadena($url[1]);

	$datos=$insAfiliado->seleccionarDatos("Unico","sujeto_afiliado","afiliado_id",$afiliadoid);

	if($datos->rowCount()==1){
		$datos=$datos->fetch();
		if ($datos['afiliado_imagen']!=""){
			$foto = APP_URL.'app/views/imagenes/fotos/afiliado/'.$datos['afiliado_imagen'];
		}else{
			$foto = APP_URL.'app/views/dist/img/foto.jpg';
		}
		if ($datos['afiliado_genero']=='M'){
			$afiliado_generoM = "checked";
		}else{
			$afiliado_generoM = "";
		}

		if ($datos['afiliado_genero']=='F'){
			$afiliado_generoF = "checked";
		}else{
			$afiliado_generoF = "";
		}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo APP_NAME; ?> | Ficha afiliado</title>

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
	<script src="<?php echo APP_URL; ?>app/views/dist/js/sweetalert2.all.min.js" ></script>

	<!-- fileinput -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/fileinput/fileinput.css">
    
	<style>
		input:invalid {
		  box-shadow: 0 0 2px 1px red;
		}
		input:focus:invalid {
		  box-shadow: none;
		}
		textarea:invalid {
		  box-shadow: 0 0 2px 1px red;
		}
		textarea:focus:invalid {
		  box-shadow: none;
		}
	</style>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

		<!-- Preloader -->
		<!--?php require_once "app/views/inc/preloader.php"; ?-->
		<!-- /.Preloader -->

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
							<h1 class="m-0">Actualizar afiliado</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Inicio</a></li>
								<li class="breadcrumb-item active">Ficha afiliado</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">				
				<!-- /.container-fluid información afiliado -->
				<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/afiliadoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data" >
				<input type="hidden" name="modulo_afiliado" value="actualizar">
				<input type="hidden" name="afiliado_id" value="<?php echo $datos['afiliado_id']; ?>">
				<div class="container-fluid">						
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item"><a class="nav-link active" href="#informacionp" data-toggle="tab">Información Personal</a></li>
								<li class="nav-item"><a class="nav-link" href="#cedula" data-toggle="tab">Cédula</a></li>
								<li class="nav-item"><a class="nav-link" href="#contactoem" data-toggle="tab">Contacto emergencia</a></li>											
								<li class="nav-item"><a class="nav-link" href="#informacionm" data-toggle="tab">Información Médica</a></li>
							</ul>
						</div><!-- /.card-header -->
					
						<div class="card-body">
							<div class="tab-content">
								<!-- Tab de información personal del afiliado -->
								<div class="active tab-pane" id="informacionp"> 
									<!-- Primera sección foto-->
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label for="afiliado_imagen">Foto (250KB)</label>		
												<div class="input-group">											
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" style="width: 130px; height: 158px;" data-trigger="fileinput">
															<img src="<?php echo $foto; ?>"></div>
														<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 130px; max-height: 158px"></div>
														<div>
															<span class="bton bton-white bton-file">
																<span class="fileinput-new">Seleccionar Foto</span>
																<span class="fileinput-exists">Cambiar</span>
																<input type="file" name="afiliado_imagen" id="foto" accept="image/*">
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
														<input type="text" class="form-control" id="afiliado_identificacion" name="afiliado_identificacion" value="<?php echo $datos['afiliado_identificacion']; ?>" required>
													</div>
												</div>											
												<div class="col-md-4">                        
													<div class="form-group">
														<label for="afiliado_apellido1">Apellido paterno</label>
														<input type="text" class="form-control" id="afiliado_apellido1" name="afiliado_apellido1" value="<?php echo $datos['afiliado_apellidopaterno']; ?>" required>
													</div>
												</div>
												<div class="col-md-4">
													<label for="afiliado_apellido2">Apellido materno</label>
													<input type="text" class="form-control" id="afiliado_apellido2" name="afiliado_apellido2" value="<?php echo $datos['afiliado_apellidomaterno']; ?>">
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="afiliado_tipoidentificacion">Tipo identificación</label>
														<select id="afiliado_tipoidentificacion" class="form-control select2" name="afiliado_tipoidentificacion">																					
															<?php echo $insAfiliado->listarOptionTipoIdentificacion($datos['afiliado_tipoidentificacion']); ?>
														</select>
													</div>          
												</div>
												<div class="col-md-4">                        
													<div class="form-group">
														<label for="afiliado_nombre1">Primer nombre</label>
														<input type="text" class="form-control" id="afiliado_nombre1" name="afiliado_nombre1" value="<?php echo $datos['afiliado_primernombre']; ?>" required>
													</div>
												</div>
												<div class="col-md-4">
													<label for="afiliado_nombre2">Segundo nombre</label>
													<input type="text" class="form-control" id="afiliado_nombre2" name="afiliado_nombre2" value="<?php echo $datos['afiliado_segundonombre']; ?>">
												</div>    
												<div class="col-md-4">
													<div class="form-group">
														<label for="afiliado_nacionalidadid">Nacionalidad</label>
														<select class="form-control select2" style="width: 100%;" id="afiliado_nacionalidadid" name="afiliado_nacionalidadid">
															<?php echo $insAfiliado->listarOptionNacionalidad($datos['afiliado_nacionalidadid']); ?>
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
															<input type="date" class="form-control" name="afiliado_fechanacimiento" value="<?php echo $datos['afiliado_fechanacimiento']; ?>" required>
														</div>
													<!-- /.input group -->
													</div>												
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="afiliado_fechaingreso">Fecha ingreso</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
															</div>
															<input type="date" class="form-control" name="afiliado_fechaingreso" value="<?php echo $datos['afiliado_fechaingreso']; ?>" required>
														</div>
													<!-- /.input group -->
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
												<label for="Numcamiseta">Número de camiseta</label>
												<input type="text" class="form-control" id="afiliado_numcamiseta" name="afiliado_numcamiseta" value="<?php echo $datos['afiliado_numcamiseta']; ?>"> 
											</div>
										</div>  
										<div class="col-md-2">
											<div class="form-group">
												<label for="afiliado_sedeid">Sede</label>
												<select class="form-control select2" id="afiliado_sedeid" name="afiliado_sedeid">									
													<?php echo $insAfiliado->listarSedeafiliado($datos['afiliado_sedeid']); ?>
												</select>	
											</div>
										</div> 
										<div class="col-md-3">
											<div class="form-group">
												<label for="afiliado_direccion">Dirección</label>
												<input type="text" class="form-control" id="afiliado_direccion" name="afiliado_direccion" value="<?php echo $datos['afiliado_direccion']; ?>">
											</div>	
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="afiliado_hermanos">Tiene hermanos?</label>
												<!-- radio -->
												<div class="form-check">
													<input class="col-sm-1 form-check-input" type="radio" id="afiliado_hermanosSi" name="afiliado_hermanos" value="S" <?php echo $afiliado_hermanosSi; ?> required>
													<label class="col-sm-6 form-check-label" for="afiliado_hermanosSi">Si</label>
													<input class="col-sm-1 form-check-input" type="radio" id="afiliado_hermanosNo" name="afiliado_hermanos" value="N" <?php echo $afiliado_hermanosNo; ?>>
													<label class="col-sm-4 form-check-label" for="afiliado_hermanosNo">No</label>
												</div>
											</div>
										</div>	  
										<div class="col-md-3">
											<div class="form-group">
												<label for="afiliado_genero">Sexo</label>
												<div class="form-check">
													<input class="col-sm-1 form-check-input" type="radio" id="afiliado_generoM" name="afiliado_genero" value="M" <?php echo $afiliado_generoM; ?> required>
													<label class="col-sm-5 form-check-label" for="afiliado_generoM">Masculino</label>
													<input class="col-sm-1 form-check-input" type="radio" id="afiliado_generoF" name="afiliado_genero" value="F" <?php echo $afiliado_generoF; ?>>
													<label class="col-sm-4 form-check-label" for="afiliado_generoF">Femenino</label>
												</div> 
											</div>
										</div>   
									</div>  <!--./row line 874--> 
									<!-- Fin segunda sección foto-->			
								</div>

								<!-- Tab de información médica del afiliado -->
								<div class="tab-pane" id="informacionm">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="infomedic_tiposangre">Tipo de sangre</label>
												<input type="text" class="form-control" id="infomedic_tiposangre" name="infomedic_tiposangre" value="<?php echo $tipo_sangre;?>" >                          
											</div>
										</div> 
										<div class="col-md-3">
											<div class="form-group">
												<label for="Peso">Peso (Kg)</label>
												<input type="text" class="form-control" id="infomedic_peso" name="infomedic_peso"  value="<?php echo $peso;?>" >                          
											</div>
										</div>   
										<div class="col-md-3">
											<div class="form-group">
												<label for="Talla">Talla (cm)</label>
												<input type="text" class="form-control" id="infomedic_talla" name="infomedic_talla"  value="<?php echo $talla;?>" >                          
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="Enfermedad">Enfermedad diagnosticada</label>
												<input type="text" class="form-control" id="infomedic_enfermedad" name="infomedic_enfermedad"  value="<?php echo $enfermedad;?>" >                          
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="Medicamentos">Medicamentos</label>
												<input type="text" class="form-control" id="infomedic_medicamentos" name="infomedic_medicamentos"  value="<?php echo $medicamentos;?>" >                          
											</div>
										</div> 
										<div class="col-md-3">
											<div class="form-group">
												<label for="Alergia1">Alergia a medicamentos</label>
												<input type="text" class="form-control" id="infomedic_alergia1" name="infomedic_alergia1"  value="<?php echo $alergia1;?>" >                          
											</div>
										</div> 
										<div class="col-md-3">
											<div class="form-group">
												<label for="Alergia2">Alergia a objetos</label>
												<input type="text" class="form-control" id="infomedic_alergia2" name="infomedic_alergia2"  value="<?php echo $alergia2;?>" >                          
											</div>
										</div>  
										<div class="col-md-3">
											<div class="form-group">
												<label for="Cirugias">Cirugías</label>
												<input type="text" class="form-control" id="infomedic_cirugias" name="infomedic_cirugias"  value="<?php echo $cirugias;?>" >                          
											</div>
										</div>  
										<div class="col-md-3">
											<div class="form-group">
												<label for="Observacion">Observación</label>
												<input type="text" class="form-control" id="infomedic_observacion" name="infomedic_observacion"  value="<?php echo $observacion;?>" >                          
											</div>
										</div>  
										<div class="col-md-3">
											<div class="form-group">
												<label for="Covid">Carnet vacunación Covid</label>
												<div class="form-check">
													<input class="col-sm-1 form-check-input" type="radio" id="infomedic_covidSi" name="infomedic_covid" value="S" <?php echo $infomedic_covidSi;?> > 
													<label class="col-sm-6 form-check-label" for="infomedic_covidSi">Si</label>
													<input class="col-sm-1 form-check-input" type="radio" id="infomedic_covidNo" name="infomedic_covid" value="N" <?php echo $infomedic_covidNo;?> >
													<label class="col-sm-4 form-check-label" for="infomedic_covidNo">No</label>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Vacunas">Carnet vacunación habitual</label>
												<div class="form-check">
													<input class="col-sm-1 form-check-input" type="radio" id="infomedic_vacunasSi" name="infomedic_vacunas" value="S" <?php echo $infomedic_vacunasSi;?> > 
													<label class="col-sm-6 form-check-label" for="infomedic_vacunasSi">Si</label>
													<input class="col-sm-1 form-check-input" type="radio" id="infomedic_vacunasNo" name="infomedic_vacunas" value="N" <?php echo $infomedic_vacunasNo;?> >
													<label class="col-sm-4 form-check-label" for="infomedic_vacunasNo">No</label>
												</div>                         
											</div>
										</div>  
									</div>
								</div>

								<!-- Tab información contacto de emergencia -->
								<div class="tab-pane" id="contactoem">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="CEmergencia">Celular</label>
												<input type="text" class="form-control" id="cemer_celular" name="cemer_celular" value="<?php echo $cemer_celular;?>" >                          
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="Nomcontactoemer">Nombre contacto</label>
												<input type="text" class="form-control" id="cemer_nombre" name="cemer_nombre" value="<?php echo $cemer_nombre;?>" >                          
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="cemer_parentesco">Parentesco</label>
												<select class="form-control select2" style="width: 100%;" id="cemer_parentesco" name="cemer_parentesco" >
													<?php echo $insAfiliado->listarOptionParentesco($cemer_parentesco); ?>
												</select>
											</div> 
										</div>
									</div>		
								</div>
								
								<!-- Tab cedula del afiliado -->
								<div class="tab-pane" id="cedula">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="afiliado_cedulaA">Anverso</label>		
												<div class="input-group">											
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" style="width: 330px; height: 210px;" data-trigger="fileinput">
															<img src="<?php echo $cedulaA; ?>"></div>
														<div class="fileinput-preview fileinput-exists thumbnail" style="width: 330px; height: 210px"></div>
														<div>
															<span class="bton bton-white bton-file">
																<span class="fileinput-new">Imagen</span>
																<span class="fileinput-exists">Cambiar</span>
																<input type="file" name="afiliado_cedulaA" id="foto" accept="image/*">
															</span>
															<a href="#" class="bton bton-orange fileinput-exists" data-dismiss="fileinput">Remover</a>
														</div>
													</div>
												</div>		
											</div>
											<!-- /.form-group -->	
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="afiliado_cedulaR">Reverso</label>		
												<div class="input-group">											
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" style="width: 330px; height: 210px;" data-trigger="fileinput">
															<img src="<?php echo $cedulaR; ?>"></div>
														<div class="fileinput-preview fileinput-exists thumbnail" style="width: 330px; height: 210px"></div>
														<div>
															<span class="bton bton-white bton-file">
																<span class="fileinput-new">Imagen</span>
																<span class="fileinput-exists">Cambiar</span>
																<input type="file" name="afiliado_cedulaR" id="foto" accept="image/*">
															</span>
															<a href="#" class="bton bton-orange fileinput-exists" data-dismiss="fileinput">Remover</a>
														</div>
													</div>
												</div>		
											</div>
											<!-- /.form-group -->	
										</div>
									</div>
								</div>
								<!-- /.tab-pane -->

							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
					
				</div>
				<div class="card-footer">						
					<button type="submit" class="btn btn-success btn-sm">Actualizar</button>														
				</div>	
				</form>
			</section>
			<!-- /.content -->    
			
			<?php
				}else{
					include "./app/views/inc/error_alert.php";
				}
			?>
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

	<!--script src="app/views/dist/js/main.js" ></script-->
	
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