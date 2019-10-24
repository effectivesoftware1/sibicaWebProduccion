<?php 

  class Modulo extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Modulo_model');  
        $this->load->model('Utilidades_model');
  	}    
	
	public function crearTabla(){
		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('modulo');
		$datos = $this->getData();
		
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){
			$codigo = $datos[$e]->id_mod;
			$nombre = $datos[$e]->nombre_mod;
			$descripcion = $datos[$e]->descripcion_mod;			
			$datos[$e]->editar = '<div class="class_edit" onclick="javascript:editModulo(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_modulo', $columnas, $datos);
		
		return $tabla;
	}
	
	public function getData(){
		$this->Utilidades_model->validaSession();
		$objParam = array();
		$data = $this->Modulo_model->getData($objParam);
		
		return $data;
	}

	public function guardarDatos(){
		$this->Utilidades_model->validaSession();
		$nombre = $this->input->post("nom_modulo");
		$descripcion = $this->input->post("des_modulo");
		$objParam = array(
						"tipo" => "insert",
						"tabla" => "public.modulo",
						"campos" => "nombre_mod,descripcion_mod",                       
                        "datos"  => "'$nombre','$descripcion'",						
						"condicional" => "",
						'dataSesion' => $this->Utilidades_model->getDataSesion()
						);
		
		$resultado['result'] = $this->Modulo_model->ejecutarSentencia($objParam);
		$resultado['tabla'] = $this->crearTabla();
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}
	
	public function editarDatos(){
		$this->Utilidades_model->validaSession();
		$codigo = $this->input->post("codigo_modulo");
		$nombre = $this->input->post("nom_modulo");
		$descripcion = $this->input->post("des_modulo");      

		$objParam = array(
						"tipo" => "update",
						"tabla" => "public.modulo",
						"campos" => "nombre_mod = '$nombre',descripcion_mod = '$descripcion'",                       
                        "datos"  => "", 						
						"condicional" => "id_mod=".$codigo,
						'dataSesion' => $this->Utilidades_model->getDataSesion()
						);
		
		$resultado['result'] = $this->Modulo_model->ejecutarSentencia($objParam);
		$resultado['tabla'] = $this->crearTabla();
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function deteteDatos(){
		$this->Utilidades_model->validaSession();
		$codigo = $this->input->post("cod_modulo");		

		$objParam = array(
						"tipo" => "delete",
						"tabla" => "public.modulo",
						"campos" => "",
						"datos"  => "", 
						"condicional" => "id_mod = ".$codigo,
						'dataSesion' => $this->Utilidades_model->getDataSesion()
						);		
		
		$resultado['result'] = $this->Modulo_model->ejecutarSentencia($objParam);
		$resultado['tabla'] = $this->crearTabla();
		$ress = json_encode($resultado);
        $this->output->set_content_type('application/json')->set_output($ress);
	}	
	
  }


 ?>