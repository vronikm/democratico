<?php
	namespace app\controllers;
	use app\models\mainModel;

	class dashboardController extends mainModel{

		/*----------  Obtener total alumnos activos  ----------*/
		public function obtenerAlumnosActivosSedeL(){
			$alumnosActivosSedeL=$this->ejecutarConsulta("SELECT count(*) totalActivosSedeL FROM sujeto_afiliado WHERE afiliado_estado='A' and afiliado_sedeid = 1");
		    return $alumnosActivosSedeL;
		}

		public function obtenerAlumnosActivosSedeC(){
			$alumnosActivosSedeC=$this->ejecutarConsulta("SELECT count(*) totalActivosSedeC FROM sujeto_afiliado WHERE afiliado_estado='A' and afiliado_sedeid = 2");
		    return $alumnosActivosSedeC;
		}

        public function obtenerAlumnosActivosSedeV(){
			$alumnosActivosSedeV=$this->ejecutarConsulta("SELECT count(*) totalActivosSedeV FROM sujeto_afiliado WHERE afiliado_estado='A' and afiliado_sedeid = 3");
		    return $alumnosActivosSedeV;
		}

		/*----------  Obtener total alumnos inactivos  ----------*/
		public function obtenerAlumnosInactivosSedeL(){
			$alumnosActivosSedeL=$this->ejecutarConsulta("SELECT count(*) totalInactivosSedeL FROM sujeto_afiliado WHERE afiliado_estado='I' and afiliado_sedeid = 1");
		    return $alumnosActivosSedeL;
		}

		public function obtenerAlumnosInactivosSedeC(){
			$alumnosActivosSedeC=$this->ejecutarConsulta("SELECT count(*) totalInactivosSedeC FROM sujeto_afiliado WHERE afiliado_estado='I' and afiliado_sedeid = 2");
		    return $alumnosActivosSedeC;
		}

        public function obtenerAlumnosInactivosSedeV(){
			$alumnosActivosSedeV=$this->ejecutarConsulta("SELECT count(*) totalInactivosSedeV FROM sujeto_afiliado WHERE afiliado_estado='I' and afiliado_sedeid = 3");
		    return $alumnosActivosSedeV;
		}
	}

		