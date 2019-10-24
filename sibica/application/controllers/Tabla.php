<?php 

  class Tabla extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Tabla_model'); 
        $this->load->model('Utilidades_model');        
  	} 

  	public function crearTableTabla(){
  		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('tabla');
		$datos = $this->Tabla_model->getDatosTablas();
		
		//adicionar editar y eliminar
		/*for($e=0; $e<count($datos); $e++){			
			$nombre = $datos[$e]->tablename;			
			$datos[$e]->eliminar = '<div class="class_edit" onclick="javascript:eliminarTabla(\''.$nombre.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
		}*/
		
		$tabla = $this->Utilidades_model->createTable('tabla_tabla', $columnas, $datos);
		
		return $tabla;
	}   
	
	public function saveTablas(){

		$this->Utilidades_model->validaSession();
    	$datos = $this->input->post("datos");
    	$arrayDatos = array('datos' => $datos,'dataSesion' => $this->Utilidades_model->getDataSesion());
    	$data["result"] = $this->Tabla_model->saveTablas($arrayDatos);
    	$data["tabla"] = $this->crearTableTabla();

    	$this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

	
  }


 ?>