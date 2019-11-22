<?php 

  class Panorama_riesgos extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Panorama_riesgos_model');  
        $this->load->model('Utilidades_model');
        $this->load->model('Login_model'); 
  	} 	
	
	public function crearTabla($p_fecha_inicial,$p_fecha_final){
		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('panorama');
		if ($p_fecha_inicial == -1) {
			$datos = $this->getData(-1);
		}else{
			$datos = $this->getDataFechas($p_fecha_inicial,$p_fecha_final);
		}		
		
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){

			$codigo = $datos[$e]->id_panorama;			
			$descripcion = $datos[$e]->descripcion_panorama;
			$responsable = $datos[$e]->usuario_responsable;	
			$atendido_por = $datos[$e]->atendido_por_panorama;
			$correo_responsable = $datos[$e]->correo_responsable_panorama;	
			$usuario_crea = $datos[$e]->inspector;	
			$estado = $datos[$e]->estado_pr_fk;	
			$nombre_estado = $datos[$e]->nombre_estado;	
			$codigo_file = $datos[$e]->imagen_pr_fk;
			$ruta_file = $datos[$e]->ruta_file;	
			$nombre_file = $datos[$e]->nombre_file;
			$codigo_predio = $datos[$e]->construcion_pr_fk;
			$codigo_terreno = $datos[$e]->codigo_terreno;
			$fecha_inspeccion = $datos[$e]->fecha_creacion;
			$codigo_construccion = $datos[$e]->codigo_construccion;

			$datos[$e]->editar = '<div class="stilo_acciones"><div class="class_edit panorama-key-css_3" onclick="javascript:verpanorama(\''.$codigo.'\',\''.$descripcion.'\',\''.$responsable.'\',\''.$atendido_por.'\',\''.$correo_responsable.'\',\''.$usuario_crea.'\',\''.$estado.'\',\''.$nombre_estado.'\',\''.$ruta_file.'\',\''.$nombre_file.'\',\''.$codigo_file.'\',\''.$codigo_terreno.'\',\''.$fecha_inspeccion.'\',\''.$codigo_construccion.'\');"><center><img src="./asset/public/img/buscar.png" style="width: 21px;margin-top: 2px;cursor: pointer;"></center></div><div class="class_edit panorama-key-css_2" onclick="javascript:editpanorama(\''.$codigo.'\',\''.$descripcion.'\',\''.$responsable.'\',\''.$atendido_por.'\',\''.$correo_responsable.'\',\''.$usuario_crea.'\',\''.$estado.'\',\''.$nombre_estado.'\',\''.$ruta_file.'\',\''.$nombre_file.'\',\''.$codigo_file.'\',\''.$codigo_terreno.'\',\''.$fecha_inspeccion.'\',\''.$codigo_construccion.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div></div>';
			//$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_panorama', $columnas, $datos);
		
		return $tabla;
	}
	
	public function getData(){
		$this->Utilidades_model->validaSession();		
		$data = $this->Panorama_riesgos_model->getData(-1);
		
		return $data;
	}

	public function getDataFechas($fecha_inicial,$fecha_final){
		$this->Utilidades_model->validaSession();		
		$data = $this->Panorama_riesgos_model->getDataFecha($fecha_inicial,$fecha_final);
		
		return $data;
	}

	public function guardarPanorama(){

		$this->Utilidades_model->validaSession();		

		$codigo_panorama = $this->input->post("codigo");	
		$titulo = "";
		$descripcion_panorama = $this->input->post("descripcion_panorama");
		$usuario_res_panorama = $this->input->post("responsable_p");
		$estado_panorama = $this->input->post("estado_panorama");				
		$codigo_file = $this->input->post("codigo_file_panorama");
		$codigo_predio = trim($this->input->post("codigo_predio"));
		$codigo_construccion = trim($this->input->post("codigo_construccion"));
		$nom_edificacion	= $this->input->post("nom_edificacion");
		$email_responsable 	= $this->input->post("email_responsable");

		$file_element_name = 'file_panorama';
        $typeFile = '*';          
        $rutaParametro = "./asset/public/fileUpload/"; 

        $nameImg = $_FILES["file_panorama"]["name"];
        $nombreEncrypImg="";
        $ress = "";
   
      	if ($nameImg != "") {
          $nombreEncrypImg = $this->Utilidades_model->UploadImage($rutaParametro,$file_element_name,$typeFile);   
       	}

       	if ($nombreEncrypImg != false OR  $nameImg == ""){
			$objParam = array(
							"descripcion_panorama" => $descripcion_panorama,
							"usuario_res_panorama" => $usuario_res_panorama,
							"usuario_crea" => $this->session->userdata('codigoUsuario'),
							"codigo_predio" => $codigo_predio,
							'dataSesion' => $this->Utilidades_model->getDataSesion(),
							"codigo_panorama" => $codigo_panorama,
							"estado_panorama" => $estado_panorama,
							"titulo" => $titulo,
							'codigo_file' => $codigo_file,
							'nameFile' => $nameImg,
							'ruta_file' => $rutaParametro.$nombreEncrypImg,
							'email_responsable' => $email_responsable,
							'atendido_por' => $this->input->post("p_atendido_por"),
							'codigo_construccion' => $this->input->post("codigo_construccion")
							);
			
			$resultado['result'] = $this->Panorama_riesgos_model->guardarPanorama($objParam);
			$resultado['tabla'] = $this->crearTabla(-1,-1);
			$ress = json_encode($resultado);

			$rutaAnterior = $this->input->post("file_panorama_ant");      

	         if (file_exists($rutaAnterior) && $nameImg != "") {
	            @unlink($rutaAnterior);
	         }



	         if ($resultado['result'] == "Registro guardado correctamente.") {	         	
	         	$from = $this->Utilidades_model->getParametro(7);
            	$name = "Sibica";
            	$asunto = "Panorama de riesgos";
	         	$mensaje = "<h2>Panorama de riesgos</h2><hr><br>La unidad Administrativa Especial de Gestio&oacute;n de Bienes y Servicio ha levantado toda la informaci&oacute;n de Panoramas de Riesgos del bien inmueble <b>".$nom_edificacion."</b> a su cargo, puede consultar mayor informaci&oacute;n ingresando a la aplicaci&oacute;n SIBICA (www.cali.gov.co/bienes) en el m&oacute;dulo de Gesi&oacute;n de Panoramas de Riesgos. Con el siguiente No. <b>".$codigo_panorama."</b>";

	         	$arrayTo = array();
	         	$arrayTo = explode(",",$this->Utilidades_model->getParametro(2));
	         	$arrayTo[] = $email_responsable;

	         	for($e=0; $e<count($arrayTo); $e++){	         		                
	                $this->Utilidades_model->enviarEmail2($from,$arrayTo[$e],$asunto,$mensaje,$name,"","");
            	} 

	         }
		}

        $this->output->set_content_type('application/json')->set_output($ress);
	}	

	public function getSelUsuaro(){

		$this->Utilidades_model->validaSession();
        $data = $this->Login_model->getDatosUsuaro(1);
        $cadenaLista ='<option value="-1" >Seleccione</option>';
        for($p=0; $p<count($data); $p++){
            $dato = (array) $data[$p];
            $nombre = $dato['nombre_usuario'];
            $cadenaLista .= '<option  value="'.$dato['id_user_pk'].'" >'.$nombre.'</option>';
        }	      

        return $cadenaLista;
	}
	
	public function getPanoramas(){

	    $codigo_panorama = trim($this->input->post("codigo_panorama"));
	    $codigo_terreno = trim($this->input->post("codigo_predio"));
	    $codigo_predio_const = trim($this->input->post("codigo_predio_const"));
	    $data["datosPanorama"] = "";	   

        $aux_codigo_panorama =  $this->Panorama_riesgos_model->existePanorama($codigo_terreno,$codigo_predio_const);
	    
	    if ($aux_codigo_panorama != false) {	    
	    	$codigo_panorama = $aux_codigo_panorama;
	    	$data["datosPanorama"] =  $this->Panorama_riesgos_model->getData($codigo_panorama);
	    }	    

	    $dataPredio = $this->Panorama_riesgos_model->getDatosPredio($codigo_terreno,$codigo_predio_const);
        
        $parametros["codigo_estado"] = $dataPredio->codigo_estado;
        $parametros["nombre_estado"] = $dataPredio->nombre_estado;
        $parametros["nombre_cuenta"] = "Municipio de Santiago de Cali";
        $parametros["nombreEdificacion"] = $dataPredio->nombre;
        $parametros["localizacion"] = $dataPredio->direccion;
        $parametros["codigo_predio"] = $dataPredio->anio.$dataPredio->depencia.$dataPredio->secuencia;
  	    
  	    $columnasTarea = $this->Utilidades_model->columnCbz('tarea_panorama');	
  	    $arrayTares = array();
		//$tablaTarea = $this->Utilidades_model->createTable('tablaTareas', $columnasTarea, $arrayTares);
	    $parametros["tablaTarea"] = $this->getTablaTareasPanorama($codigo_panorama);
  		
  		$data["panoramaView"] = $this->load->view('panorama_riesgos/panorama_riesgo',$parametros,TRUE);         
    	
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
  	}

	public function llamarTareaPanorama(){
		//$this->Utilidades_model->validaSession();
		$codPanorama = !is_null($this->input->post("codPanorama")) ? $this->input->post("codPanorama") : '-1';
		$codTarea = !is_null($this->input->post("codTarea")) ? $this->input->post("codTarea") : '-1';
		$frmParam = array();
		$columnasTarea = $this->Utilidades_model->columnCbz('tarea_panorama');
		$clases_estado = array('class'=>'form-control');
		$clases_tipoRiesgo = array('class'=>'form-control');
		$clases_tipoEjecucion = array('class'=>'form-control');
		$clases_riesgo = array('class'=>'form-control');
		$tabla_seguimiento = '';
		$dataArr = array();
		$colorPuntage = array('','#08EDD8','#5BED08','#EDB908','#F03108','#FFFFFF');
		$objParam = array(
			"codPanorama" => $codPanorama,
			"codTarea" => $codTarea
		);

		$existePanorama = $this->Panorama_riesgos_model->validPanorama($objParam);

		if($existePanorama){
			$data = $this->Panorama_riesgos_model->llamarTareaPanorama_data($objParam);
			$objDato = count($data) > 0 ? (array) $data[0] : array();
			$objDato = $codTarea != '-1' ? $objDato : array();

			for($d=0; $d<count($data); $d++){
				$dato = (array) $data[$d];
				$objDataStr = json_encode($dato);			
				$codigo = $dato['codTarea'];
				$dato['editar'] = '<div class="class_edit" data-str="'.$objDataStr.'" onclick="javascript:gestionarTareaPanorama(\''.$codPanorama.'\',\''.$codigo.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
				//$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';

				$dataArr[] = $dato;
			}

			if($codTarea != '-1'){
				$clases_estado['_SELECCIONAR_'] = isset($objDato['codEstado']) ? $objDato['codEstado'] : '-1';
				$clases_tipoRiesgo['_SELECCIONAR_'] = isset($objDato['codTipoRiesgo']) ? $objDato['codTipoRiesgo'] : '-1';
				$clases_tipoEjecucion['_SELECCIONAR_'] = isset($objDato['codTipoEjecucion']) ? $objDato['codTipoEjecucion'] : '-1';
				$clases_riesgo['_SELECCIONAR_'] = isset($objDato['codRiesgo']) ? $objDato['codRiesgo'] : '-1';
				$dataSeguimiento = isset($objDato['seguimiento']) ? $objDato['seguimiento'] : array();
				$columnasSeguimiento = $this->Utilidades_model->columnCbz('seguimiento_tarea');
				$tabla_seguimiento = $this->Utilidades_model->createTable('tablaSeguimientoTarea', $columnasSeguimiento, $dataSeguimiento);
			}else{
				$clases_estado['_SELECCIONAR_'] = '12';
			}
			
			$frmParam['attrDisabled'] = intval($codTarea) > 0 ? 'disabled' : '';
			$frmParam['codPanorama_tr'] =  $codPanorama != '-1' ? $codPanorama : ( isset($objDato['codPanorama']) ? $objDato['codPanorama'] : '');
			$frmParam['codTarea_tr'] = isset($objDato['codTarea']) ? $objDato['codTarea'] : '';
			$frmParam['titulo_tr'] = isset($objDato['titulo']) ? $objDato['titulo'] : '';
			$frmParam['tipoRiesgo_tr'] = $this->Utilidades_model->generarComboWhere('','public.tipo_riesgo', 'id_tipo_riesgo', 'nombre_tipo_riesgo', '2','Seleccione tipo riesgo','', true, $clases_tipoRiesgo);
			$frmParam['tipoEjecucion_tr'] = $this->Utilidades_model->generarComboWhere('','public.tipo_ejecucion', 'id_tipo_ejecucion', 'nombre_te', '2','Seleccione tipo ejecucion','estado_te_fk IN(1)', true, $clases_tipoEjecucion);
			$frmParam['fechaVence_tr'] = isset($objDato['fechaVence']) ? $objDato['fechaVence'] : '';
			$frmParam['estado_tr'] = $this->Utilidades_model->generarComboWhere('','public.estado', 'id_estado', 'nombre_estado', '1','','id_estado IN(9,11,12)', true, $clases_estado);
			$frmParam['foto_tr'] = isset($objDato['foto']) ? $objDato['foto'] : '';
			$frmParam['observacion_tr'] = isset($objDato['observacion']) ? $objDato['observacion'] : '';
			$frmParam['mejora_tr'] = isset($objDato['mejora']) ? $objDato['mejora'] : '';
			$frmParam['probabilidad_tr'] = isset($objDato['probabilidad']) ? $objDato['probabilidad'] : '0';
			$frmParam['severidad_tr'] = isset($objDato['severidad']) ? $objDato['severidad'] : '0';
			$frmParam['exposicion_tr'] = isset($objDato['exposicion']) ? $objDato['exposicion'] : '0';
			$frmParam['proteccion_tr'] = isset($objDato['proteccion']) ? $objDato['proteccion'] : '1';
			$frmParam['puntaje_tr'] = isset($objDato['puntaje']) ? $objDato['puntaje'] : '0';
			$frmParam['riesgo_tr'] = isset($objDato['nombreRiesgo']) ? $objDato['nombreRiesgo'] : '';//$this->Utilidades_model->generarComboWhere('','public.tipo_reporte', 'id_tr', 'nombre_tr', '2','Seleccione tipo de reporte','estado_tr_fk IN(1)', true, $clases_riesgo);
			$frmParam['codRiesgo_tr'] = isset($objDato['codRiesgo']) ? $objDato['codRiesgo'] : '-1';
			$frmParam['tablaSeguimiento_tr'] = $tabla_seguimiento;
			$frmParam['colorPuntage_tr'] = intval($frmParam['codRiesgo_tr']) > -1 ? $colorPuntage[intval($frmParam['codRiesgo_tr'])] : '#FFFFFF';

			$resultado['frm_tarea'] = $this->load->view('panorama_riesgos/panorama_tarea', $frmParam, true);
			$resultado['tbl_tarea'] = $this->Utilidades_model->createTable('tablaTareas', $columnasTarea, $dataArr);
			$resultado['clasifica_tarea'] = $this->Panorama_riesgos_model->traerClasificanionRiesgo();
			$resultado['status'] = 0;
		}else{
			$resultado['frm_tarea'] = 'Estimado usuario, por favor aseg&uacute;rese de haber guardado primero el panorama.';
			$resultado['tbl_tarea'] = '';
			$resultado['clasifica_tarea'] = array();
			$resultado['status'] = 1;
		}
		
		$resultado['result'] = $dataArr;
		
		$ress = json_encode($resultado);
		$this->output->set_content_type('application/json')->set_output($ress);
	} 

	public function getionarPanoramas(){
		
		$fecha_inicial = -1;
		$fecha_final = -1;		
        
        $parametros["tablaPanorama"] = $this->crearTabla($fecha_inicial,$fecha_final);
       	$data["panoramaViewTable"] = $this->load->view('panorama_riesgos/panorama_riesgo_table',$parametros,TRUE);         
    	
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}	

	public function llamarSeguimientoTarea(){
		//$this->Utilidades_model->validaSession();
		$codPanorama = !is_null($this->input->post("codPanorama")) ? $this->input->post("codPanorama") : '-1';
		$codTarea = !is_null($this->input->post("codTarea")) ? $this->input->post("codTarea") : '-1';
		$codSeguimiento = !is_null($this->input->post("codSeguimiento")) ? $this->input->post("codSeguimiento") : '-1';
		$columnasSeguimiento = $this->Utilidades_model->columnCbz('seguimiento_tarea');
		$clases_estado = array('class'=>'form-control');
		$frmParam = array();
		$dataArr = array();
		$objParam = array(
			"codTarea" => $codTarea,
			"codSeguimiento" => $codSeguimiento
		);

		$data = $this->Panorama_riesgos_model->llamarSeguimientoTarea_data($objParam);
		$objDato = count($data) > 0 ? (array) $data[0] : array();
		$objDato = $codSeguimiento != '-1' ? $objDato : array();
		$resultado['objDatos'] = $objDato;
		for($d=0; $d<count($data); $d++){
			$dato = (array) $data[$d];
			$objDataStr = json_encode($dato);			
			$codigo = $dato['codSeguimiento'];
			$dato['editar'] = '<div class="class_edit" data-str="'.$objDataStr.'" onclick="javascript:gestionarSeguimientoTarea(\''.$codTarea.'\',\''.$codigo.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			//$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';

			$dataArr[] = $dato;
		}

		if($codSeguimiento != '-1'){
			$clases_estado['_SELECCIONAR_'] = isset($objDato['codEstado']) ? $objDato['codEstado'] : '-1';
		}

		$codPanorama = $codPanorama != '-1' ? $codPanorama : '';
		$codTarea = $codTarea != '-1' ? $codTarea : '';
		$tituloTarea = isset($data[0]['tituloTarea']) ? $data[0]['tituloTarea'] : '';
		$frmParam['attrDisabled'] = '';
		$frmParam['codPanorama_sg'] = $codPanorama;//isset($objDato['codPanorama']) ? $objDato['codPanorama'] : $codPanorama;
		$frmParam['codTarea_sg'] = $codTarea;//isset($objDato['codTarea']) ? $objDato['codTarea'] : $codTarea;
		$frmParam['titulo_sg'] = isset($objDato['tituloTarea']) ? $objDato['tituloTarea'] : $tituloTarea;
		$frmParam['codSeguimiento_sg'] = isset($objDato['codSeguimiento']) ? $objDato['codSeguimiento'] : '';
		$frmParam['estado_sg'] = $this->Utilidades_model->generarComboWhere('','public.estado', 'id_estado', 'nombre_estado', '2','Seleccione estado','id_estado IN(9,11,12)', true, $clases_estado);
		$frmParam['foto_sg'] = isset($objDato['foto']) ? $objDato['foto'] : '';
		$frmParam['observacion_sg'] = isset($objDato['observacion']) ? $objDato['observacion'] : '';
		
		$resultado['frm_seguimiento'] = $this->load->view('panorama_riesgos/panorama_tarea_seguimiento', $frmParam, true);
		//$result['tbl_seguimiento'] = $this->Utilidades_model->createTable('tablaSeguimiento', $columnasSeguimiento, $dataArr);
		$resultado['result'] = $dataArr;
		
		$ress = json_encode($resultado);	

		$this->output->set_content_type('application/json')->set_output($ress);

	}

	public function getTablaPanorama(){		

		$fecha_inicial = $this->input->post("fecha_inicial") == "" ? -1 : $this->input->post("fecha_inicial");
		$fecha_final = $this->input->post("fecha_final") == "" ? -1 : $this->input->post("fecha_final");
	    
        $data["tabla"] = $this->crearTabla($fecha_inicial,$fecha_final);       	
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	  
	public function guardarTareaPanorama(){
		//$this->Utilidades_model->validaSession();
		$file_element_name = 'foto_tr';
		$rutaParametro = "./asset/public/fileUpload/";
		$typeFile = '*';         

        $nameFile = $_FILES[$file_element_name]["name"];
        $nombreEncrypFile="";
        $ress = "";
   
      	if ($nameFile != "") {
          	$nombreEncrypFile = $this->Utilidades_model->UploadImage($rutaParametro,$file_element_name,$typeFile);   
       	} 

       	if ($nombreEncrypFile != false OR  $nameFile == "") {
			$paramObj = array(
					"codPanorama" => $this->input->post("codPanorama"),
					"codTarea" => $this->input->post("codTarea"),
					"titulo_tr" => $this->input->post("titulo_tr"),
					"tipoRiesgo_tr" => $this->input->post("tipoRiesgo_tr"),
					"tipoEjecucion_tr" => $this->input->post("tipoEjecucion_tr"),
					"fechaVence_tr" => $this->input->post("fechaVence_tr"),
					"estado_tr" => $this->input->post("estado_vl"),
					"observacion_tr" => $this->input->post("observacion_tr"),
					"mejora_tr" => $this->input->post("mejora_tr"),
					"probabilidad_tr" => $this->input->post("probabilidad_tr"),
					"severidad_tr" => $this->input->post("severidad_tr"),
					"exposicion_tr" => $this->input->post("exposicion_tr"),
					"proteccion_tr" => $this->input->post("proteccion_tr"),
					"puntaje_tr" => $this->input->post("puntaje_vl"),
					"riesgo_tr" => $this->input->post("codRiesgo"),
					"usuarioCrea" => $this->session->userdata('codigoUsuario'),
					"pathFile" => $rutaParametro.$nombreEncrypFile,
					"nameFile" => $nameFile,
					"dataSesion" => $this->Utilidades_model->getDataSesion()				
			);

			$result["result"] = $this->Panorama_riesgos_model->guardarTareaPanorama_data($paramObj);
			$result["tabla_tarea"] = $this->getTablaTareasPanorama($paramObj['codPanorama']);
        }else{
			$result["result"] = 'Se presentaron inconvenientes al guardar el archivo';
			$result["tabla_tarea"] = '';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function guardarSeguimientoTarea(){		
		  $this->Utilidades_model->validaSession();

		  $rutaParametro = "./asset/public/fileUpload/";
		  $ret = true;        
	      $files = $_FILES["foto_sg"]["name"];
	      $length_imagenes = count($files);	      
	      $cods_fil_delete = $this->input->post("codigos_delete");
	      $aux_array = array();
	     
	      $nombreEncrypImg = false;
	      $arrayFiles = array();
	      
	         if ($length_imagenes > 0) {

	           for ($i=0; $i < $length_imagenes; $i++) { 

	              $nombreArchivo = $_FILES["foto_sg"]["name"][$i];
	              $nombreTemporal = $_FILES["foto_sg"]["tmp_name"][$i];
	              $nombreEncript = rand(10,100000)."_".$nombreArchivo;
	              $rutaArchivo = $rutaParametro.$nombreEncript;
	              $ret = move_uploaded_file($nombreTemporal, $rutaArchivo);

	              if ($ret) {                              
	                $aux_array = array('nombre' => $nombreArchivo,
	                                   'nombre_encript' => $nombreEncript,
	                                   'ruta' => $rutaArchivo);
	                $arrayFiles[] = $aux_array;
	              }	                         
	           }             
	        }	       

	        $arrayDatos = array('datosSesion'     => $this->Utilidades_model->getDataSesion(),
	        					'cods_fil_delete' => $cods_fil_delete,
	        					'arrayFiles'      => json_encode($arrayFiles,true),								
	        					"codPanorama" => $this->input->post("codPanorama"),
								"codTarea" => $this->input->post("codTarea"),
								"estado_sg" => $this->input->post("estado_sg"),
								"observacion_sg" => $this->input->post("observacion_sg"),
								"fecha_sg" => $this->input->post("fecha_sg")								
							);        	          

	        $result = $this->Panorama_riesgos_model->guardarSeguimientoTarea($arrayDatos);

	        $retorno['result']  = $result; 

	        /*if ($datos["respuesta"] == "OK") {              
	          if ($cods_fil_delete != "[]") {
	            foreach (json_decode($cods_fil_delete) as  $value) {
	              $aux_ruta = $value->ruta;
	              if (file_exists($aux_ruta)) {
	                  @unlink($aux_ruta);
	              }              
	            }
	          }
	        }*/

		 $this->output->set_content_type('application/json')->set_output(json_encode($retorno));

	}

	public function getTablaTareasPanorama($codPanorama){
		$columnasTarea = $this->Utilidades_model->columnCbz('tarea_panorama');
		$dataArr = array();
		
		$objParam = array(
			"codPanorama" => trim($codPanorama),
			"codTarea" => -1
		);


		if ($codPanorama != "-1"){
			$data = $this->Panorama_riesgos_model->llamarTareaPanorama_data($objParam);
			
		}else{
			$data = array();
		}	


		for($d=0; $d<count($data); $d++){
						$dato = (array) $data[$d];
						$objDataStr = json_encode($dato);			
						$codigo = $dato['codTarea'];
						$dato['editar'] = '<div class="class_edit" data-str="'.$objDataStr.'" onclick="javascript:gestionarTareaPanorama(\''.$codPanorama.'\',\''.$codigo.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
						//$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';

						$dataArr[] = $dato;
					}

		$tablaTarea = $this->Utilidades_model->createTable('tablaTareas', $columnasTarea, $dataArr);

		return $tablaTarea;
	}

	public function guardarTipoRiesgo(){

		$descripcion = $this->input->post("tipor");
		$estado = 1;

		$parametros = array('dest' => $descripcion,
							'estado' => $estado);

		$return = $this->Panorama_riesgos_model->guardarTipoRiesgo($parametros);

		$clases_tipoRiesgo = array('class'=>'form-control');
		$clases_tipoRiesgo['_SELECCIONAR_'] = -1;


		$retorno["result"] = $return;
		$retorno["option"] = $this->Utilidades_model->generarComboWhere('','public.tipo_riesgo', 'id_tipo_riesgo', 'nombre_tipo_riesgo', '2','Seleccione tipo riesgo','', true, $clases_tipoRiesgo);

		$this->output->set_content_type('application/json')->set_output(json_encode($retorno));

	} 


  }
    
 ?>