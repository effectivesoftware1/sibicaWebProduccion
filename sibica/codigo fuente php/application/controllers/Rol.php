<?php 

  class Rol extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Rol_model');  
        $this->load->model('Utilidades_model');
  	}    
	
	public function crearTablaRol(){

		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('rol');
		$datos = $this->getRol();
		
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){
			$codigo = $datos[$e]->id_rol_pk;
			$nombre = $datos[$e]->nombre_rol;
			$descripcion = $datos[$e]->descripcion_rol;
			$estado = $datos[$e]->estado_rol_fk; 
			$datos[$e]->editar = '<div class="class_edit" onclick="javascript:editRol(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\','.$estado.');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			$datos[$e]->permisos = '<div class="class_edit" onclick="javascript:permisosRol(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\','.$estado.');"><center><img src="./asset/public/img/check.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_rol', $columnas, $datos);
		
		return $tabla;
	}
	
	public function getRol(){
		$this->Utilidades_model->validaSession();
		$objParam = array();
		$data = $this->Rol_model->getDataRol($objParam);
		
		return $data;
	}

	public function guardarDatos(){
		$this->Utilidades_model->validaSession();
		$nombre = $this->input->post("nom_rol");
		$descripcion = $this->input->post("des_rol");
		$objParam = array(
						"tipo" => "insert",
						"tabla" => "public.rol",
						"campos" => "nombre_rol,descripcion_rol,estado_rol_fk",                       
                        "datos"  => "'$nombre','$descripcion',1",						
						"condicional" => "",
						'dataSesion' => $this->Utilidades_model->getDataSesion()
						);
		
		$resultado['result'] = $this->Rol_model->ejecutarSentencia($objParam);
		$resultado['tabla'] = $this->crearTablaRol();
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}
	
	public function editarDatos(){
		$this->Utilidades_model->validaSession();
		$codigo = $this->input->post("codigo_rol");
		$nombre = $this->input->post("nom_rol");
		$descripcion = $this->input->post("des_rol");
      	$estado = $this->input->post("estado_rol"); 

		$objParam = array(
						"tipo" => "update",
						"tabla" => "public.rol",
						"campos" => "nombre_rol = '$nombre',descripcion_rol = '$descripcion',estado_rol_fk = '$estado'",                       
                        "datos"  => "", 						
						"condicional" => "id_rol_pk=".$codigo,
						'dataSesion' => $this->Utilidades_model->getDataSesion()
						);
		
		$resultado['result'] = $this->Rol_model->ejecutarSentencia($objParam);
		$resultado['tabla'] = $this->crearTablaRol();
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}
	
	public function traerPermisosRol(){
		$this->Utilidades_model->validaSession();
		$codigoRol = $this->input->post("cod_rol");
		$codModulo_aux = '2'; //Codigo del modulo iformacion predio
		$arrChecked = array("","checked");
		$arrDatos = array();
		$objDatos = array();
		$objParam = array(
							"cod_rol" => $codigoRol
						);
		$objParamCampo = array(
						"cod_modulo" => $codModulo_aux,
						"cod_rol" => $codigoRol
					);
		
		$resData = $this->Rol_model->traerPermisosRol_data($objParam);		
		$resDataCampos = $this->Rol_model->traerPermisosRolModCampo_data($objParamCampo);

		for($x=0; $x<count($resData); $x++){
			$permiModulo = (array) $resData[$x];
			$codModulo = $permiModulo['cod_modulo'];
			$permiModulo['ch_insertar'] = '<input type="checkbox" id="chm1_'.$codModulo.'" '.$arrChecked[$permiModulo['insertar']].' onChange="fn_permisoModulo(this.id,\''.$codigoRol.'\',\''.$codModulo.'\',\'0\')">';
			$permiModulo['ch_editar'] = '<input type="checkbox" id="chm2_'.$codModulo.'" '.$arrChecked[$permiModulo['editar']].' onChange="fn_permisoModulo(this.id,\''.$codigoRol.'\',\''.$codModulo.'\',\'1\')">';
			$permiModulo['ch_consultar'] = '<input type="checkbox" id="chm3_'.$codModulo.'" '.$arrChecked[$permiModulo['consultar']].' onChange="fn_permisoModulo(this.id,\''.$codigoRol.'\',\''.$codModulo.'\',\'2\')">';
			$permiModulo['ch_eliminar'] = '<input type="checkbox" id="chm4_'.$codModulo.'" '.$arrChecked[$permiModulo['eliminar']].' onChange="fn_permisoModulo(this.id,\''.$codigoRol.'\',\''.$codModulo.'\',\'3\')">';
			//$permiModulo['bt_campos'] = '<div class="class_edit" onclick="javascript:fn_editPermisosCampos(\''.$codigoRol.'\',\''.$codModulo.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			
			$permiModulo['campos'] = json_decode($permiModulo['campos'], true);
			$arrDatos[] = $permiModulo;
			$objDatos[$codModulo] = $permiModulo;
		}

		$resultado['result'] = $resData;
		$resultado['objDatos'] = $objDatos;
		$resultado['arrDatos'] = $arrDatos;
		$resultado['arrDatosCampos'] = $resDataCampos;
		$resultado['tabla'] = $this->crearTablaPermisosRol($resultado['arrDatos']);
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function crearTablaPermisosRol($data){
		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('rol_permisos');
		$tabla = $this->Utilidades_model->createTable('tabla_rol_permisos', $columnas, $data);
		
		return $tabla;
	}

	public function guardarPermisosRol(){
		$this->Utilidades_model->validaSession();
		$numeroIteracion = $this->input->post("iteracion");
		$codigoRol = $this->input->post("cod_rol");
		$permisos = $this->input->post("permisos");		
		$arrCampos = json_decode($this->input->post("registros"), true);
		$codModuloPermiso_aux = array();
		$codModuloPermisoCampo_aux = array();
		$codModuloPermiso_camp = -1;
		$codModulo_aux = 2;
		
		//foreach ($permisos as $key => $value) {
		for($x=0; $x<count($permisos); $x++){
			$permisosModulo = $permisos[$x];//$value;
			$objParam = array(
				"cod_modulo_permiso" => $permisosModulo['cod_modulo_permiso'],
				"cod_modulo" => $permisosModulo['cod_modulo'],
				"cod_rol" => $codigoRol,//$permisosModulo['cod_rol'],
				"insertar" => $permisosModulo['insertar'],
				"editar" => $permisosModulo['editar'],
				"consultar" => $permisosModulo['consultar'],
				"eliminar" => $permisosModulo['eliminar'],
				"cod_estado" => $permisosModulo['cod_estado'],
				"dataSesion" => $this->Utilidades_model->getDataSesion()
			);
			$codModuloPermiso = $this->Rol_model->guardarPermisosRol_data($objParam);
			$codModuloPermiso_aux [] = $codModuloPermiso;
			if($codModuloPermiso > -1 && $permisosModulo['cod_modulo'] == $codModulo_aux){ //Modulo informacion predio (2)
				$codModuloPermiso_camp = $codModuloPermiso;
				//$codModuloPermisoCampo = $this->guardarPermisosRolCampo($codModuloPermiso, $permisosModulo['campos']);
				//$codModuloPermisoCampo_aux [] = $codModuloPermisoCampo;
			}
		}

		if($codModuloPermiso_camp > -1){ //Modulo informacion predio (2)
			$codModuloPermisoCampo = $this->guardarPermisosRolCampo($codModuloPermiso_camp, $arrCampos, $numeroIteracion);
			$codModuloPermisoCampo_aux [] = $codModuloPermisoCampo;
		}

		$resultado['result'] = 'Operaci&oacute;n realizada correctamente.';
		$resultado['moduloPermiso'] = $codModuloPermiso_aux;
		$resultado['moduloPermisoCampo'] = $codModuloPermisoCampo_aux;
		$resultado['num-itera'] = $numeroIteracion;
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function guardarPermisosRolCampo($codModuloPermiso, $arrCampos, $iteracion){
		$this->Utilidades_model->validaSession();
		$codModuloPermisoCampo = array();
		if($iteracion == 0){
			$quitPermisosCampo = $this->Rol_model->EliminarPermisosRolCampo_data($codModuloPermiso);
		}
		
		for($c=0; $c<count($arrCampos); $c++) {
			$campo = $arrCampos[$c];
			if($campo['estado'] == '1'){
				$objParam = array(
					"cod_modulo_permiso" => $codModuloPermiso,
					"cod_modulo" => $campo['cod_campo'],
					"dataSesion" => $this->Utilidades_model->getDataSesion()
				);
				
				$codModuloPermisoCampo[] = $this->Rol_model->guardarPermisosRolCampo_data($objParam);
			}			
		}

		return $codModuloPermisoCampo;
	}
	
  }


 ?>