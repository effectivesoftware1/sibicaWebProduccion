<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Reporte_irregular extends CI_Controller{

	public function __construct() {
		parent::__construct();		 
        $this->load->model('Reporte_irregular_model');
        $this->load->model('Login_model');        
        $this->load->model('Utilidades_model');
	}
	
	public function index() {
		$data = array();
       	//$this->load->view('Home',$data);
    }
    
    public function traerReporteIrregular(){
        $result = array();
        $objParam = array();
        $predio = $this->input->post('codPredio');
        //$datosUsuario =   $this->Login_model->getDatosUsuaro();
        $objParam['codPredio'] = $predio;
        $clases_estado = array('class' => 'form-control');
        $result['result'] = $this->Reporte_irregular_model->traerReporteIrregular_data($objParam);
        $dataResult = $result['result'];
        $objMs = isset($dataResult['msj_reporte']) ? $dataResult['msj_reporte'] : array();
        $defaultTipoReporte = '-1';
        $textDefault = isset($dataResult['tipo_reporte']) ? $dataResult['tipo_reporte'] : '-1' ;
        for($x=0; $x<count($objMs); $x++){
            $msObj = $objMs[$x];
            if($msObj['nombre'] == $textDefault){
                $defaultTipoReporte = $msObj['id'];
            }
        }
        
        $clases_estado['_SELECCIONAR_'] = $defaultTipoReporte;
        $result['opTipoReporte'] = $this->Utilidades_model->generarComboWhere('','public.tipo_reporte', 'id_tr', 'nombre_tr', '2','Seleccione tipo de reporte','estado_tr_fk IN(1)', true, $clases_estado);
        $existeReporte = isset($result['result']['existe_reporte']) ? $result['result']['existe_reporte'] : -1;
        $objParam['attrDisabled'] = $existeReporte == 1 ? 'disabled' : '' ;
        $objParam['opTipoReporte'] = $result['opTipoReporte'];
        $objParam['predial'] = isset($result['result']['predial']) ? $result['result']['predial'] : '';
        $objParam['direccion'] = isset($result['result']['direccion']) ? $result['result']['direccion'] : '';
        $objParam['nombre'] = isset($result['result']['nombre']) ? $result['result']['nombre'] : '';
        $objParam['cedula'] = isset($result['result']['cedula']) ? $result['result']['cedula'] : '';
        $objParam['correo'] = isset($result['result']['correo']) ? $result['result']['correo'] : '';
        $objParam['telefono'] = isset($result['result']['telefono']) ? $result['result']['telefono'] : '';
        $objParam['adjunto'] = isset($result['result']['adjunto']) ? $result['result']['adjunto'] : '';
        $objParam['observacion'] = isset($result['result']['observacion']) ? $result['result']['observacion'] : '';
        $objParam['orfeo'] = isset($result['result']['orfeo']) ? $result['result']['orfeo'] : '';
        $objParam['attrDisabled_direccion'] = $objParam['direccion'] != '' ? 'disabled' : '';
        $objParam['dirObligatorio'] = $objParam['predial'] != '' ? '' : 'obligatorio';
        
        if($existeReporte >= 1){
            $result['frm'] = 'Estimado usuario, ya existe un reporte irregular en el predio seleccionado. <br>No. orfeo: <b>'.$objParam['orfeo'].'</b>';
        }else{
            $result['frm'] = $this->load->view('reporteIrregular/frm_reporteIrregular', $objParam, true);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    } 
  
    public function guardarReporteIrregular(){
        $file_element_name = 'adjunto';
        $typeFile = '*';          
        $rutaParametro = "./asset/public/fileUpload/"; 

        $nameImg = $_FILES[$file_element_name]["name"];
        $nombreEncrypImg="";
        $ress = "";
   
      	if ($nameImg != "") {
            $nombreEncrypImg = $this->Utilidades_model->UploadImage($rutaParametro,$file_element_name,$typeFile);   
       	} 

       	if ($nombreEncrypImg != false OR  $nameImg == "") {
            $objParam = array(
                "codPredio" => $this->input->post("codPredio"),
                "tipoReporte" => $this->input->post("tipoReporteText"),
                "predial" => $this->input->post("predial"),
                "direccion" => $this->input->post("direccion"),
                "nombre" => $this->input->post("nombre"),
                "cedula" => $this->input->post("cedula"),
                "correo" => $this->input->post("correo"),
                "telefono" => $this->input->post("telefono"),
                "adjunto" => $rutaParametro.$nombreEncrypImg,
                "observacion" => $this->input->post("observacion"),
                "ip" => $_SERVER['REMOTE_ADDR'],
                "orfeo" => "-1",
                "dataSesion" => $this->Utilidades_model->getDataSesion()
            );
            
            if($objParam['codPredio'] == '-1'){
                $coordenadas = $objParam['direccion'];
            }else{
                $coordenadas = $this->Reporte_irregular_model->getPoligonoCordenadas($objParam['codPredio']);
            }

            $result["orfeo"] = $this->Utilidades_model->wsOrfeo($objParam['adjunto'], $objParam['tipoReporte'], $objParam['direccion'], $objParam['codPredio'], $objParam['nombre'], $objParam['correo'], $objParam['telefono'], $coordenadas, $objParam['ip'], $objParam['cedula']);
            $objParam["orfeo"] = $result["orfeo"];
            $result["result"] = $this->Reporte_irregular_model->guardarReporteIrregular_data($objParam);
            
        }else{
            $result["result"] = 'Se presentaron inconvenientes al guardar el archivo';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

 
}

?>