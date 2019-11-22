<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Mobile extends CI_Controller{

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
        
        $this->load->view('Mobile',$datos);
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
		   
		//Valida y llena permisologia invitado
		$codUser = $this->session->userdata('codigoUsuario');
        if(!$codUser){
            $this->Utilidades_model->llenarSesionInvitado();
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
			$datos[$e]->permisos = '<div class="class_edit" onclick="javascript:permisosRol(\''.$codigo.'\',\''.$nombre.'\',\''.$descripcion.'\','.$estado.');"><center><img src="./asset/public/img/edit.png" class="btn_image"></center></div>';
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
		$codRol = !is_null($this->session->userdata('codigo_rol')) ? $this->session->userdata('codigo_rol') : '0' ;
		$objParam = array(
						"codPredio" => $codPredio,
						"codRol" => $codRol,
						"codModulo" => 2
						);
		//var_dum('INFO-PREDIO: ',$objParam);
		$resultado['result'] = $this->Home_model->traerInfoPredio_data($objParam);
		$resultado['param'] = $objParam;
		$ress = json_encode($resultado);	
		
        $this->output->set_content_type('application/json')->set_output($ress);
	}
 
}

?>