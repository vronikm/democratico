<?php

	namespace app\controllers;
	use app\models\mainModel;
	
	class loginController extends mainModel{

		/*----------  Controlador iniciar sesion  ----------*/
		public function iniciarSesionControlador(){

			$usuario=$this->limpiarCadena($_POST['login_usuario']);
		    $clave=$this->limpiarCadena($_POST['login_clave']);

		    # Verificando campos obligatorios #
		    if($usuario=="" || $clave==""){
		        echo "<script>
			        Swal.fire({
					  icon: 'error',
					  title: 'Ocurrió un error inesperado',
					  text: 'No has llenado todos los campos que son obligatorios'
					});
				</script>";
		    }else{

			    # Verificando integridad de los datos #
			    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)){
			        echo "<script>
				        Swal.fire({
						  icon: 'error',
						  title: 'Ocurrió un error inesperado',
						  text: 'El USUARIO no coincide con el formato solicitado'
						});
					</script>";
			    }else{

			    	# Verificando integridad de los datos #
				    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
				        echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ocurrió un error inesperado',
							  text: 'La CLAVE no coincide con el formato solicitado'
							});
						</script>";
				    }else{

					    # Verificando usuario #
					    $check_usuario=$this->ejecutarConsulta("SELECT usuario_id, usuario_identificacion, usuario_nombre, usuario_correo, usuario_movil, 
																				usuario_foto, sede_nombre AS Sede, usuario_estado, usuario_cambiaclave, usuario_usuario, 
																				usuario_fechacreacion, usuario_fechaactualizado, usuario_rolid, usuario_clave, usuario_tienebloqueo
																		  	FROM seguridad_usuario U 
																			LEFT JOIN general_sede ON usuario_sedeid = sede_id 
																			WHERE usuario_usuario ='$usuario'");

					    if($check_usuario->rowCount()==1){
					    	$check_usuario=$check_usuario->fetch();
							if($check_usuario['usuario_estado']=='I'){
								echo "<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Usuario inactivo',
									  text: 'Contacte al administrador del sistema'
									});
								</script>";
							}elseif ($check_usuario['usuario_tienebloqueo']=='S'){
								echo "<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Usuario bloqueado',
									  text: 'Contacte al administrador del sistema'
									});
								</script>";
							}else{
								if($check_usuario['usuario_usuario']==$usuario && password_verify($clave,$check_usuario['usuario_clave'])){
									$_SESSION['usuario']=$check_usuario['usuario_usuario'];					           
									$_SESSION['rol']=$check_usuario['usuario_rolid'];					           
									$_SESSION['foto']=$check_usuario['usuario_foto'];
									$_SESSION['sede']=$check_usuario['Sede'];
									$_SESSION['identificacion']=$check_usuario['usuario_identificacion'];
									$_SESSION['usuario_id']=$check_usuario['usuario_id'];	

									if ($check_usuario['usuario_nombre']==""){										
										$_SESSION['nombre']=$check_usuario['usuario_rolid'];
									}else{
										$_SESSION['nombre']=$check_usuario['usuario_nombre'];
									}
									if ($_SESSION['rol'] <> 1 && $_SESSION['rol'] <> 2){
										if(headers_sent()){
											echo "<script> window.location.href='".APP_URL."empleadoEntrada/'; </script>";
										}else{
											header("Location: ".APP_URL."empleadoEntrada/");
										} 
									} else{
										if(headers_sent()){
											echo "<script> window.location.href='".APP_URL."dashboard/'; </script>";
										}else{
											header("Location: ".APP_URL."dashboard/");
										}
									}
								}else{
									echo "<script>
										Swal.fire({
										icon: 'error',
										title: 'Ocurrió un error inesperado',
										text: 'Usuario o clave incorrectos'
										});
									</script>";
								}
							}
					    }else{
					        echo "<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'Usuario no existe'
								});
							</script>";
					    }
				    }
			    }
		    }
		}


		/*----------  Controlador cerrar sesion  ----------*/
		public function cerrarSesionControlador(){

			session_destroy();

		    if(headers_sent()){
                echo "<script> window.location.href='".APP_URL."login/'; </script>";
            }else{
                header("Location: ".APP_URL."login/");
            }
		}

	}