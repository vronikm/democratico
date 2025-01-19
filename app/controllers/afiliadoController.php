<?php

	namespace app\controllers;
	use app\models\mainModel;

	class afiliadoController extends mainModel{

		/*----------  Controlador registrar afiliado  ----------*/		
		public function registrarAfiliadoControlador(){						
			/*---------------Variables para el registro del tab del afiliado----------------*/
			$afiliado_nacionalidadid		= $this->limpiarCadena($_POST['afiliado_nacionalidadid']);
			$afiliado_sedeid				= $this->limpiarCadena($_POST['afiliado_sedeid']);
			$afiliado_cantonid				= $this->limpiarCadena($_POST['afiliado_cantonid']);
			$afiliado_ciudadid				= $this->limpiarCadena($_POST['afiliado_ciudadid']);
			$afiliado_rolid 				= $this->limpiarCadena($_POST['afiliado_rolid']);
			$afiliado_tipoidentificacion 	= $this->limpiarCadena($_POST['afiliado_tipoidentificacion']);
			$afiliado_identificacion 		= $this->limpiarCadena($_POST['afiliado_identificacion']);
			$afiliado_primernombre 			= $this->limpiarCadena($_POST['afiliado_nombre1']);
			$afiliado_segundonombre 		= $this->limpiarCadena($_POST['afiliado_nombre2']);
			$afiliado_apellidopaterno 		= $this->limpiarCadena($_POST['afiliado_apellido1']);
			$afiliado_apellidomaterno 		= $this->limpiarCadena($_POST['afiliado_apellido2']);
			$afiliado_fechanacimiento 		= $this->limpiarCadena($_POST['afiliado_fechanacimiento']);
			$afiliado_fechaafiliacion		= $this->limpiarCadena($_POST['afiliado_fechaafiliacion']);
			$afiliado_correo				= $this->limpiarCadena($_POST['afiliado_correo']);
			$afiliado_celular				= $this->limpiarCadena($_POST['afiliado_celular']);
			$afiliado_direccion 			= $this->limpiarCadena($_POST['afiliado_direccion']);
			$afiliado_genero 				= "";
			$afiliado_estado 				= "A";

			if (isset($_POST['afiliado_genero']) && isset($_POST['opciones'])) {
				$afiliado_genero       = $_POST['afiliado_genero'];
				$opciones 		 	   = $_POST['opciones']; // Array de opciones seleccionadas
				$opciones_concatenadas = implode(", ", $opciones); // Unir las opciones con comas

			}else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No ha completado los campos obligatorios del afiliado",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}			
			
		    # Verificando campos obligatorios #
		    if($afiliado_identificacion=="" || $afiliado_primernombre=="" || $afiliado_apellidopaterno=="" || $afiliado_fechanacimiento==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No ha completado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}",$afiliado_primernombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"El nombre ingresado no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }	    

            # Verificando identificacion #
		    $check_afiliado=$this->ejecutarConsulta("SELECT afiliado_identificacion FROM sujeto_afiliado WHERE afiliado_identificacion='$afiliado_identificacion'");
		    if($check_afiliado->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"La identificación ingresada ya se encuentra registrada, por favor verificar",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/imagenes/fotos/afiliado/";
			$codigo=rand(0,100);

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['afiliado_foto']['name']!="" && $_FILES['afiliado_foto']['size']>0){

    			# Creando directorio #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error",
							"texto"=>"No fue posible crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		            } 
		        }

		        # Verificando formato de imagenes #
		        if(mime_content_type($_FILES['afiliado_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['afiliado_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['afiliado_foto']['size']/1024)>4000){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido 4MB",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        }

		        # Nombre de la foto #
		        $foto=str_ireplace(" ","_",$afiliado_identificacion);
		        $foto=$foto."_".$codigo;

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['afiliado_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }
				$maxWidth = 800;
    			$maxHeight = 600;

				chmod($img_dir,0777);
				$inputFile = ($_FILES['afiliado_foto']['tmp_name']);
       			$outputFile = $img_dir.$foto;

				# Moviendo imagen al directorio #
				//if(!move_uploaded_file($_FILES['afiliado_foto']['tmp_name'],$img_dir.$foto)){
				if ($this->resizeImageGD($inputFile, $maxWidth, $maxHeight, $outputFile)) {
					
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error",
						"texto"=>"No es posible subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}

    		}else{
    			$foto="";
    		}
			
		    $afiliado_datos_reg=[
				[
					"campo_nombre"=>"afiliado_nacionalidadid",
					"campo_marcador"=>":Nacionalidadid",
					"campo_valor"=>$afiliado_nacionalidadid
				],				
				[
					"campo_nombre"=>"afiliado_sedeid",
					"campo_marcador"=>":Sede",
					"campo_valor"=>$afiliado_sedeid
				],
				[
					"campo_nombre"=>"afiliado_cantonid",
					"campo_marcador"=>":Cantonid",
					"campo_valor"=>$afiliado_cantonid
				],
				[
					"campo_nombre"=>"afiliado_ciudadid",
					"campo_marcador"=>":Ciudadid",
					"campo_valor"=>$afiliado_ciudadid
				],
				[
					"campo_nombre"=>"afiliado_rolid",
					"campo_marcador"=>":Rolid",
					"campo_valor"=>$afiliado_rolid
				],				
				[
					"campo_nombre"=>"afiliado_tipoidentificacion",
					"campo_marcador"=>":Tipoidentificacion",
					"campo_valor"=>$afiliado_tipoidentificacion
				],
				[
					"campo_nombre"=>"afiliado_identificacion",
					"campo_marcador"=>":Identificacion",
					"campo_valor"=>$afiliado_identificacion
				],				
				[
					"campo_nombre"=>"afiliado_primernombre",
					"campo_marcador"=>":Primernombre",
					"campo_valor"=>$afiliado_primernombre
				],
				[
					"campo_nombre"=>"afiliado_segundonombre",
					"campo_marcador"=>":Segundonombre",
					"campo_valor"=>$afiliado_segundonombre
				],				
				[
					"campo_nombre"=>"afiliado_apellidopaterno",
					"campo_marcador"=>":Apellidopaterno",
					"campo_valor"=>$afiliado_apellidopaterno
				],
				[
					"campo_nombre"=>"afiliado_apellidomaterno",
					"campo_marcador"=>":Apellidomaterno",
					"campo_valor"=>$afiliado_apellidomaterno
				],
				[
					"campo_nombre"=>"afiliado_fechanacimiento",
					"campo_marcador"=>":Fechanacimiento",
					"campo_valor"=>$afiliado_fechanacimiento
				],
				[
					"campo_nombre"=>"afiliado_fechaafiliacion",
					"campo_marcador"=>":Fechaafiliacion",
					"campo_valor"=>$afiliado_fechaafiliacion
				],
				[
					"campo_nombre"=>"afiliado_correo",
					"campo_marcador"=>":Correo",
					"campo_valor"=>$afiliado_correo
				],
				[
					"campo_nombre"=>"afiliado_celular",
					"campo_marcador"=>":Celular",
					"campo_valor"=>$afiliado_celular
				],
				[
					"campo_nombre"=>"afiliado_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$afiliado_direccion
				],
				[
					"campo_nombre"=>"afiliado_genero",
					"campo_marcador"=>":Genero",
					"campo_valor"=>$afiliado_genero
				],
				[
					"campo_nombre"=>"afiliado_estado",
					"campo_marcador"=>":Activo",
					"campo_valor"=>$afiliado_estado
				],
				[
					"campo_nombre"=>"afiliado_redsocial",
					"campo_marcador"=>":RedesSociales",
					"campo_valor"=>$opciones_concatenadas
				],
				[
					"campo_nombre"=>"afiliado_imagen",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				]
			];

			$registrar_afiliado=$this->guardarDatos("sujeto_afiliado",$afiliado_datos_reg);

			/*---------------Inicio de registro de Información de los tabs*/
			if($registrar_afiliado->rowCount()==1){
				$alerta=[
					"tipo"=>"redireccionar",
					"url"=>APP_URL.'afiliadoList/',
					"titulo"=>"afiliado registrado",
					"texto"=>"El afiliado ".$afiliado_identificacion." | ".$afiliado_primernombre." ".$afiliado_apellidopaterno." se registró correctamente",
					"icono"=>"success"
				];
			}else{				
				if(is_file($img_dir.$foto)){
					chmod($img_dir.$foto,0777);
					unlink($img_dir.$foto);
				}

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No se pudo registrar la información del afiliado, por favor intente nuevamente",
					"icono"=>"error"
				];
			}
			return json_encode($alerta);
		}

		/*----------  Matriz de afiliados con opciones Ver, Actualizar, Eliminar  ----------*/
		public function listarAfiliados($sede, $identificacion, $apellidopaterno, $primernombre){
			$estado = "";
			$texto = "";
			$boton = "";

			if($identificacion!=""){
				$identificacion .= '%'; 
			}
			if($primernombre!=""){
				$primernombre .= '%';
			} 
			if($apellidopaterno!=""){
				$apellidopaterno .= '%';
			} 					

			$tabla="";
			$consulta_datos="SELECT afiliado_id, afiliado_sedeid, sede_nombre, afiliado_identificacion, afiliado_primernombre, 
									afiliado_segundonombre, afiliado_apellidopaterno, afiliado_apellidomaterno, afiliado_estado
								FROM sujeto_afiliado
								INNER JOIN general_sede ON sede_id = afiliado_sedeid
								WHERE (afiliado_primernombre LIKE '".$primernombre."' 
								OR afiliado_identificacion LIKE '".$identificacion."' 
								OR afiliado_apellidopaterno LIKE '".$apellidopaterno."') ";			

			if($identificacion=="" && $primernombre=="" && $apellidopaterno==""){
				$consulta_datos = "SELECT afiliado_id, afiliado_sedeid, sede_nombre, afiliado_identificacion, afiliado_primernombre,
										  afiliado_segundonombre, afiliado_apellidopaterno, afiliado_apellidomaterno, afiliado_estado
										FROM sujeto_afiliado
										INNER JOIN general_sede ON sede_id = afiliado_sedeid
										WHERE afiliado_primernombre <> '' ";
			}

			if($sede!=""){
				if($sede == 0){
					$consulta_datos .= " and afiliado_sedeid <> '".$sede."'"; 
				}else{
					$consulta_datos .= " and afiliado_sedeid = '".$sede."'"; 
				}
			}else{
				$consulta_datos = "SELECT afiliado_id, afiliado_sedeid, sede_nombre, afiliado_identificacion, afiliado_primernombre, 
										  afiliado_segundonombre, afiliado_apellidopaterno, afiliado_apellidomaterno, afiliado_estado
										FROM sujeto_afiliado
										INNER JOIN general_sede ON sede_id = afiliado_sedeid
										WHERE afiliado_primernombre = ''";
			}			

			$consulta_datos .= " AND afiliado_estado <> 'E'"; 
			
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($rows['afiliado_estado']=='A'){
					$estado = "Activo";
					$texto = "Inactivar";
					$boton = "btn-secondary";
				}else{
					$estado = "Inactivo";
					$texto = "Activar";
					$boton = "btn-info";
				}

				$tabla.='
					<tr>
						<td>'.$rows['sede_nombre'].'</td>
						<td>'.$rows['afiliado_identificacion'].'</td>
						<td>'.$rows['afiliado_primernombre'].' '.$rows['afiliado_segundonombre'].'</td>
						<td>'.$rows['afiliado_apellidopaterno'].' '.$rows['afiliado_apellidomaterno'].'</td>
						<td>
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/afiliadoAjax.php" method="POST" autocomplete="off" >
								<input type="hidden" name="modulo_afiliado" value="eliminar">
								<input type="hidden" name="afiliado_id" value="'.$rows['afiliado_id'].'">						
								<button type="submit" class="btn float-right btn-danger btn-xs" style="margin-right: 5px;">Eliminar</button>
							</form>
							
							<a href="'.APP_URL.'afiliadoUpdate/'.$rows['afiliado_id'].'/" target="_blank" class="btn float-right btn-actualizar btn-xs" style="margin-right: 5px;">Actualizar</a>							
							<a href="'.APP_URL.'afiliadoProfile/'.$rows['afiliado_id'].'/" target="_blank" class="btn float-right btn-ver btn-xs" style="margin-right: 5px;">Ver</a>
							
							<form class="FormularioAjax" action="'.APP_URL.'app/ajax/afiliadoAjax.php" method="POST" autocomplete="off" >
								<input type="hidden" name="modulo_afiliado" value="actualizarestado">
								<input type="hidden" name="afiliado_id" value="'.$rows['afiliado_id'].'">						
								<button type="submit" class="btn float-right '.$boton.' btn-xs" style="margin-right: 5px;""> '.$texto.' </button>
							</form>
						</td>
					</tr>';	
			}
			return $tabla;			
		}

		/*----------  Obtener el tipo de documento guardado  ----------*/
		public function listarOptionTipoIdentificacion($tipoidentificacion){
			$option="";

			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'tipo_documento'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($tipoidentificacion == $rows['catalogo_valor']){
					$option.='<option value='.$rows['catalogo_valor'].' selected="selected">'.$rows['catalogo_descripcion'].'</option>';	
				}else{
					$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
				}
			}
			return $option;
		}

		/*----------  Obtener la nacionalidad guardada  ----------*/
		public function listarOptionNacionalidad($afiliado_nacionalidadid){
			$option="";

			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'nacionalidad'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($afiliado_nacionalidadid == $rows['catalogo_valor']){
					$option.='<option value='.$rows['catalogo_valor'].' selected="selected">'.$rows['catalogo_descripcion'].'</option>';	
				}else{
					$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
				}
			}
			return $option;
		}
				
		/*----------  Obtener la sede guardada  ----------*/
		public function listarSedeAfiliado($afiliado_sedeid){
			$option="";

			$consulta_datos="SELECT sede_id, sede_nombre FROM general_sede";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($afiliado_sedeid == $rows['sede_id']){
					$option.='<option value='.$rows['sede_id'].' selected="selected">'.$rows['sede_nombre'].'</option>';	
				}else{
					$option.='<option value='.$rows['sede_id'].'>'.$rows['sede_nombre'].'</option>';	
				}
			}
			return $option;
		}

		/*----------  Obtener la posición de juego guardada  ----------*/
		public function listarAfiliadosPDF($categoriaid,$sedeid){		
			$consulta_datos=("SELECT sede_nombre, afiliado_identificacion, afiliado_primernombre, afiliado_segundonombre, 
									afiliado_apellidopaterno, afiliado_apellidomaterno, afiliado_fechanacimiento
								FROM sujeto_afiliado, general_sede
								WHERE afiliado_estado = 'A'
									AND afiliado_sedeid = sede_id");	

			if($categoriaid!=0){
				$consulta_datos .= " and YEAR(afiliado_fechanacimiento) = ".$categoriaid; 
			}

			if($sedeid!=0){
				$consulta_datos .= " and afiliado_sedeid = ".$sedeid; 
			}

			$consulta_datos.= " ORDER BY afiliado_fechanacimiento";

			$datos = $this->ejecutarConsulta($consulta_datos);		
			return $datos;
		}

		public function listarOptionParentesco($cemer_parentesco){
			$option="";

			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'parentesco'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($cemer_parentesco == $rows['catalogo_valor']){
					$option.='<option value='.$rows['catalogo_valor'].' selected="selected">'.$rows['catalogo_descripcion'].'</option>';	
				}else{
					$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
				}
			}
			return $option;
		}

		/*----------  Controlador eliminar afiliado  ----------*/
		public function actualizarEstadoAfiliadoControlador(){

			$afiliado_id=$this->limpiarCadena($_POST['afiliado_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM sujeto_afiliado WHERE afiliado_id='$afiliado_id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"El afiliado no se encuentra en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }else{
		    	$datos=$datos->fetch();
		    }
			if($datos['afiliado_estado']=='A'){
				$estadoA = 'I';
			}else{
				$estadoA = 'A';
			}
            $afiliado_datos_up=[
				[
					"campo_nombre"=>"afiliado_estado",
					"campo_marcador"=>":Estado",
					"campo_valor"=> $estadoA
				]
			];
			$condicion=[
				"condicion_campo"=>"afiliado_id",
				"condicion_marcador"=>":afiliadoid",
				"condicion_valor"=>$afiliado_id
			];

			if($this->actualizarDatos("sujeto_afiliado",$afiliado_datos_up,$condicion)){

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Estado actualizado correctamente",
					"texto"=>"El estado del afiliado ".$datos['afiliado_primernombre']." | ".$datos['afiliado_apellidopaterno']." fue actualizado correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar el estado del afiliado ".$datos['afiliado_primernombre']." ".$datos['afiliado_apellidopaterno'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador eliminar afiliado  ----------*/
		public function eliminarAfiliadoControlador(){

			$afiliado_id=$this->limpiarCadena($_POST['afiliado_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM sujeto_afiliado WHERE afiliado_id='$afiliado_id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"El afiliado no se encuentra en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }else{
		    	$datos=$datos->fetch();
		    }
			if($datos['afiliado_estado']=='A' || $datos['afiliado_estado']=='I'){
				$estadoA = 'E';
			}else{
				$estadoA = 'X';
			}
            $afiliado_datos_up=[
				[
					"campo_nombre"=>"afiliado_estado",
					"campo_marcador"=>":Estado",
					"campo_valor"=> $estadoA
				]
			];
			$condicion=[
				"condicion_campo"=>"afiliado_id",
				"condicion_marcador"=>":afiliadoid",
				"condicion_valor"=>$afiliado_id
			];

			if($this->actualizarDatos("sujeto_afiliado",$afiliado_datos_up,$condicion)){

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"El afiliado fue eliminado correctamente",
					"texto"=>"El afiliado ".$datos['afiliado_primernombre']." | ".$datos['afiliado_apellidopaterno']." fue eliminado correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el afiliado ".$datos['afiliado_primernombre']." ".$datos['afiliado_apellidopaterno'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}
			return json_encode($alerta);
		}		

		/*----------  Controlador actualizar afiliado  ----------*/
		public function actualizarAfiliadoControlador(){
			
			$afiliadoid=$this->limpiarCadena($_POST['afiliado_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM sujeto_afiliado WHERE afiliado_id ='$afiliadoid'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"El afiliado no se encuentra en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);		    
		    }else{
		    	$datos=$datos->fetch();
		    }

			/*---------------Variables para el registro del tab del afiliado----------------*/
			$afiliado_identificacion 		= $this->limpiarCadena($_POST['afiliado_identificacion']);
			$afiliado_apellidopaterno 	= $this->limpiarCadena($_POST['afiliado_apellido1']);
			$afiliado_apellidomaterno 	= $this->limpiarCadena($_POST['afiliado_apellido2']);
			$afiliado_tipoidentificacion 	= $this->limpiarCadena($_POST['afiliado_tipoidentificacion']);			
			$afiliado_primernombre 		= $this->limpiarCadena($_POST['afiliado_nombre1']);
			$afiliado_segundonombre 		= $this->limpiarCadena($_POST['afiliado_nombre2']);
			$afiliado_nacionalidadid		= $this->limpiarCadena($_POST['afiliado_nacionalidadid']);
			$afiliado_fechanacimiento 	= $this->limpiarCadena($_POST['afiliado_fechanacimiento']);
			$afiliado_direccion 			= $this->limpiarCadena($_POST['afiliado_direccion']);	
			$afiliado_fechaingreso		= $this->limpiarCadena($_POST['afiliado_fechaingreso']);
			$afiliado_sedeid 				= $this->limpiarCadena($_POST['afiliado_sedeid']);
			$afiliado_nombrecorto 		= ""; //$this->limpiarCadena($_POST['afiliado_nombrecorto']);
			$afiliado_posicionid			= ""; //$this->limpiarCadena($_POST['afiliado_posicionid']);					
			$afiliado_numcamiseta 		= $_POST['afiliado_numcamiseta'];
			$afiliado_genero 				= "";
			$afiliado_hermanos 			= "";

			if ($afiliado_numcamiseta == ""){$afiliado_numcamiseta = 0;}

			if (isset($_POST['afiliado_genero']) && isset($_POST['afiliado_hermanos'])) {
				$afiliado_genero 				= $_POST['afiliado_genero'];
				$afiliado_hermanos 			= $_POST['afiliado_hermanos'];

			}else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No ha completado los campos obligatorios del afiliado",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}			
			
		    # Verificando campos obligatorios #
		    if($afiliado_identificacion=="" || $afiliado_primernombre=="" || $afiliado_apellidopaterno=="" || $afiliado_fechanacimiento==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error",
					"texto"=>"No ha completado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}",$afiliado_primernombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error",
					"texto"=>"El campo nombre no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }
			
			$afiliado_datos_reg=[
				[
					"campo_nombre"=>"afiliado_sedeid",
					"campo_marcador"=>":Sedeid",
					"campo_valor"=>$afiliado_sedeid
				],
				[
					"campo_nombre"=>"afiliado_posicionid",
					"campo_marcador"=>":Posicionid",
					"campo_valor"=>$afiliado_posicionid
				],
				[
					"campo_nombre"=>"afiliado_nacionalidadid",
					"campo_marcador"=>":Nacionalidadid",
					"campo_valor"=>$afiliado_nacionalidadid
				],
				[
					"campo_nombre"=>"afiliado_tipoidentificacion",
					"campo_marcador"=>":Tipoidentificacion",
					"campo_valor"=>$afiliado_tipoidentificacion
				],
				[
					"campo_nombre"=>"afiliado_identificacion",
					"campo_marcador"=>":Identificacion",
					"campo_valor"=>$afiliado_identificacion
				],				
				[
					"campo_nombre"=>"afiliado_primernombre",
					"campo_marcador"=>":Primernombre",
					"campo_valor"=>$afiliado_primernombre
				],
				[
					"campo_nombre"=>"afiliado_segundonombre",
					"campo_marcador"=>":Segundonombre",
					"campo_valor"=>$afiliado_segundonombre
				],				
				[
					"campo_nombre"=>"afiliado_apellidopaterno",
					"campo_marcador"=>":Apellidopaterno",
					"campo_valor"=>$afiliado_apellidopaterno
				],
				[
					"campo_nombre"=>"afiliado_apellidomaterno",
					"campo_marcador"=>":Apellidomaterno",
					"campo_valor"=>$afiliado_apellidomaterno
				],
				[
					"campo_nombre"=>"afiliado_nombrecorto",
					"campo_marcador"=>":Nombrecorto",
					"campo_valor"=>$afiliado_nombrecorto
				],
				[
					"campo_nombre"=>"afiliado_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$afiliado_direccion
				],
				[
					"campo_nombre"=>"afiliado_fechanacimiento",
					"campo_marcador"=>":Fechanacimiento",
					"campo_valor"=>$afiliado_fechanacimiento
				],
				[
					"campo_nombre"=>"afiliado_fechaingreso",
					"campo_marcador"=>":Fechaingreso",
					"campo_valor"=>$afiliado_fechaingreso
				],
				[
					"campo_nombre"=>"afiliado_genero",
					"campo_marcador"=>":Genero",
					"campo_valor"=>$afiliado_genero
				],
				[
					"campo_nombre"=>"afiliado_hermanos",
					"campo_marcador"=>":Hermanos",
					"campo_valor"=>$afiliado_hermanos
				],			
				[
					"campo_nombre"=>"afiliado_numcamiseta",
					"campo_marcador"=>":Camiseta",
					"campo_valor"=>$afiliado_numcamiseta
				]
			];

			# Directorio de fotos #
			$codigorand=rand(0,100);
			$img_dir="../views/imagenes/fotos/afiliado/";

			# Directorio de imagenes cedula#
			$dir_cedula="../views/imagenes/cedulas/";
			
    		# Comprobar si se selecciono una imagen #
    		if($_FILES['afiliado_foto']['name']!="" && $_FILES['afiliado_foto']['size']>0){
		
				# Creando directorio #
				if(!file_exists($img_dir)){
					if(!mkdir($img_dir,0777)){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Error",
							"texto"=>"No se creó el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
						//exit();
					} 
				}

				# Verificando formato de imagenes #
				if(mime_content_type($_FILES['afiliado_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['afiliado_foto']['tmp_name'])!="image/png"){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido ",
						"icono"=>"error"
					];
					return json_encode($alerta);
					//exit();
				}

				# Verificando peso de imagen #
				if(($_FILES['afiliado_foto']['size']/1024)>4000){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido 4MB",
						"icono"=>"error"
					];
					return json_encode($alerta);
					//exit();
				}

				#nombre de la foto
				$foto=str_ireplace(" ","_",$afiliado_identificacion);
				$foto=$foto."_".$codigorand;
				

				# Extension de la imagen #
				switch(mime_content_type($_FILES['afiliado_foto']['tmp_name'])){
					case 'image/jpeg':
						$foto=$foto.".jpg";
					break;
					case 'image/png':
						$foto=$foto.".png";
					break;
				}
				$maxWidth = 800;
    			$maxHeight = 600;

				chmod($img_dir,0777);
				$inputFile = ($_FILES['afiliado_foto']['tmp_name']);
       			$outputFile = $img_dir.$foto;

				# Moviendo imagen al directorio #
				//if(!move_uploaded_file($_FILES['afiliado_foto']['tmp_name'],$img_dir.$foto)){
				if ($this->resizeImageGD($inputFile, $maxWidth, $maxHeight, $outputFile)) {
					
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"No es posible subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}
				
				# Eliminando imagen anterior #
				if(is_file($img_dir.$datos['afiliado_imagen']) && $datos['afiliado_imagen']!=$foto){
					chmod($img_dir.$datos['afiliado_imagen'], 0777);
					unlink($img_dir.$datos['afiliado_imagen']);
				}				
				
				$afiliado_datos_reg[] = [
					"campo_nombre" => "afiliado_imagen",
					"campo_marcador" => ":Foto",
					"campo_valor" => $foto
				];				
			}

			if($_FILES['afiliado_cedulaA']['name']!="" && $_FILES['afiliado_cedulaA']['size']>0){
		
				# Creando directorio #
				if(!file_exists($dir_cedula)){
					if(!mkdir($dir_cedula,0777)){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Error",
							"texto"=>"No se creó el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
					} 
				}

				# Verificando formato de imagenes #
				if(mime_content_type($_FILES['afiliado_cedulaA']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['afiliado_cedulaA']['tmp_name'])!="image/png"){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido ",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}

				# Verificando peso de imagen #
				if(($_FILES['afiliado_cedulaA']['size']/1024)>4000){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido 4MB",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}

				#nombre de la imagen cedula
				$CedulaA=str_ireplace(" ","_",$afiliado_identificacion);
				$CedulaA=$CedulaA."_A".$codigorand=rand(0,100);					

				# Extension de la imagen #
				switch(mime_content_type($_FILES['afiliado_cedulaA']['tmp_name'])){
					case 'image/jpeg':
						$CedulaA=$CedulaA.".jpg";
					break;
					case 'image/png':
						$CedulaA=$CedulaA.".png";
					break;
				}
				$maxWidth = 800;
    			$maxHeight = 600;

				chmod($img_dir,0777);
				$inputFile = ($_FILES['afiliado_cedulaA']['tmp_name']);
       			$outputFile = $dir_cedula.$CedulaA;

				# Moviendo imagen al directorio #
				//if(!move_uploaded_file($_FILES['afiliado_foto']['tmp_name'],$img_dir.$foto)){
				if ($this->resizeImageGD($inputFile, $maxWidth, $maxHeight, $outputFile)) {
					
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"No es posible subir la imagen de la cedula al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}
				
				# Eliminando imagen anterior #
				if(is_file($dir_cedula.$datos['afiliado_cedulaA']) && $datos['afiliado_cedulaA']!=$CedulaA){
					chmod($dir_cedula.$datos['afiliado_cedulaA'], 0777);
					unlink($dir_cedula.$datos['afiliado_cedulaA']);
				}				
				
				$afiliado_datos_reg[] = [
					"campo_nombre" => "afiliado_cedulaA",
					"campo_marcador" => ":CedulaA",
					"campo_valor" => $CedulaA
				];				
			}

			if($_FILES['afiliado_cedulaR']['name']!="" && $_FILES['afiliado_cedulaR']['size']>0){
		
				# Creando directorio #
				if(!file_exists($dir_cedula)){
					if(!mkdir($dir_cedula,0777)){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Error",
							"texto"=>"No se creó el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
					} 
				}

				# Verificando formato de imagenes #
				if(mime_content_type($_FILES['afiliado_cedulaR']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['afiliado_cedulaR']['tmp_name'])!="image/png"){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido ",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}

				# Verificando peso de imagen #
				if(($_FILES['afiliado_cedulaR']['size']/1024)>4000){
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido 4MB",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}

				#nombre imagen cedula reverso
				$CedulaR=str_ireplace(" ","_",$afiliado_identificacion);
				$CedulaR=$CedulaR."_R".$codigorand;				

				# Extension de la imagen #
				switch(mime_content_type($_FILES['afiliado_cedulaR']['tmp_name'])){
					case 'image/jpeg':
						$CedulaR=$CedulaR.".jpg";
					break;
					case 'image/png':
						$CedulaR=$CedulaR.".png";
					break;
				}
				$maxWidth = 800;
    			$maxHeight = 600;

				chmod($img_dir,0777);
				$inputFile = ($_FILES['afiliado_cedulaR']['tmp_name']);
       			$outputFile = $dir_cedula.$CedulaR;

				# Moviendo imagen al directorio #
				//if(!move_uploaded_file($_FILES['afiliado_foto']['tmp_name'],$img_dir.$foto)){
				if ($this->resizeImageGD($inputFile, $maxWidth, $maxHeight, $outputFile)) {
					
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Error",
						"texto"=>"No es posible subir la imagen de la cedula al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}
				
				# Eliminando imagen anterior #
				if(is_file($dir_cedula.$datos['afiliado_cedulaR']) && $datos['afiliado_cedulaR']!=$CedulaR){
					chmod($dir_cedula.$datos['afiliado_cedulaR'], 0777);
					unlink($dir_cedula.$datos['afiliado_cedulaR']);
				}				
				
				$afiliado_datos_reg[] = [
					"campo_nombre" => "afiliado_cedulaR",
					"campo_marcador" => ":CedulaR",
					"campo_valor" => $CedulaR
				];				
			}

			$condicion=[
				"condicion_campo"=>"afiliado_id",
				"condicion_marcador"=>":afiliadoid",
				"condicion_valor"=>$afiliadoid
			];

			if($this->actualizarDatos("sujeto_afiliado",$afiliado_datos_reg,$condicion)){					
				
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"afiliado actualizado",
					"texto"=>"El afiliado ".$afiliado_identificacion." | ".$afiliado_primernombre." ".$afiliado_apellidopaterno." se actualizó correctamente",
					"icono"=>"success"
				];

				/*---------------Inicio de registro de Información de los tabs*/
				$infomedic_tiposangre 	= $this->limpiarCadena($_POST['infomedic_tiposangre']);
				$infomedic_peso		  	= $this->limpiarCadena($_POST['infomedic_peso']);
				$infomedic_talla 	  	= $this->limpiarCadena($_POST['infomedic_talla']);
				$infomedic_enfermedad 	= $this->limpiarCadena($_POST['infomedic_enfermedad']);
				$infomedic_medicamentos = $this->limpiarCadena($_POST['infomedic_medicamentos']);
				$infomedic_alergia1 	= $this->limpiarCadena($_POST['infomedic_alergia1']);
				$infomedic_alergia2 	= $this->limpiarCadena($_POST['infomedic_alergia2']);
				$infomedic_cirugias 	= $this->limpiarCadena($_POST['infomedic_cirugias']);
				$infomedic_observacion	= $this->limpiarCadena($_POST['infomedic_observacion']);

				if(isset($_POST['infomedic_covid'])){ $infomedic_covid  = $_POST['infomedic_covid']; }else {$infomedic_covid="";}
				if(isset($_POST['infomedic_vacunas'])){ $infomedic_vacunas  = $_POST['infomedic_vacunas']; }else {$infomedic_vacunas="";}
                
                
            	if ($infomedic_peso ==""){$infomedic_peso = 0;}
				if ($infomedic_talla ==""){$infomedic_talla = 0;}
                
				$infomedic=$this->ejecutarConsulta("SELECT * FROM afiliado_infomedic WHERE infomedic_afiliadoid='$afiliadoid'");
				if($infomedic->rowCount()>0){
				

					$infomedic_reg=[
						[
							"campo_nombre"=>"infomedic_afiliadoid",
							"campo_marcador"=>":afiliadoid",
							"campo_valor"=>$afiliadoid
						],
						[
							"campo_nombre"=>"infomedic_fecha",
							"campo_marcador"=>":Fechacreacion",
							"campo_valor"=>date("Y-m-d H:i:s")
						],
						[
							"campo_nombre"=>"infomedic_tiposangre",
							"campo_marcador"=>":Tiposangre",
							"campo_valor"=>$infomedic_tiposangre
						],
						[
							"campo_nombre"=>"infomedic_peso",
							"campo_marcador"=>":Peso",
							"campo_valor"=>$infomedic_peso
						],
						[
							"campo_nombre"=>"infomedic_talla",
							"campo_marcador"=>":Talla",
							"campo_valor"=>$infomedic_talla
						],
						[
							"campo_nombre"=>"infomedic_enfermedad",
							"campo_marcador"=>":Enfermedad",
							"campo_valor"=>$infomedic_enfermedad
						],
						[
							"campo_nombre"=>"infomedic_medicamentos",
							"campo_marcador"=>":Medicamentos",
							"campo_valor"=>$infomedic_medicamentos
						],
						[
							"campo_nombre"=>"infomedic_alergia1",
							"campo_marcador"=>":AlergiaMedicamentos",
							"campo_valor"=>$infomedic_alergia1
						],
						[
							"campo_nombre"=>"infomedic_alergia2",
							"campo_marcador"=>":AlergiaObjetos",
							"campo_valor"=>$infomedic_alergia2
						],
						[
							"campo_nombre"=>"infomedic_cirugias",
							"campo_marcador"=>":Cirugias",
							"campo_valor"=>$infomedic_cirugias
						],
						[
							"campo_nombre"=>"infomedic_observacion",
							"campo_marcador"=>":Observacion",
							"campo_valor"=>$infomedic_observacion
						],
						[
							"campo_nombre"=>"infomedic_covid",
							"campo_marcador"=>":VacunasCovid",
							"campo_valor"=>$infomedic_covid
						],
						[
							"campo_nombre"=>"infomedic_vacunas",
							"campo_marcador"=>":Vacunas",
							"campo_valor"=>$infomedic_vacunas
						]
					];
					
					$condicion=[
						"condicion_campo"=>"infomedic_afiliadoid",
						"condicion_marcador"=>":afiliadoid",
						"condicion_valor"=>$afiliadoid
					];

					$this->actualizarDatos("afiliado_infomedic",$infomedic_reg,$condicion);

				}else{
					if($infomedic_tiposangre!="" || $infomedic_peso>0 || $infomedic_talla>0 || $infomedic_enfermedad!=""||
					$infomedic_medicamentos!="" || $infomedic_alergia1!="" || $infomedic_alergia2!="" || $infomedic_cirugias!="" ||
					$infomedic_observacion!=""){
						//if (!is_int($infomedic_peso) && !is_float($infomedic_peso)){$infomedic_peso = 0;}
						//if (!is_int($infomedic_talla) && !is_float($infomedic_talla)){$infomedic_talla = 0;}

						$infomedic_reg=[
							[
								"campo_nombre"=>"infomedic_afiliadoid",
								"campo_marcador"=>":afiliadoid",
								"campo_valor"=>$afiliadoid
							],
							[
								"campo_nombre"=>"infomedic_fecha",
								"campo_marcador"=>":Fechacreacion",
								"campo_valor"=>date("Y-m-d H:i:s")
							],
							[
								"campo_nombre"=>"infomedic_tiposangre",
								"campo_marcador"=>":Tiposangre",
								"campo_valor"=>$infomedic_tiposangre
							],
							[
								"campo_nombre"=>"infomedic_peso",
								"campo_marcador"=>":Peso",
								"campo_valor"=>$infomedic_peso
							],
							[
								"campo_nombre"=>"infomedic_talla",
								"campo_marcador"=>":Talla",
								"campo_valor"=>$infomedic_talla
							],
							[
								"campo_nombre"=>"infomedic_enfermedad",
								"campo_marcador"=>":Enfermedad",
								"campo_valor"=>$infomedic_enfermedad
							],
							[
								"campo_nombre"=>"infomedic_medicamentos",
								"campo_marcador"=>":Medicamentos",
								"campo_valor"=>$infomedic_medicamentos
							],
							[
								"campo_nombre"=>"infomedic_alergia1",
								"campo_marcador"=>":AlergiaMedicamentos",
								"campo_valor"=>$infomedic_alergia1
							],
							[
								"campo_nombre"=>"infomedic_alergia2",
								"campo_marcador"=>":AlergiaObjetos",
								"campo_valor"=>$infomedic_alergia2
							],
							[
								"campo_nombre"=>"infomedic_cirugias",
								"campo_marcador"=>":Cirugias",
								"campo_valor"=>$infomedic_cirugias
							],
							[
								"campo_nombre"=>"infomedic_observacion",
								"campo_marcador"=>":Observacion",
								"campo_valor"=>$infomedic_observacion
							],
							[
								"campo_nombre"=>"infomedic_covid",
								"campo_marcador"=>":VacunasCovid",
								"campo_valor"=>$infomedic_covid
							],
							[
								"campo_nombre"=>"infomedic_vacunas",
								"campo_marcador"=>":Vacunas",
								"campo_valor"=>$infomedic_vacunas
							]
						];

						$this->guardarDatos("afiliado_infomedic",$infomedic_reg);
					}

				}
				/*---------------Fin de registro del tab Información Médica del afiliado*/


				/*---------------Registro del tab Contacto Emergencia del afiliado------------*/
				$cemer_nombre 		= $this->limpiarCadena($_POST['cemer_nombre']);
				$cemer_celular 		= $this->limpiarCadena($_POST['cemer_celular']);
				$cemer_parentesco	= $this->limpiarCadena($_POST['cemer_parentesco']);				

				$cmer=$this->ejecutarConsulta("SELECT * FROM afiliado_cemergencia WHERE cemer_afiliadoid='$afiliadoid'");
				if($cmer->rowCount()>0){

					$cemergencia_reg=[
						[
							"campo_nombre"=>"cemer_afiliadoid",
							"campo_marcador"=>":afiliadoid",
							"campo_valor"=>$afiliadoid
						],						
						[
							"campo_nombre"=>"cemer_nombre",
							"campo_marcador"=>":NombreContactoEmer",
							"campo_valor"=>$cemer_nombre
						],
						[
							"campo_nombre"=>"cemer_celular",
							"campo_marcador"=>":CelularContactoEmer",
							"campo_valor"=>$cemer_celular
						],
						[
							"campo_nombre"=>"cemer_parentesco",
							"campo_marcador"=>":ParentescoContactoEmer",
							"campo_valor"=>$cemer_parentesco
						]
					];
	
					$condicion=[
						"condicion_campo"=>"cemer_afiliadoid",
						"condicion_marcador"=>":afiliadoid",
						"condicion_valor"=>$afiliadoid
					];

					$this->actualizarDatos("afiliado_cemergencia",$cemergencia_reg,$condicion);

				}else{
					if($cemer_nombre!="" || $cemer_celular!=""){

						$cemergencia_reg=[
							[
								"campo_nombre"=>"cemer_afiliadoid",
								"campo_marcador"=>":afiliadoid",
								"campo_valor"=>$afiliadoid
							],						
							[
								"campo_nombre"=>"cemer_nombre",
								"campo_marcador"=>":NombreContactoEmer",
								"campo_valor"=>$cemer_nombre
							],
							[
								"campo_nombre"=>"cemer_celular",
								"campo_marcador"=>":CelularContactoEmer",
								"campo_valor"=>$cemer_celular
							],
							[
								"campo_nombre"=>"cemer_parentesco",
								"campo_marcador"=>":ParentescoContactoEmer",
								"campo_valor"=>$cemer_parentesco
							]
						];
		
						$condicion=[
							"condicion_campo"=>"cemer_afiliadoid",
							"condicion_marcador"=>":afiliadoid",
							"condicion_valor"=>$afiliadoid
						];
						$this->guardarDatos("afiliado_cemergencia",$cemergencia_reg);
					}

				}
				/*---------------Fin de registro del tab Contacto Emergencia del afiliado------*/
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"afiliado no actualizado",
					"texto"=>"No fue posible actualizar los datos del afiliado ".$afiliado_identificacion." | ".$afiliado_primernombre." ".$afiliado_apellidopaterno.", por favor intente nuevamente",
					"icono"=>"success"
				];
			}
			return json_encode($alerta);
		}

		/*----------  Controlador eliminar foto afiliado  ----------*/
		public function eliminarFotoAfiliadoControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"El usuario no se encuentra en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        //exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/imagenes/fotos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['usuario_foto'])){

		        chmod($img_dir.$datos['usuario_foto'],0777);

		        if(!unlink($img_dir.$datos['usuario_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error",
						"texto"=>"Error al intentar eliminar la foto del usuario, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	//exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No se encuentra la foto del usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        //exit();
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No fue posible actualizar algunos datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar foto afiliado  ----------*/
		public function actualizarFotoAfiliadoControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        //exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/imagenes/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['usuario_foto']['name']=="" && $_FILES['usuario_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No ha seleccionado una foto para el usuario",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        //exit();
    		}

    		# Creando directorio #
	        if(!file_exists($img_dir)){
	            if(!mkdir($img_dir,0777)){
	                $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No se creó el directorio",
						"icono"=>"error"
					];
					return json_encode($alerta);
	                //exit();
	            } 
	        }

	        # Verificando formato de imagenes #
	        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            //exit();
	        }

	        # Verificando peso de imagen #
	        if(($_FILES['usuario_foto']['size']/1024)>250){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"La imagen que ha seleccionado supera el peso permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            //exit();
	        }

	        # Nombre de la foto #
	        if($datos['usuario_foto']!=""){
		        $foto=explode(".", $datos['usuario_foto']);
		        $foto=$foto[0];
	        }else{
	        	$foto=str_ireplace(" ","_",$datos['usuario_nombre']);
	        	$foto=$foto."_".rand(0,100);
	        }
	        

	        # Extension de la imagen #
	        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        # Moviendo imagen al directorio #
	        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error",
					"texto"=>"No podemos subir la imagen al sistema en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            //exit();
	        }

	        # Eliminando imagen anterior #
	        if(is_file($img_dir.$datos['usuario_foto']) && $datos['usuario_foto']!=$foto){
		        chmod($img_dir.$datos['usuario_foto'], 0777);
		        unlink($img_dir.$datos['usuario_foto']);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['usuario_nombre']." ".$datos['usuario_apellido']." , sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}
		/* ==================================== Roles ==================================== */

		public function listarOptionSede($rolid = null, $usuario = null ){
			$option="";

			if($rolid != 1 && $rolid != 2){
				$consulta_datos="SELECT S.sede_id, S.sede_nombre 
									FROM general_sede S
									INNER JOIN seguridad_usuario_sede US ON US.usuariosede_sedeid = S.sede_id
									INNER JOIN seguridad_usuario U ON U.usuario_id = US.usuariosede_usuarioid
									WHERE U.usuario_usuario  = '".$usuario."'";
			}else{
				$consulta_datos="SELECT sede_id, sede_nombre FROM general_sede";
			}				
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				$option.='<option value='.$rows['sede_id'].'>'.$rows['sede_nombre'].'</option>';					
			}
			return $option;
		}

		public function listarSedebusqueda($sedeid, $rolid = null, $usuario = null){
			$option="";

			if($rolid != 1 && $rolid != 2){
				$consulta_datos="SELECT S.sede_id, S.sede_nombre 
									FROM general_sede S
									INNER JOIN seguridad_usuario_sede US ON US.usuariosede_sedeid = S.sede_id
									INNER JOIN seguridad_usuario U ON U.usuario_id = US.usuariosede_usuarioid
									WHERE U.usuario_usuario  = '".$usuario."'";
			}else{
				$consulta_datos="SELECT sede_id, sede_nombre FROM general_sede";
			}						
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($sedeid == $rows['sede_id']){
					$option.='<option value='.$rows['sede_id'].' selected>'.$rows['sede_nombre'].'</option>';
				}else{
					$option.='<option value='.$rows['sede_id'].'>'.$rows['sede_nombre'].'</option>';	
				}
					
			}
			return $option;
		}
		
		public function listarCatalogoTipoDocumento(){
			$option="";

			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'tipo_documento'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
			}
			return $option;
		}
		
		public function listarCatalogoNacionalidad(){
			$option="";

			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'nacionalidad'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
			}
			return $option;
		}
		
		public function listarCatalogoCanton($cantonid){
			$option="";
			$option ='<option value=0> Seleccione un cantón</option>';
			$consulta_datos="SELECT C.catalogo_valor AS Canton, C.catalogo_descripcion AS Descripcion
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'canton'
									AND C.catalogo_estado = 'A'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				if($cantonid == $rows['Canton']){
					$option.='<option value='.$rows['Canton'].' selected>'.$rows['Descripcion'].'</option>';	
				}else{
					$option.='<option value='.$rows['Canton'].'>'.$rows['Descripcion'].'</option>';	
				}
			}
			return $option;
		}
		
		public function listarCatalogoCiudad(){
			$option="";
			$option ='<option value=0> Seleccione una ciudad</option>';
			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'ciudad'
									AND C.catalogo_estado = 'A'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
			}
			return $option;
		}	
		public function listarCatalogoRol(){
			$option="";
			$option ='<option value=0> Seleccione un rol</option>';
			$consulta_datos="SELECT C.catalogo_valor, C.catalogo_descripcion 
								FROM general_tabla_catalogo C
								INNER JOIN general_tabla T on T.tabla_id = C.catalogo_tablaid
								WHERE T.tabla_nombre = 'rol'
									AND C.catalogo_estado = 'A'";	
					
			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();
			foreach($datos as $rows){
				$option.='<option value='.$rows['catalogo_valor'].'>'.$rows['catalogo_descripcion'].'</option>';	
			}
			return $option;
		}	


		public function informacionSede($sedeid){		
			$consulta_datos="SELECT * FROM general_sede WHERE sede_id  = $sedeid";
			$datos = $this->ejecutarConsulta($consulta_datos);		
			return $datos;
		}
	}