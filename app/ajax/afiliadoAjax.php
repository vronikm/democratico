<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\afiliadoController;

	if(isset($_POST['modulo_afiliado'])){

		$insafiliado = new afiliadoController();

		if($_POST['modulo_afiliado']=="registrar"){
			echo $insafiliado->registrarAfiliadoControlador();
		}

		if($_POST['modulo_afiliado']=="eliminar"){
			echo $insafiliado->eliminarAfiliadoControlador();
		}

		if($_POST['modulo_afiliado']=="actualizar"){
			echo $insafiliado->actualizarAfiliadoControlador();
		}

		if($_POST['modulo_afiliado']=="actualizarestado"){
			echo $insafiliado->actualizarEstadoAfiliadoControlador();
		}

		if($_POST['modulo_afiliado']=="eliminarFoto"){
			echo $insafiliado->eliminarFotoAfiliadoControlador();
		}

		if($_POST['modulo_afiliado']=="actualizarFoto"){
			echo $insafiliado->actualizarFotoAfiliadoControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}