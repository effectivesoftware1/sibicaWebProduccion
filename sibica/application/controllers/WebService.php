<?php 
	
	class WebService extends CI_Controller{
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Utilidades_model');
         $this->load->model('WebService_model'); 
         $this->load->model('Panorama_riesgos_model'); 
        }       

        //funcionque se ejecuta desde payu cuando se confirme el pago
        public function confirPago(){
                $referenceCode = $_REQUEST['reference_sale'];
                $fechaInicial = "";
                $fechaFinal = "";
                $aux_new_valueArray = array();
                $aux_new_value = "";
                $new_value_count = 0;
                $lastValue = 0;
                $value = 0;

             // se creaa el signature con los datos de respuesta pra despues compararla

                $apikey = $this->Utilidades_model->getParametro(52)->result;
                $sign =   $_REQUEST['sign'];
                $value = (string)$_REQUEST['value'];
                $aux_new_valueArray = explode(".",$value);

                 if(isset($aux_new_valueArray[1])){

                    $aux_new_value = $aux_new_valueArray[1];
                    $new_value_count = strlen($aux_new_value)-1;
                    $lastValue = $aux_new_value[$new_value_count];

                    if ($lastValue == 0) {
                       $new_value = substr($value,0,strlen($value)-1);
                    }else{
                       $new_value = $value;
                    }

                 }else{
                    $new_value = $value.'.0';
                 }               


                $aux_signature = $apikey.'~'.$_REQUEST['merchant_id'].'~'.$referenceCode.'~'.$new_value.'~'.$_REQUEST['currency'].'~'.$_REQUEST['state_pol'];
                $signature = md5($aux_signature);
        

            if ($_REQUEST['state_pol'] == 4 AND $_REQUEST['response_code_pol'] == 1 AND $signature == $sign) { 
                 
                 $this->db->set('fk_estado', 3);
                 $this->db->where('pk_id', $referenceCode);
                 $this->db->update('c_millon.c_mil_pedido');

                 $parameters = array('param1' => "",
                                     'param2' => intval($referenceCode),
                                     'param3' => 1);
        
                $datos = $this->Pedido_model->confirmarPedido($parameters);                   


            }   
       
      }

      public function responseUrl(){ 

        if ($_REQUEST['transactionState'] == 4) {             
             redirect("Home?param=1");            
        }else{
             $url = "Home?param=0";
             redirect($url);
        }       
       
     }

     public function delteUsuariosDummy(){
         $this->WebService_model->delteUsuariosDummy();
     }
     
      public function llamarTareaPanorama_ws(){
         $ress = array();
         $paramObj = array();
         $ress['estado'] = 0;
         $ress['mensaje'] = 'Ok';
         $ress['datos'] = array();

         if (count($_REQUEST) == 0) {
            $ress['estado'] = 1;
            $ress['mensaje'] = 'Faltan parámetros por enviar';
         }else{
            $paramObj['codPanorama'] = isset($_REQUEST['codPanorama']) ? $_REQUEST['codPanorama'] : '-1';
            $paramObj['codTarea'] = isset($_REQUEST['codTarea']) ? $_REQUEST['codTarea'] : '-1';
            $paramObj['codUsuario'] = isset($_REQUEST['codUsuario']) ? $_REQUEST['codUsuario'] : '-1';
            $ress['datos'] = $this->Panorama_riesgos_model->llamarTareaPanorama_data($paramObj);
         }

         $this->output->set_content_type('application/json')->set_output(json_encode($ress));
      }


      public function llamarSeguimientoTarea_ws(){
         $ress = array();
         $paramObj = array();
         $ress['estado'] = 0;
         $ress['mensaje'] = 'Ok';
         $ress['datos'] = array();

         if (count($_REQUEST) == 0) {
            $ress['estado'] = 1;
            $ress['mensaje'] = 'Faltan parámetros por enviar';
         }else{
            //$paramObj['codPanorama'] = isset($_REQUEST['codPanorama']) ? $_REQUEST['codPanorama'] : '-1';
            $paramObj['codTarea'] = isset($_REQUEST['codTarea']) ? $_REQUEST['codTarea'] : '-1';
            $paramObj['codSeguimiento'] = isset($_REQUEST['codSeguimiento']) ? $_REQUEST['codSeguimiento'] : '-1';
            $paramObj['codUsuario'] = isset($_REQUEST['codUsuario']) ? $_REQUEST['codUsuario'] : '-1';
            $ress['datos'] = $this->Panorama_riesgos_model->llamarSeguimientoTarea_data($paramObj);
         }

         $this->output->set_content_type('application/json')->set_output(json_encode($ress));
      }
        
}
	
	
?>