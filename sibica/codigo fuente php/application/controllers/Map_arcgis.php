<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: * ");
class Map_arcgis extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Map_arcgis_model');
       	$this->load->model('Utilidades_model');		       
	}
	
	public function index() {
		$data = array();
		
		//$usuario = $this->session->userdata('codigo_usuario');
		//$identificacion_usuario = $this->session->userdata('identificacion'); 		
		$predios = $this->traerPredios();
		$data['predios'] = json_encode($predios);
        
        $this->load->view('map_arcgis', $data);
	}
	

	public function traerPredios(){
		$predios = $this->Map_arcgis_model->getPredios();
		$objPredios = array();

		for($g=0; $g<count($predios); $g++){
			$predio = (array) $predios[$g];
			$coordenadas = array();
			$coordenadas[] = $predio['lng'];
			$coordenadas[] = $predio['lat'];

			if(isset($objPredios[$predio['gid']])){
				$objPredios[$predio['gid']]['rings'] [] = $coordenadas;
			}else{
				$objPredios[$predio['gid']] = array();
				$objPredios[$predio['gid']]['codigo'] = $predio['gid'];
				$objPredios[$predio['gid']]['nombre'] = $predio['nombre'];
				$objPredios[$predio['gid']]['type'] = 'polygon';
				$objPredios[$predio['gid']]['rings'] = array();
				$objPredios[$predio['gid']]['rings'] [] = $coordenadas;
			}			
		}
		
		return $objPredios;
	}


	public function wsPredios(){           
      
      $status = 0;  
      $mensaje = "No hay predios"; 
      $datosPredios = array();
      $respuesta = array();        
 
      $result = $this->traerPredios(); 

      if (count($result) > 0) {
          $mensaje = "Se encontraron predios";
          $status = 1; 
      }       

       $respuesta = array('status' => $status, 
                          'message' => $mensaje,
                          'data' => $result);            
      
       $this->output->set_content_type('application/json')->set_output(json_encode($respuesta));       
      

     }   

}

?>