<?php 

  class Campo extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Campo_model'); 
        $this->load->model('Utilidades_model');        
  	} 

  	public function crearTableCampo(){
        $this->Utilidades_model->validaSession(); 
		$columnas = $this->Utilidades_model->columnCbz('campo');
		$datos = $this->Campo_model->getDataCampos();
		
		//adicionar editar y eliminar
		/*for($e=0; $e<count($datos); $e++){			
			$nombre = $datos[$e]->tablename;			
			$datos[$e]->eliminar = '<div class="class_edit" onclick="javascript:eliminarTabla(\''.$nombre.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
		}*/
		
		$tabla = $this->Utilidades_model->createTable('tabla_campo', $columnas, $datos);
		
		return $tabla;
	}   
	
	public function saveCampos(){

        $this->Utilidades_model->validaSession(); 
    	$datos = $this->input->post("campos");
    	$tabla = $this->input->post("tabla");
    	$arrayDatos = array('datos' => $datos,'tabla' => $tabla,'dataSesion' => $this->Utilidades_model->getDataSesion());
    	$data["result"] = $this->Campo_model->saveCampos($arrayDatos);
    	$data["tabla"] = $this->crearTableCampo();    	

    	$this->output->set_content_type('application/json')->set_output(json_encode($data));

    }


    public function getCampos(){

        $this->Utilidades_model->validaSession();     	
    	$tabla = $this->input->post("tabla");    	
    	$data = $this->Campo_model->getDataCamposChema($tabla);

    	$cadenaLista = '';
        for($p=0; $p < count($data); $p++){
            $dato = (array) $data[$p];
            $nombre = $dato['column_name'];
            $cadenaLista .= '<option  value="'.$nombre.'" >'.$nombre.'</option>';
        }

        $data["campos"] = $this->Campo_model->getDataCampos();
        $data["result"] = $cadenaLista;

    	$this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    

	
  }


 ?>