<?php   

  class Visita_tecnica extends CI_Controller{
  	
  	public function __construct() {
        parent::__construct(); 
        $this->load->model('Visita_tecnica_model');        
        $this->load->model('Utilidades_model');
        $this->load->library('excel');
  	}  

  	public function getVisitaTecnica(){
	    
	    $codigo_terreno = trim($this->input->post("codigo_predio"));
	    $codigo_predio_const = trim($this->input->post("codigo_predio_const"));
	    $codigo_visita = trim($this->input->post("codigo_visita"));	    
         	    
	    $dataPredio = $this->Visita_tecnica_model->getDatosPredio($codigo_terreno,$codigo_predio_const);
        $parametros["nombre_cuenta"] = "Municipio de Santiago de Cali";
        $parametros["nombreEdificacion"] = $dataPredio->nombre;
        $parametros["localizacion"] = $dataPredio->direccion;
        $parametros["codigo_visita_tec"] = $dataPredio->sec_vist;
        $clases = array();
        $parametros["optCalidadInmueble"] = $this->Utilidades_model->generarComboWhere('','public.calidad_inmueble', 'id_ci', 'nombre_ci', '2','Seleccione','estado_ci_fk = 1', true, $clases);
       	$parametros["optTipoVisita"] = $this->Utilidades_model->generarComboWhere('','public.tipo_visita', 'id_tv', 'nombre_tv', '2','Seleccione','estado_tv_fk = 1', true, $clases);
          		
  		$data["visitaTecView"] = $this->load->view('visita_tecnica/visita_tecnica',$parametros,TRUE);         
    	if ($codigo_visita != -1) {
    		$data["dataVisita"] = $this->getData($codigo_visita);
    		$data["tableObservacion"] =  $this->getTablaObservacionVisita($codigo_visita,-1);
    		$data["tableContrato"] =  $this->crearTablaVisitaContrato($codigo_visita,-1); 
    	}
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
  	}


  	public function guardarVisitaTec(){

		$this->Utilidades_model->validaSession();		

		$codigo_vt = $this->input->post("id_visita_tec");
		$atendido_por = $this->input->post("atendido_por_p");	
		$calidad_inmueble = $this->input->post("calidad_inmueble");			
		$objetivo_visita = $this->input->post("objetivo_visita");		
		$tipo_visita = $this->input->post("tipo_visita");						
		$codigo_file = $this->input->post("codigo_file");
		$codigo_terreno = trim($this->input->post("codigo_predio"));
		$fecha_inicio = $this->input->post("fecha_ini_vt");
		$suscriptor = $this->input->post("suscriptor");
		$medidor = $this->input->post("medidor");	
		$cod_predio_const = $this->input->post("cod_predio_const"); 	

		$file_element_name = 'file_visita';
        $typeFile = '*';          
        $rutaParametro = "./asset/public/fileUpload/"; 

        $nameImg = $_FILES["file_visita"]["name"];
        $nombreEncrypImg="";
        $ress = "";
   
      	if ($nameImg != "") {
          $nombreEncrypImg = $this->Utilidades_model->UploadImage($rutaParametro,$file_element_name,$typeFile);   
       	}

       	if ($nombreEncrypImg != false OR  $nameImg == ""){
			$objParam = array(
							"codigo_vt" => $codigo_vt,
							'atendido_por_p' => $atendido_por,							
							"calidad_inmueble" => $calidad_inmueble,														
							"usuario_crea" => $this->session->userdata('codigoUsuario'),
							'dataSesion' => $this->Utilidades_model->getDataSesion(),
							"codigo_terreno" => $codigo_terreno,
							"objetivo_visita" => $objetivo_visita,
							"tipo_visita" => $tipo_visita,							
							'codigo_file' => $codigo_file,
							'nameFile' => $nameImg,
							'ruta_file' => $rutaParametro.$nombreEncrypImg,
							'fecha_inicio' => $fecha_inicio,
							'suscriptor' => $suscriptor,
							'medidor' => $medidor,
							'cod_predio_const' => 	$cod_predio_const						
							);
			
			$resultado['result'] = $this->Visita_tecnica_model->guardarVisitaTecn($objParam);
			if ($tipo_visita == 5) {
				$resultado['tablaContrato'] = $this->crearTablaVisitaContrato($codigo_vt);
			}
						
			//$resultado['tabla'] = $this->crearTabla(-1,-1);
			
			$ress = json_encode($resultado);

			$rutaAnterior = $this->input->post("file_visita_ant");      

	         if (file_exists($rutaAnterior) && $nameImg != "") {
	            @unlink($rutaAnterior);
	         }	
		}

        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function llamarObservacionVisita(){
		//$this->Utilidades_model->validaSession();
		$codVisita = !is_null($this->input->post("codVisita")) ? $this->input->post("codVisita") : '-1';
		$codObservacion = !is_null($this->input->post("codObservacion")) ? $this->input->post("codObservacion") : '-1';
		$frmParam = array();
		
		$dataArr = array();
		$objParam = array(
			"codVisita" => $codVisita,
			"codObservacion" => $codObservacion
		);
		
		$data = $this->Visita_tecnica_model->llamarObservacionVisita_data($objParam);
		$objDato = count($data) > 0 ? (array) $data[0] : array();
		$objDato = $codObservacion != '-1' ? $objDato : array();

		$frmParam['attrDisabled'] = '';
		$frmParam['codVisita_ovt'] =  $codVisita != '-1' ? $codVisita : ( isset($objDato['codVisita']) ? $objDato['codVisita'] : '');
		$frmParam['codObservacion_ovt'] = isset($objDato['codObservacion']) ? $objDato['codObservacion'] : '';
		$frmParam['fechaVisita_ovt'] = isset($objDato['fechaVisita']) ? $objDato['fechaVisita'] : '';
		$frmParam['observacion_ovt'] = isset($objDato['observacion']) ? $objDato['observacion'] : '';
		$frmParam['fileDoc_ovt'] = isset($objDato['fileDoc']) ? $objDato['fileDoc'] : '';
		$frmParam['fileImg_ovt'] = isset($objDato['fileImg']) ? $objDato['fileImg'] : '';

		$resultado['frm_observacion'] = $this->load->view('visita_tecnica/observacion_vt', $frmParam, true);
		$resultado['frm_observacion_persona'] = $this->load->view('visita_tecnica/observacion_vt_persona', $frmParam, true);
		$resultado['status'] = 0;		
		$resultado['result'] = $dataArr;
		
		$ress = json_encode($resultado);
		$this->output->set_content_type('application/json')->set_output($ress);
	}

	public function guardarObservacionVisita(){		
		//$this->Utilidades_model->validaSession();
		$objPersonas = json_decode($this->input->post("persona"),true);
		$rutaParametro = "./asset/public/fileUpload/";
		$ret = true;        
		$filesDocs = $_FILES["fileDoc_ovt"]["name"];
		$filesImage = $_FILES["fileImg_ovt"]["name"];
		$length_docs = count($filesDocs);
		$length_imagenes = count($filesImage);	      
		//$cods_fil_delete = $this->input->post("codigos_delete");
		$nombreEncrypImg = false;
		$arrayFiles = array();
		$resultFile = array();
		$resultPerosona = array();		
		$arrayDatos = array(  
							'codVisita' => $this->input->post("codVisita"),
							'codObservacion' => $this->input->post("codObservacion"),
							'observacion' => $this->input->post("observacion_ovt"),
							'datosSesion' => $this->Utilidades_model->getDataSesion()						
						  );

		if ($length_imagenes > 0) {
			for ($i=0; $i < $length_imagenes; $i++) {
				$aux_array = array();
				$nombreArchivo = $_FILES["fileImg_ovt"]["name"][$i];
				$nombreTemporal = $_FILES["fileImg_ovt"]["tmp_name"][$i];
				$nombreEncript = rand(10,100000)."_".$nombreArchivo;
				$rutaArchivo = $rutaParametro.$nombreEncript;
				$ret = move_uploaded_file($nombreTemporal, $rutaArchivo);

				if ($ret) {                              
				  $aux_array = array(
									 'codObservacion' => -1,
									 'nombre' => $nombreArchivo,
									 //'nombre_encript' => $nombreEncript,
									 'ruta' => $rutaArchivo,
									 'tipo' => 1,
									 'datosSesion' => $this->Utilidades_model->getDataSesion());
				  $arrayFiles[] = $aux_array;
				}	                         
			}             
		}

		if ($length_docs > 0) {
			for ($i=0; $i < $length_docs; $i++) {
				$aux_array = array();
				$nombreArchivo = $_FILES["fileDoc_ovt"]["name"][$i];
				$nombreTemporal = $_FILES["fileDoc_ovt"]["tmp_name"][$i];
				$nombreEncript = rand(10,100000)."_".$nombreArchivo;
				$rutaArchivo = $rutaParametro.$nombreEncript;
				$ret = move_uploaded_file($nombreTemporal, $rutaArchivo);

				if ($ret) {                              
				  $aux_array = array(
									 'codObservacion' => -1,
									 'nombre' => $nombreArchivo,
									 //'nombre_encript' => $nombreEncript,
									 'ruta' => $rutaArchivo,
									 'tipo' => 2,
									 'datosSesion' => $this->Utilidades_model->getDataSesion());
				  $arrayFiles[] = $aux_array;
				}	                         
			}             
		}

		$result = $this->Visita_tecnica_model->guardarObservacionVisita_data($arrayDatos);
		$codObservacion = $result;
		for($k=0; $k<count($arrayFiles); $k++){
			$arrayFiles[$k]['codObservacion'] = $codObservacion;
			$arrFile = $arrayFiles[$k];
			//var_dump($arrFile);
			$resultFile[] = $this->Visita_tecnica_model->guardarObservacionVisitaFile_data($arrFile);
		}

		//echo "<pre>";var_dump($objPersonas);die();

		if($objPersonas != '' AND !is_null($objPersonas)){			

			for($p=0; $p<count($objPersonas); $p++){
				$persona = $objPersonas[$p];
				$dataBase64 = explode(',', $persona['firma_ovp']);
				$imagedata = base64_decode($dataBase64[1]);
				$filename = md5(date("dmYhisA"));			
				$file_ruta = './asset/public/fileUpload/'.$filename.'.png';
				file_put_contents($file_ruta,$imagedata);

				$arrayPesona = array(
					"codObservacion" => $codObservacion,
					"documento" => $persona['documento_ovp'],
					"nombre" => $persona['nombre_ovp'],
					"cargo" => $persona['cargo_ovp'],
					"correo" => $persona['correo_ovp'],
					"session" => $this->Utilidades_model->getDataSesion(),
					"firma" => $file_ruta
				);
				$resultPerosona[] = $this->Visita_tecnica_model->guardarObservacionVisitapersona_data($arrayPesona);
			}
		}
		

		$retorno['result']  = $result;
		$retorno['resultFile']  = $resultFile;
		$retorno['datos']  = $arrayDatos;
		$retorno['datosFile']  = $arrayFiles;
		$retorno['codObs']  = $codObservacion;
		$retorno['tablaObs']  = $this->getTablaObservacionVisita($arrayDatos['codVisita'], '-1');
		
	   	$this->output->set_content_type('application/json')->set_output(json_encode($retorno));

	}

	public function getTablaObservacionVisita($codVisita, $codObservacion){
		$columnas = $this->Utilidades_model->columnCbz('observacion_visita');
		$dataArr = array();
		$tabla = '';
		$objParam = array(
			"codVisita" => $codVisita,
			"codObservacion" => $codObservacion
		);
		
		$data = $this->Visita_tecnica_model->llamarObservacionVisita_data($objParam);
		
		for($d=0; $d<count($data); $d++){
			$dato = (array) $data[$d];
			$objDataStr = json_encode($dato);			
			$v_codVisita = $dato['codVisita'];
			$v_codObservacion = $dato['codObservacion'];
			$dato['editar'] = '<div class="class_edit" data-str="'.$objDataStr.'" onclick="javascript:gestionarObservacionVisita(\''.$v_codVisita.'\',\''.$v_codObservacion.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			//$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';
			$dataArr[] = $dato;
		}

		$tabla = $this->Utilidades_model->createTable('tablaObservacionVisita', $columnas, $dataArr);

		return $tabla;
	}

	public function crearTablaVisitaContrato($codigo_visita){

		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('contratos_visita');
		$datos =  $this->Visita_tecnica_model->getContratoVisita($codigo_visita);

		for($d=0; $d<count($datos); $d++){
			$dato = (array) $datos[$d];	
			$codigo = $dato["id_cv"];		
			$datos[$d]->eliminar = '<div onclick="javascript:eliminarContrato(\''.$codigo.'\',\''.$codigo_visita.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';
	
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_contrato_vista', $columnas, $datos);
		
		return $tabla;
	}

	public function getContratosVisitaView(){
	    
	    $codiigo_visita = $this->input->post("codigo_visita");
  	    
		$parametros["tablaContrato"] = $this->crearTablaVisitaContrato($codiigo_visita);
  		
  		$data["visitaTecView"] = $this->load->view('visita_tecnica/visita_tecnica_table',$parametros,TRUE);         
    	
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
  	}

  	public function SaveContratosVisita(){
	    
	    $codiigo_visita = $this->input->post("codigo_visita");
	    $suscriptor = $this->input->post("suscriptor");
	    $medidor = $this->input->post("medidor");	    

		$params = array('codigo_visita' => $codiigo_visita, 
					    'suscriptor' => $suscriptor,
					    'medidor' => $medidor,
					    'datasesion' => $this->Utilidades_model->getDataSesion());
  	    
		$data["result"] = $this->Visita_tecnica_model->saveContratoVisita($params); 

		$data["tablaContratos"] = $this->crearTablaVisitaContrato($codiigo_visita); 		
  		
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
  	}

  	public function getData($codigo_visita){
		$this->Utilidades_model->validaSession();		
		$data = $this->Visita_tecnica_model->getData($codigo_visita);
		
		return $data;
	}

	public function getDataFechas($fecha_inicial,$fecha_final){
		$this->Utilidades_model->validaSession();		
		$data = $this->Visita_tecnica_model->getDataFecha($fecha_inicial,$fecha_final);
		
		return $data;
	}

	public function crearTablaVisitas($p_fecha_inicial,$p_fecha_final,$codigo_visita){
		$this->Utilidades_model->validaSession();
		$columnas = $this->Utilidades_model->columnCbz('visita_tecnica');
		if ($p_fecha_inicial == -1) {
			$datos = $this->getData($codigo_visita);
		}else{
			$datos = $this->getDataFechas($p_fecha_inicial,$p_fecha_final);
		}

		//$columnasContratos = $this->Utilidades_model->columnCbz('contratos_visita');
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){			
									
			//$tablaContratos = $this->Utilidades_model->createTable('tabla_contrato_vista', $columnasContratos, $datosC);
			$codigo_vista = $datos[$e]->id_vt;				
			$codigo_terreno = $datos[$e]->terreno_vt_fk;			
			$predial_edificacion_const =  $datos[$e]->predial_edificacion_const;
			$datos[$e]->editar = '<div class="stilo_acciones"><div class="class_edit panorama-key-css_3" onclick="javascript:verVisitaReadOnly(\''.$codigo_vista.'\',\''.$codigo_terreno.'\',\''.$predial_edificacion_const.'\');"><center><img src="./asset/public/img/buscar.png" style="width: 21px;margin-top: 2px;cursor: pointer;"></center></div><div class="class_edit panorama-key-css_2" onclick="javascript:editarVisita(\''.$codigo_vista.'\',\''.$codigo_terreno.'\',\''.$predial_edificacion_const.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div></div>';
			//$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_visita', $columnas, $datos);
		
		return $tabla;
	}

	public function getionarVisitasTecnicas(){
		
		$fecha_inicial = -1;
		$fecha_final = -1;
		$codigo_visita = -1;		
        
        $parametros["tablaVisita"] = $this->crearTablaVisitas($fecha_inicial,$fecha_final,$codigo_visita);
       	$data["visitaViewTable"] = $this->load->view('visita_tecnica/visita_tecnica_table',$parametros,TRUE);         
    	

  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function getTablaVisita(){
		$fecha_inicial = $this->input->post("fecha_inicial") == "" ? -1 : $this->input->post("fecha_inicial");
		$fecha_final = $this->input->post("fecha_final") == "" ? -1 : $this->input->post("fecha_final");
		$codigo_visita = -1;		
        
        $data["tabla"] = $this->crearTablaVisitas($fecha_inicial,$fecha_final,$codigo_visita);       	
  		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function eliminarContrato(){
		$this->Utilidades_model->validaSession();
		$codigoContrato = $this->input->post("codigo_contrato");
		$codigoVisita = $this->input->post("codigo_visita");		

		$objParam = array(
						"tipo" => "delete",
						"tabla" => "public.contrato_visita",
						"campos" => "",
						"datos"  => "", 
						"condicional" => "id_cv = ".$codigoContrato,
						'dataSesion' => $this->Utilidades_model->getDataSesion()
						);		
		
		$resultado['result'] = $this->Visita_tecnica_model->ejecutarSentencia($objParam);
		$resultado['tableContrato'] = $this->crearTablaVisitaContrato($codigoVisita);
		$ress = json_encode($resultado);
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function editExcel(){		

		  $codigo_visita = $this->input->post("codigo_visita_excel");

        // Creamos un objeto PHPExcel          
          $objPHPExcel = new PHPExcel();
          
          $objReader = PHPExcel_IOFactory::createReader('Excel2007');
          $objPHPExcel = $objReader->load('./asset/public/fileDowload/formato_visitas.xlsx');
          // Indicamos que se pare en la hoja uno del libro
          $objPHPExcel->setActiveSheetIndex(0); 
         
          $this->Utilidades_model->validaSession();		
		  $record = $this->Visita_tecnica_model->getDataExcel($codigo_visita);          
          
          //Modificamos los valoresde las celdas A2, B2 Y C2
          $objPHPExcel->getActiveSheet()->SetCellValue('G7',  $record->calidad_in_pu);
          $objPHPExcel->getActiveSheet()->SetCellValue('K7',  $record->calidad_in_fiscal);
          $objPHPExcel->getActiveSheet()->SetCellValue('D8', $record->objetivo);
          $objPHPExcel->getActiveSheet()->SetCellValue('D12', $record->fecha_inicio);
          $objPHPExcel->getActiveSheet()->SetCellValue('H12', $record->fecha_fin);
          $objPHPExcel->getActiveSheet()->SetCellValue('C14', $record->direccion);
          $objPHPExcel->getActiveSheet()->SetCellValue('D15', $record->barrio);
          $objPHPExcel->getActiveSheet()->SetCellValue('K15', $record->comuna);
          $objPHPExcel->getActiveSheet()->SetCellValue('A17', $record->tip_vis_1);
          $objPHPExcel->getActiveSheet()->SetCellValue('A18', $record->tip_vis_2);
          $objPHPExcel->getActiveSheet()->SetCellValue('A19', $record->tip_vis_3);
          $objPHPExcel->getActiveSheet()->SetCellValue('A20', $record->tip_vis_4);
          $objPHPExcel->getActiveSheet()->SetCellValue('A21', $record->tip_vis_5);
          $objPHPExcel->getActiveSheet()->SetCellValue('A22', $record->tip_vis_6);
          $objPHPExcel->getActiveSheet()->SetCellValue('A23', $record->tip_vis_7);
          $objPHPExcel->getActiveSheet()->SetCellValue('A24', $record->tip_vis_8);


          // Redirect output to a client’s web browser (Excel2007)
		    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');			
		    header('Content-Disposition: attachment;filename="01simple.xlsx"');
		    header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
		    header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
          
          
          //Guardamos los cambios
          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');          
          $objWriter->save('php://output');
          //$objWriter->save("./asset/public/fileDowload/formato_visita3.xlsx");

          //$resultado = "OK";
          //$this->output->set_content_type('application/json')->set_output(json_encode($resultado));
          

    }     

    public function createFormatoVisitasPdf(){

    	$this->Utilidades_model->validaSession();
    	$codigo_visita = $this->input->post("codigo_visita_pdf");	

    	$nom_plantilla_aux = "formato";	
		$nom_plantilla = $nom_plantilla_aux.'_'.date('Y-m-d').'.pdf';
		$nom_plantilla = str_replace("-","",$nom_plantilla);
	    $record["data"] = $this->Visita_tecnica_model->getDataExcel($codigo_visita);
	    $record["datatr"] = $this->createTrObservacionesVisitas($codigo_visita); 	   

    	$resultPdf = $this->Utilidades_model->crearPdf('pdf/formato_visitas','D',$nom_plantilla,$record);
    }
    
    public function createTrObservacionesVisitas($codVisita){

    	$objParam = array(
			"codVisita" => $codVisita,
			"codObservacion" => -1
		);
		
		$data = $this->Visita_tecnica_model->llamarObservacionVisita_data($objParam);	
		//echo "<pre>"; var_dump($data);	
		$auxTrObservaciones = "";		
		$auxImages = "";
		$nomFileImg = "";
		$lengthImg = 0;
		$contadorNonFile = 0; 
	    $lengtData = count($data);	
	    $auxTrPersona = "";
	    $arrayImagenes = array();	
	    $arrayPersonas = array();  

	   if ($lengtData > 0) {
		for ($i=0; $i < $lengtData ; $i++) { 

			$auxTrObservaciones .= '<tr>
        								<td class="aling_lef" style="width: 100%;" colspan="5">'.$data[$i]["observacion"].'</td>                     
      				  				</tr>';      		

      	    for ($j=0; $j < count($data[$i]["fileDoc"]) ; $j++) {

      	    	$contadorNonFile++;

      	    	$recordfileDoc = $data[$i]["fileDoc"][$j];

      	    	$nomFileImg .= '<tr>
      	    						<td style="width: 15%;" colspan="1">'.$contadorNonFile.'</td><td class="aling_lef" style="width: 85%;"  colspan="4">'.$recordfileDoc["nombre_file"].'</td>                     
      				  		   </tr>';
      	    }      	    
      	    
      	     for ($j=0; $j <  count($data[$i]["fileImg"]) ; $j++) {

      	     	$recordfileImg = $data[$i]["fileImg"][$j];

      	     	$contadorNonFile++;

      	     	/*if ($j == 0) {
      	    		$contadorNonFile = $contadorNonFile+1;
      	    	}else{
      	    		$contadorNonFile = $contadorNonFile+$j;
      	    	}*/
      	    	
      	    	$arrayImagenes[] = $recordfileImg;

      	    	$nomFileImg .= '<tr>
      	    						<td style="width: 15%;" colspan="1">'.$contadorNonFile.'</td><td style="width: 85%;" class="aling_lef" colspan="4">'.$recordfileImg["nombre_file"].'</td>                     
      				  		   </tr>';      		   
      	    }      	        	 		 				

			for ($j=0; $j < count($data[$i]["persona"]) ; $j++) {		    	
		    	$arrayPersonas[] = $data[$i]["persona"][$j];	      	    	
		    }   
		  		
		}

		$auxDataPersona = "";

		for ($j=0; $j < count($arrayPersonas) ; $j++) {

		    	$recordPersona = $arrayPersonas[$j];		    	
		    	
		    	$auxDataPersona = '<img src="'.$recordPersona["firma_ovp"].'" class="img_file_base64"><br>'.$recordPersona["nombre_ovp"].' '.$recordPersona["documento_ovp"].'<br>'.$recordPersona["cargo_ovp"];

		    	if($j%2 == 0){
		    		$auxTrPersona .= '<tr>';
		    		$auxTrPersona .= '<td style="width:40%;">'.$auxDataPersona.'</td>';

		    		if ($j+1 == count($arrayPersonas)) {
		    			$auxTrPersona .= '<td style="width:20%;"></td> <td style="width:40%;"></td>';
		    			$auxTrPersona .= '</tr>';
		    		}

		    	}else{
		    		$auxTrPersona .= '<td style="width:20%;"></td> <td style="width:40%;">'.$auxDataPersona.'</td>';
		    		$auxTrPersona .= '</tr>';
		    	}
		      	    	
		} 

		$auxDataImg = "";

		for ($j=0; $j < count($arrayImagenes) ; $j++) {

		    	$recordImg = $arrayImagenes[$j];		    	
		    	
		    	$auxDataImg = '<img class="img_file" src="'.$recordImg["ruta_file"].'">';

		    	if($j%2 == 0){
		    		$auxImages .= '<tr>';
		    		$auxImages .= '<td style="width:50%;">'.$auxDataImg.'</td>';

		    		if ($j+1 == count($arrayImagenes)) {
		    			$auxImages .= '<td style="width:50%;"></td>';
		    			$auxImages .= '</tr>';
		    		}

		    	}else{
		    		$auxImages .= '<td style="width:50%;">'.$auxDataImg.'</td>';
		    		$auxImages .= '</tr>';
		    	}
		      	    	
		}     

	}else{

		    $auxTrObservaciones = "";
			$nomFileImg = "";
			$auxImages = '<tr><td style="width: 50%;"><img class="img_file" src=""></td><td style="width: 50%;"><img class="img_file" src=""></td></tr>';
			$auxTrPersona = "";
	}	

	$retorno["observacion"] = $auxTrObservaciones;
	$retorno["nombre_files"] = $nomFileImg;
	$retorno["images"] = $auxImages;
	$retorno["personas"] = $auxTrPersona;
	//echo "<pre>".htmlentities(print_r($auxImages, true))."</pre>"; die();		
	return $retorno;

    } 	 		


  }

 ?>


