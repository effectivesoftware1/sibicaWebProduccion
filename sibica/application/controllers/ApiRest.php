<?php 
	
	class ApiRest extends CI_Controller{
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Utilidades_model');
			$this->load->model('ApiRest_model'); 
        }


        public function get(){

          $datos = $this->ApiRest_model->get();         

          $this->output->set_content_type('application/json')->set_output(json_encode($datos));
        
        }

         public function get_one(){
              $codigo = $_REQUEST["codigo"];              
              $datos = $this->ApiRest_model->get_one($codigo);
              $this->output->set_content_type('application/json')->set_output(json_encode($datos));        
        }   
       
        
    }
	
	
?>