<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller{

	public function __construct() {
		parent::__construct();		 
		$this->load->model('Home_model');		 
       	$this->load->model('Utilidades_model');
       	$this->load->model('Rol_model');
       	$this->load->model('Modulo_model');
       	$this->load->model('Login_model');
       	$this->load->model('Map_arcgis_model');
       	$this->load->model('Tabla_model');
       	$this->load->model('Campo_model');  
       	$this->load->model('Tipo_amoblamiento_model');     	
	}
	
	public function index() {
		$datos = $this->dataIndex();		
        
        $this->load->view('Home',$datos);
	}

	function dataIndex(){
		$data = array();
		$clases = array();
		$clases_estado = array('_SELECCIONAR_' => '1');
       	$rol["optEstado"] = $this->Utilidades_model->generarComboWhere('','public.estado', 'id_estado', 'nombre_estado', '2','','id_estado IN(1,2,6)', true, $clases_estado);
       	$rol["tablaRol"] = $this->crearTablaRol();
       	$data["rolTableView"] = $this->load->view('rol/rol_table',$rol,TRUE);
       	$data["rolView"] = $this->load->view('rol/rol',$rol,TRUE);
       	$modulo["tablaModulo"] = $this->crearTablaModulo();
       	$data["moduloTableView"] = $this->load->view('modulo/modulo_table',$modulo,TRUE);
       	$data["moduloView"] = $this->load->view('modulo/modulo','',TRUE);
       	
       	$registro["optdependencia"] = $this->Utilidades_model->generarComboWhere('','public.dependencia', 'id_depen', 'nombre_depen', '2','Seleccione','id_depen <= 999999', true, $clases); 
       	$registro["optestado"] = $rol["optEstado"];
       	$registro["optrol"] = $this->Utilidades_model->generarComboWhere('','public.rol', 'id_rol_pk', 'nombre_rol', '2','Seleccione','estado_rol_fk = 1', true, $clases); 
       	$data["RegistroView"] = $this->load->view('login/Registrarse',$registro,TRUE); 

       	$user["tablaUsuario"] = $this->crearTablaUsuario();
       	$data["usuarioTableView"] = $this->load->view('login/usuario_table',$user,TRUE);     	
        $data["iniciarSessionView"] = $this->load->view('login/Inicio_sesion','',TRUE);
      
		$tabla["optionTabla"] = $this->getOptionSelTabla();
        $tabla["tabla"] = $this->crearTableTabla();
        $data["TableView"] = $this->load->view('tabla/tabla',$tabla,TRUE); 
        $data["regTablas"] = $this->Tabla_model->getDatosTablas();         
        $campo["tablaCampo"] = $this->crearTableCampo();
        $data["campoView"] = $this->load->view('campo/Campo',$campo,TRUE);

        $tablaTa["optEstado"] = $rol["optEstado"];
        $tablaTa["tablaTa"] = $this->crearTablaTa();
        $data["taTableView"] = $this->load->view('tipo_amoblamiento/tipo_amoblamiento_table',$tablaTa,TRUE);
		$data["taView"] = $this->load->view('tipo_amoblamiento/tipo_amoblamiento','',TRUE);
		$data["numeroSesion"] = $this->Utilidades_model->getParametro(1);
		$data["inicioSession"] = 'N';
		$data["urlMapa"] = $this->Utilidades_model->getParametro(8);
        
		//Valida y llena permisologia invitado
		$codUser = $this->session->userdata('codigoUsuario');
		if(!$codUser){
			$this->Utilidades_model->llenarSesionInvitado();
			$data["urlMapa"] = $this->Utilidades_model->getParametro(9);
        }

		return $data;
	}

	public function dataIndex2(){
		$data = array();
		$clases = array();
		$clases_estado = array('_SELECCIONAR_' => '1');
       	$rol["optEstado"] = $this->Utilidades_model->generarComboWhere('','public.estado', 'id_estado', 'nombre_estado', '2','','id_estado IN(1,2,6)', true, $clases_estado);
		$registro["optdependencia"] = $this->Utilidades_model->generarComboWhere('','public.dependencia', 'id_depen', 'nombre_depen', '2','Seleccione','id_depen <= 999999', true, $clases); 
       	$registro["optestado"] = $rol["optEstado"];
       	$registro["optrol"] = $this->Utilidades_model->generarComboWhere('','public.rol', 'id_rol_pk', 'nombre_rol', '2','Seleccione','estado_rol_fk = 1', true, $clases); 
       	$data["RegistroView"] = $this->load->view('login/Registrarse',$registro,TRUE); 

       	$user["tablaUsuario"] = $this->crearTablaUsuario();
       	$data["usuarioTableView"] = $this->load->view('login/usuario_table',$user,TRUE);     	

       	return $data;
	}

	public function crearTablaRol(){		
		$columnas = $this->Utilidades_model->columnCbz('rol');
		$datos = $this->getRol();
		
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){
			$codigo = $datos[$e]->id_rol_pk;
			$nombre = $datos[$e]->nombre_rol;
			$descripcion = $datos[$e]->descripcion_rol;
			$estado = $datos[$e]->estado_rol_fk; 
			$datos[$e]->editar = '<div class="class_edit" onclick="javascript:editRol(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\','.$estado.');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			$datos[$e]->permisos = '<div class="class_edit" onclick="javascript:permisosRol(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\','.$estado.');"><center><img src="./asset/public/img/check.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_rol', $columnas, $datos);
		
		return $tabla;
	}

	public function getRol(){		
		$objParam = array();
		$data = $this->Rol_model->getDataRol($objParam);
		
		return $data;
	}

	public function crearTablaModulo(){		
		$columnas = $this->Utilidades_model->columnCbz('modulo');
		$datos = $this->getModulo();
		
		//adicionar editar y eliminar
		for($e=0; $e<count($datos); $e++){
			$codigo = $datos[$e]->id_mod;
			$nombre = $datos[$e]->nombre_mod;
			$descripcion = $datos[$e]->descripcion_mod;			
			$datos[$e]->editar = '<div class="class_edit" onclick="javascript:editModulo(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
			$datos[$e]->eliminar = '<div onclick="javascript:eliminarReigistro(\''.$codigo.'\',\''.$nombre.'\');"><center><img src="./asset/public/img/delete.png" class="btn_image"></center></div>';
		}
		
		$tabla = $this->Utilidades_model->createTable('tabla_modulo', $columnas, $datos);
		
		return $tabla;
	}

	public function getModulo(){		
		$objParam = array();
		$data = $this->Modulo_model->getData($objParam);
		
		return $data;
	}

	public function crearTablaUsuario(){
		
        $columnas = $this->Utilidades_model->columnCbz('usuario');
        $datos =   $this->Login_model->getDatosUsuaro(-1);

        //var_dump($datos[0]["id_user_pk"]);             
        
        //adicionar editar y eliminar
       for($e=0; $e < count($datos); $e++){
          //$datos = $datos[$e]; 

          $codigo = $datos[$e]["id_user_pk"];
          $identificacion = $datos[$e]["identificacion_user"];
          $nombre1 = $datos[$e]["primer_nombre_user"];
          $nombre2 = $datos[$e]["segundo_nombre_user"];
          $apellido1 = $datos[$e]["primer_apellido_user"];
          $apellido2 = $datos[$e]["segundo_apellido_user"];
          $correo = $datos[$e]["correo_user"];          
          $estado = $datos[$e]["estado_user_fk"];
          $rol = $datos[$e]["rol_user_fk"]; 
          $nombre = $datos[$e]["nombre_usuario"];
          $dependencia = $datos[$e]["dependencia_user_fk"];           
          $datos[$e]["editar"] = '<div class="class_edit" onclick="javascript:editarReigistro(\''.$codigo.'\',\''.$identificacion.'\',\''.$nombre1.'\',\''.$nombre2.'\',\''.$apellido1.'\',\''.$apellido2.'\',\''.$correo.'\','.$estado.','.$rol.','.$dependencia.');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
          
        }
        
        $tabla = $this->Utilidades_model->createTable('tabla_usuario', $columnas, $datos);
        
        return $tabla;
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

	public function crearTableTabla(){		
		$columnas = $this->Utilidades_model->columnCbz('tabla');
		$datos = $this->Tabla_model->getDatosTablas();
		
		//adicionar editar y eliminar
		/*for($e=0; $e<count($datos); $e++){			
			$nombre = $datos[$e]->tablename;			
			$datos[$e]->eliminar = '<div class="class_edit" onclick="javascript:eliminarTabla(\''.$nombre.'\');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
		}*/
		
		$tabla = $this->Utilidades_model->createTable('tabla_tabla', $columnas, $datos);
		
		return $tabla;
	}

	public function getOptionSelTabla(){		

        $data = $this->Tabla_model->getData();
        $cadenaLista = '';
        for($p=0; $p < count($data); $p++){
            $dato = (array) $data[$p];
            $nombre = $dato['tablename'];
            $cadenaLista .= '<option  value="'.$nombre.'" >'.$nombre.'</option>';
        }       

        return $cadenaLista;
    }

    public function crearTableCampo(){
    	
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

	public function crearTablaTa(){
		$columnas = $this->Utilidades_model->columnCbz('tipo_amoblamiento');
		$datos = $this->getDatosTa();
		
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
	
	public function getDatosTa(){
		$objParam = array();
		$data = $this->Tipo_amoblamiento_model ->getData($objParam);
		
		return $data;
	}

	public function getDataGlobal(){
		$datos = $this->dataIndex2();//$this->dataIndex();
		$this->output->set_content_type('application/json')->set_output(json_encode($datos));
	}

	public function traerInfoPredio(){
		//$this->Utilidades_model->validaSession();
		$codPredio = $this->input->post("codPredio");
		$codPredioConst = !is_null($this->input->post("codPredioConst")) || $this->input->post("codPredioConst") != '' ? $this->input->post("codPredioConst") : '-1' ;
		$codRol = !is_null($this->session->userdata('codigo_rol')) ? $this->session->userdata('codigo_rol') : '0' ;
		$datos = array();
		$objParam = array(
						"codPredio" => $codPredio,
						"codRol" => $codRol,
						"codModulo" => 2,
						"codconstruccion" => $codPredioConst
						);
		//var_dum('INFO-PREDIO: ',$objParam);
		$resultado['result'] = $this->Home_model->traerInfoPredio_data($objParam);
		$resultado['formulario'] = $this->load->view('info_predio/frm_info_predio', $datos, true);
		$resultado['param'] = $objParam;
		$ress = json_encode($resultado);
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}
	
	public function getFrmReporteTerreno(){
		//$this->Utilidades_model->validaSession();
		$objParam = array();
		$clases = array();
		$objParam['attrDisabled'] = '';
		$objParam['ltBarrio'] = $this->Utilidades_model->generarComboWhere('','public.barrios', 'id_barrio', 'barrio', '2',' ','id_barrio IS NOT NULL', true, $clases);
		$objParam['ltComuna'] = $this->Utilidades_model->generarComboWhere('','public.comunas', 'comuna::numeric', 'nombre', 'codigo',' ','', true, $clases);
		$objParam['ltTipoBien'] = $this->Utilidades_model->generarComboWhere('','public.tipo_bien', 'id_tb', 'nombre_tb', '2',' ','', true, $clases);
		$objParam['ltTipoUso'] = $this->Utilidades_model->generarComboWhere('','public.uso_predio', 'id_tu', 'nombre_tu', '2',' ','', true, $clases);
		//$objParam['ltUser'] = $this->Utilidades_model->generarComboWhere('','public.user', 'id_user_pk', "COALESCE(primer_nombre_user, '') ||' '|| COALESCE(primer_apellido_user,'')", '2',' ','', true, $clases);
		$objParam['ltCalidad'] = $this->Utilidades_model->generarComboWhere('','public.calidad_bien', 'id_cb', 'nombre_cb', '2',' ','', true, $clases);
		
		$resultado['form_report'] = $this->load->view('reportes/reporte_terreno', $objParam, true);
		//$resultado['result'] = $this->Home_model->getReporteTerreno_data($objParam);
		$resultado['param'] = $objParam;
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function getReporteTerreno(){
		//$this->Utilidades_model->validaSession();
		$objParam = array(
						"predio" => $this->input->post("predio"),
						"usuario" => $this->input->post("usuario"),
						"fechaInicio" => $this->input->post("fechaInicio"),
						"fechFin" => $this->input->post("fechFin"),
						"barrio" => $this->input->post("barrio"),
						"comuna" => $this->input->post("comuna"),
						"tipoBien" => $this->input->post("tipoBien"),
						"tipoUso" => $this->input->post("tipoUso"),
						"areaCesion" => $this->input->post("areaCesion"),
						"calidad" => $this->input->post("tipoUso")
					);
		//var_dum('INFO-PREDIO: ',$objParam);
		$resultado['result'] = $this->Home_model->getReporteTerreno_data($objParam);
		$resultado['param'] = $objParam;
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function generaFichaTecnica(){
		//$this->Utilidades_model->validaSession();
		$codPredio = $this->input->post("codPredio");
		$codPredioConst = !is_null($this->input->post("codPredioConst")) || $this->input->post("codPredioConst") != '' ? $this->input->post("codPredioConst") : '-1' ;
		$llavesInfo = !is_null($this->input->post("llavesInfo")) ? $this->input->post("llavesInfo") : array();
		$codRol = !is_null($this->session->userdata('codigo_rol')) ? $this->session->userdata('codigo_rol') : '0' ;
		$datos = array();
		$objParam = array(
						"codPredio" => $codPredio,
						"codRol" => $codRol,
						"codModulo" => 2,
						"codconstruccion" => $codPredioConst
						);
		
		$resultado['result'] = $this->Home_model->traerInfoPredio_data($objParam);
		$datosArr = count($resultado['result']) > 0 ? (array) $resultado['result'][0] : array();
		
		$resultado['datosPredio'] = $this->generarTablasPdf($llavesInfo, $datosArr);
		$resultado['param'] = $objParam;

		$ress = json_encode($resultado);
        $this->output->set_content_type('application/json')->set_output($ress);
	}

	public function printFichaTecnica(){
		//$this->Utilidades_model->validaSession();
		$datosTabla = $this->input->post("datosTabla");
		$codPredio = $this->input->post("codPredio");
		$objParam['datosPredio'] = $datosTabla;

		$nom_plantilla = 'FT_'.$codPredio.'.pdf';
		$nom_plantilla = str_replace("-","",$nom_plantilla);
		$resultPdf = $this->Utilidades_model->crearPdf('pdf/info_predio', 'D', $nom_plantilla, $objParam);
	}

	public function generarTablasPdf($llavesInfo, $objData){
		$contadorGrupos = 0;
		$vTabContetnt = '';

		foreach($llavesInfo as $grupoKey => $valor){
			$contadorGrupos++;
			$textoTab = $llavesInfo[$grupoKey]['texto'];
			$llavesTab = $llavesInfo[$grupoKey]['datos'];
			$tablaTab = $this->contstruirTablaInfo('tabla_rep_'.$grupoKey, $llavesTab, $objData);
			//$vActive = $contadorGrupos == 1 ? 'active' : '';
			$vTab = '<br><h3 class="fontmenu-vd">  '.$textoTab.'  </h3><br>';
			//$vTabContetnt = '<div class="tab-pane text-center gallery content-info-predio '+$vActive+'" id="'.$grupoKey.'"> </div>';
			
			$vTabContetnt .= $vTab;
			$vTabContetnt .= $tablaTab;
		}

		return $vTabContetnt;
	}

	public function contstruirTablaInfo($idTabla, $llavesObj, $objData){
		$table = '<table width="100%" style="width:100%" class="table table-striped table-bordered table-hover tabla-reporte-info" id="'.$idTabla.'" cellspacing="0"> ';
		$thead = '<thead> <tr><td style="width:30%">Campo</td><td style="width:70%">Valor</td></tr> </thead>';
		$tbody = '<tbody> ';
		$datosObj = $objData;
		$arrUndefined = array('undefined', null, 'null');
		$registrosPintados = 0;
	
		foreach($llavesObj as $llave => $valor){
			$valorCampo =  isset($datosObj[$llave]) ? $datosObj[$llave] : '';
			$position = array_search($valorCampo, $arrUndefined);
			if($valorCampo != '' && $position == 0){
				$trBody = '<tr><td class="llave_info_td">'.$llavesObj[$llave].'</td><td class="valor_info_td">'.$valorCampo.'</td></tr>';
				$tbody .= $trBody;
				$registrosPintados++;
			}
		}

		if($registrosPintados == 0){
			$tbody .= '<tr><td class="llave_noinfo_td" colspan="2">No hay registros</td></tr>';
		}
		
		$tbody .= ' </tbody>';
		$table .= $thead;
		$table .= $tbody;
		$table .= ' </table>';
	
		return $table;
	}

	public function guardarAudiDoc(){
		$objParam = array(
						"documento" => $this->input->post("documento"),
						"tipoDoc" => $this->input->post("tipoDoc"),
						"dataSesion" => $this->Utilidades_model->getDataSesion()
		);

		$resultado['result'] = $this->Home_model->guardarAudiDoc_data($objParam);
		
		$ress = json_encode($resultado);
		$this->output->set_content_type('application/json')->set_output($ress);
	}
 
}

?>