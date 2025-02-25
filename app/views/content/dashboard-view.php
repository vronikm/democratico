<?php
	use app\controllers\dashboardController;
	$insDashboard = new dashboardController();

	$alumnosActivosSedeL=$insDashboard->obtenerAlumnosActivosSedeL();	
	$alumnosActivosSedeC=$insDashboard->obtenerAlumnosActivosSedeC();
	$alumnosActivosSedeV=$insDashboard->obtenerAlumnosActivosSedeV();

	$alumnosInactivosSedeL=$insDashboard->obtenerAlumnosInactivosSedeL();	
	$alumnosInactivosSedeC=$insDashboard->obtenerAlumnosInactivosSedeC();
	$alumnosInactivosSedeV=$insDashboard->obtenerAlumnosInactivosSedeV();

	
	if($alumnosActivosSedeL->rowCount()>0){
		$alumnosActivosSedeL=$alumnosActivosSedeL->fetch();
		$totalActivosSedeL=$alumnosActivosSedeL["totalActivosSedeL"];
	}else{
		$totalActivosSedeL= 0;
	}

	if($alumnosActivosSedeC->rowCount()>0){
		$alumnosActivosSedeC=$alumnosActivosSedeC->fetch();
		$totalActivosSedeC=$alumnosActivosSedeC["totalActivosSedeC"];
	}else{
		$totalActivosSedeC= 0;
	}

	if($alumnosActivosSedeV->rowCount()>0){
		$alumnosActivosSedeV=$alumnosActivosSedeV->fetch();
		$totalActivosSedeV=$alumnosActivosSedeV["totalActivosSedeV"];
	}else{
		$totalActivosSedeV= 0;
	}

	if($alumnosInactivosSedeL->rowCount()>0){
		$alumnosInactivosSedeL=$alumnosInactivosSedeL->fetch();
		$totalInactivosSedeL=$alumnosInactivosSedeL["totalInactivosSedeL"];
	}else{
		$totalInactivosSedeL= 0;
	}

	if($alumnosInactivosSedeC->rowCount()>0){
		$alumnosInactivosSedeC=$alumnosInactivosSedeC->fetch();
		$totalInactivosSedeC=$alumnosInactivosSedeC["totalInactivosSedeC"];
	}else{
		$totalInactivosSedeC= 0;
	}

	if($alumnosInactivosSedeV->rowCount()>0){
		$alumnosInactivosSedeV=$alumnosInactivosSedeV->fetch();
		$totalInactivosSedeV=$alumnosInactivosSedeV["totalInactivosSedeV"];
	}else{
		$totalInactivosSedeV= 0;
	}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo APP_NAME; ?>| Dashboard</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- JQVMap -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/plugins/jqvmap/jqvmap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/dist/css/adminlte.css">
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
				<h1 class="m-0">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item active">Dashboard v1</li>
				</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
			<!-- Small boxes (Stat box) -->
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">SEDE LOJA</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-lg-3 col-6">
							<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
									<h3><?php echo $totalActivosSedeL; ?></h3>
									
									<p>Afiliados activos</p>
									</div>
									<div class="icon">
									<i class="ion ion-person"></i>
									</div>
									<a href="<?php echo APP_URL;?>afiliadoList/" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-warning">
									<div class="inner">
										<h3><?php echo $totalInactivosSedeL; ?></h3>
										<p>Afiliados inactivos</p>
									</div>
									<div class="icon">
										<i class="ion ion-android-warning"></i>
									</div>
									<a href="<?php echo APP_URL;?>pagosList/" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
						</div>
					</div>
				</div>
				<!-- ./col -->
			</div><!-- /.container-fluid -->
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
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

	<!-- Bootstrap 4 -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- ChartJS -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/chart.js/Chart.min.js"></script>
	<!-- Sparkline -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/sparklines/sparkline.js"></script>
	<!-- JQVMap -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/jqvmap/jquery.vmap.min.js"></script>
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- daterangepicker -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/moment/moment.min.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo APP_URL; ?>app/views/dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo APP_URL; ?>app/views/dist/js/adminlte.js"></script>

	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="<?php echo APP_URL; ?>app/views/dist/js/pages/dashboard.js"></script>

	<script src="<?php echo APP_URL; ?>app/views/js/ajax.js" ></script>
	<script src="<?php echo APP_URL; ?>app/views/js/main.js" ></script>	
	<script src="<?php echo APP_URL; ?>app/views/dist/js/sweetalert2.all.min.js" ></script>
  </body>
</html>