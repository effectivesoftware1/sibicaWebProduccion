<?php 

  class Tipo_amoblamiento extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Tipo_amoblamiento_model');  
        $this->load->model('Utilidades_model');
  	}    
	
	public function crearTabla(){

		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('tipo_amoblamiento');
		$datos = $this->getDatos();
		
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){
			$codigo = $datos[$e]->id_ta;
			$nombre = $datos[$e]->nombre_ta;			
			$estado_codigo = $datos[$e]->estado_ta_fk;
			$estado_nombre = $datos[$e]->nombre_estado;
			$file_codigo = is_null($datos[$e]->icono_ta_fk) == true ? 0 :  $datos[$e]->icono_ta_fk;
			$ruta_file = $datos[$e]->ruta_file;
			$nombre_file = $datos[$e]->nombre_file;

			$datos[$e]->editar = '<div class="class_edit" onclick="javascript:editarTa(\''.$codigo.'\',\''.$nombre.'\','.$estado_codigo.',\''.$estado_nombre.'\','.$file_codigo.',\''.$ruta_file.'\',\''.$nombre_file.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_ta', $columnas, $datos);
		
		return $tabla;
	}
	
	public function getDatos(){

		$this->Utilidades_model->validaSession();
		$objParam = array();
		$data = $this->Tipo_amoblamiento_model ->getData($objParam);
		
		return $data;
	}

	public function guardarDatos(){

		$this->Utilidades_model->validaSession();

		$codigo = $this->input->post("codigo");	
		$nombre = $this->input->post("nom_ta");	
		$estado = $this->input->post("estado_ta");
		$codigo_file = $this->input->post("codigo_file_ta");

		$file_element_name = 'file_ta';
        $typeFile = '*';          
        $rutaParametro = "./asset/public/fileUpload/"; 

        $nameImg = $_FILES["file_ta"]["name"];
        $nombreEncrypImg="";
        $ress = "";
   
      	if ($nameImg != "") {
          $nombreEncrypImg = $this->Utilidades_model->UploadImage($rutaParametro,$file_element_name,$typeFile);   
       	} 

       	if ($nombreEncrypImg != false OR  $nameImg == "") {       

			$objParam = array(
							"codigo" => $codigo,
							"nombre" => $nombre,
							"estado" => $estado,
							'dataSesion' => $this->Utilidades_model->getDataSesion(),
							'codigo_file' => $codigo_file,
							'nameFile' => $nameImg,
							'ruta_file' => $rutaParametro.$nombreEncrypImg
							);
			
			$resultado['result'] = $this->Tipo_amoblamiento_model ->ejecutarSentencia($objParam);
			$resultado['tabla'] = $this->crearTabla();
			$ress = json_encode($resultado);

			$rutaAnterior = $this->input->post("file_ta_ant");      

	         if (file_exists($rutaAnterior) && $nameImg != "") {
	            @unlink($rutaAnterior);
	         }	
		}

        $this->output->set_content_type('application/json')->set_output($ress);
	}	
	
  }


 ?>