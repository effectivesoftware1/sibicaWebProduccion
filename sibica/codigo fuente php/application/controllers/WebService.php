<?php 
	
	class WebService extends CI_Controller{
		
		public function __construct() {
			parent::__construct();
			$this->load->model('Utilidades_model');
            $this->load->model('WebService_model'); 
            $this->load->model('Panorama_riesgos_model'); 
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

      public function enviarEmailTareasResponsable(){

            $numeroDiasTarea = $this->Utilidades_model->getParametro(3);
            $datos = $this->WebService_model->validTareasVencidasResponsable($numeroDiasTarea);
            $mensaje = "";
            $from = $this->Utilidades_model->getParametro(7);
            $name = "sibica";
            $asunto = "Panorama de riesgos";

            //adicionar editar y eliminar
            for($e=0; $e<count($datos); $e++){
                $to = $datos[$e]->correo;
                $numPanorama = $datos[$e]->cod_panorama;
                $mensaje =  "La Unidad Administrativa Especial de Gesti&oacute;n de Bienes y Servicios le recuerda que Usted tiene una o varias tareas a su cargo de acuerdo con el Panorama de Riesgos No. ".$numPanorama.", las cuales est&aacute;n pr&oacute;ximas a vencer,  le invitamos a consultar mayor informaci&oacute;n visitando SIBICA (www.cali.gov.co/bienes), m&oacute;dulo de Gesti&oacute;n de Panoramas de Riesgo, con el N&uacute;mero de Panorama citado.
                              Agradecemos su atención a la presente. <br><br>  Cordialmente, <br><br><br>
                              Equipo de Seguros.<br>
                              Unidad Administrativa Especial de Gesti&oacute;n de Bienes y Servicios.<br> 
                              Tel:<br>
                              Edificio CAM, Piso 16.";   

                $result =$this->Utilidades_model->enviarEmail2($from,$to,$asunto,$mensaje,$name,"","");
            } 

            $this->output->set_content_type('application/json')->set_output(json_encode($result));         

      }


       public function enviarEmailTareasEjecutor(){

            $numeroDiasTarea = $this->Utilidades_model->getParametro(4);
            $datos = $this->WebService_model->validTareasVencidasResponsable($numeroDiasTarea);
            $mensaje = "";
            $from = $this->Utilidades_model->getParametro(7);
            $name = "sibica";
            $asunto = "Panorama de riesgos";
            $to = explode(",", $this->Utilidades_model->getParametro(2));

            //adicionar editar y eliminar
            for($e=0; $e<count($datos); $e++){
                
                $numPanorama = $datos[$e]->cod_panorama;
                $direccion_terrno = $datos[$e]->direccion_terreno;
                $nombre_terreno = $datos[$e]->nombre_terreno;
                $mensaje =   "El Sistema de Informaci&oacute;n de Bienes Inmuebles de Cali- SIBICA, ha detectado el vencimiento de una o varias tareas asociadas al Panorama de Riesgos No. $numPanorama efectuado al predio $nombre_terreno ubicado en $direccion_terrno.
                              Puede consultar mayor informaci&oacute;n ingresando a SIBICA (www.cali.gov.co/bienes) con el N&uacute;mero de Panorama citado.";
                                           
                for($i=0; $i<count($to); $i++){
                  $result =$this->Utilidades_model->enviarEmail2($from,$to[$i],$asunto,$mensaje,$name,"","");
                }
            } 

            $this->output->set_content_type('application/json')->set_output(json_encode($result));                    

      }

     
        
}
	
	
?>