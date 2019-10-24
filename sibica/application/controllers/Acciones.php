<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Acciones extends CI_Controller{

	public function __construct() {
		parent::__construct();		 
		$this->load->model('Home_model');		 
       	$this->load->model('Utilidades_model');	
	}
	
	public function index() {
		$clases = array();
		$data["accion"] = isset($_GET['accion']) ? $_GET['accion'] : '-1'; 
		$data["predio"] = isset($_GET['predio']) ? $_GET['predio'] : '-1'; 
		$data["predio_const"] = isset($_GET['predio_const']) ? $_GET['predio_const'] : '-1';
		$data["iniciarSessionView"] = $this->load->view('login/Inicio_sesion','',TRUE);
		$data["url_doc"] = isset($_GET['calidadbien']) ? $_GET['calidadbien'] : '-1';
		
		//Valida y llena permisologia invitado
		$codUser = $this->session->userdata('codigoUsuario');
        if(!$codUser){
            $this->Utilidades_model->llenarSesionInvitado();
        }
        
        $this->load->view('acciones', $data);
	}

}

?>
