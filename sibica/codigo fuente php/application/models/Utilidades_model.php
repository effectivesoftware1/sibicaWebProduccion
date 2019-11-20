    <?php 

  defined('BASEPATH') OR exit('No direct script access allowed');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;   
  require FCPATH.'application/html2pdf/vendor/autoload.php'; 
  require 'vendor/autoload.php'; 

  use Spipu\Html2Pdf\Html2Pdf;
  use Spipu\Html2Pdf\Exception\Html2PdfException;
  use Spipu\Html2Pdf\Exception\ExceptionFormatter; 

  class Utilidades_model extends CI_Model{
    
     public function __construct() {
        parent::__construct();
        //$this->load->model('Inicio_model');
     }
    
     public function encrypt($str, $key){
           $block = mcrypt_get_block_size('rijndael_128', 'ecb');
           $pad = $block - (strlen($str) % $block);
           $str .= str_repeat(chr($pad), $pad);
           return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
     }

      public function decrypt($str, $key){ 
           $str = base64_decode($str);
           $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB);
           $block = mcrypt_get_block_size('rijndael_128', 'ecb');
           $pad = ord($str[($len = strlen($str)) - 1]);
           $len = strlen($str);
           $pad = ord($str[$len-1]);
           return substr($str, 0, strlen($str) - $pad);
      }
   
    
    public function createTable($idTable, $columnTable, $aux_data){
        $vTable = '<table width="100%" class="table table-striped table-bordered display cell-border" id="'.$idTable.'" cellspacing="0">';
        $vThead = '<thead><tr>';
        $vTbody = '<tbody>';

        for($z=0; $z<count($columnTable); $z++){
            $atributos_head = isset($columnTable[$z]['attribs_head']) ? $columnTable[$z]['attribs_head'] : '';
            $vThead .= '<th '.$atributos_head.'>'.$columnTable[$z]['label'].'</th>';
        }

        $vThead .= '</tr></thead>';

        $aux_contador = 1; 

        $data = is_null($aux_data) ? [] :  $aux_data; 
  
        for($y=0; $y<count($data); $y++){
            $vTbody .= '<tr>';            

            for($x=0; $x<count($columnTable); $x++){
                $labelTd = '';                
                $atributos = isset($columnTable[$x]['attribs']) ? $columnTable[$x]['attribs'] : '';                
                if(gettype($data[$y]) == 'array'){
                    //$vTbody .= '<td tabindex="'.$aux_contador.'" '.$atributos.'>'.$data[$y][$columnTable[$x]['column']].'</td>';
                    $labelTd = $data[$y][$columnTable[$x]['column']];
                }else{
                    //$vTbody .= '<td tabindex="'.$aux_contador.'" '.$atributos.'>'.$data[$y]->$columnTable[$x]['column'].'</td>';
                    $auxData = (array) $data[$y];
                    $labelTd = $auxData[$columnTable[$x]['column']];
                }

                if(isset($columnTable[$x]['format'])){
                    $formatCampTd = $this->formatCampTable($columnTable[$x]['format'], $labelTd);
                    $labelTd = $formatCampTd['label'];
                    $atributos .= $formatCampTd['attr'];
                }


                $vTbody .= '<td tabindex="'.$aux_contador.'" '.$atributos.'>'.$labelTd.'</td>';
                $aux_contador = $aux_contador+1;                
            }
            $vTbody .= '</tr>';
        }

         
        $vTbody .= '</tbody>';
        

        $vTable .= $vThead;
        $vTable .= $vTbody;
        $vTable .= '</table>';

        return $vTable;

    }
      
    //Funcion para declarar las cabeceras(COLUMNAS) de una tabla
    public function columnCbz($cbz){
        $cabecera = array(
                        'usuario' => array(                                    
                                    //array('column'=>'identificacion_user', 'label'=>'Identificaci&oacute;n'),
                                    array('column'=>'nombre_usuario', 'label'=>'Nombre'),
                                    array('column'=>'correo_user', 'label'=>'Correo'),                                   
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),                                   
                                    array('column'=>'nombre_dependencia', 'label'=>'Dependencia'), 
                                    array('column'=>'nombre_rol', 'label'=>'Rol'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="usuarios-key-css_2"', 'attribs_head'=>'class="usuarios-key-css_2"')                                    
                                ),
                        'rol' => array(                                   
                                    array('column'=>'nombre_rol', 'label'=>'Nombre'), 
                                    array('column'=>'descripcion_rol', 'label'=>'Descripci&oacute;n'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="roles-key-css_2"', 'attribs_head'=>'class="roles-key-css_2 center_th"'),
                                    array('column'=>'permisos', 'label'=>'Permisos', 'attribs'=>'class="class_permisos roles-key-css_2"', 'attribs_head'=>'class="class_permisos center_th roles-key-css_2"')
                                ),
                        'modulo' => array(                                   
                                    array('column'=>'nombre_mod', 'label'=>'Nombre'), 
                                    array('column'=>'descripcion_mod', 'label'=>'Descripci&oacute;n'),                                    
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                                ),
                        'tabla' => array(                                   
                                    array('column'=>'tablename', 'label'=>'Nombre')                                    
                                    //array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                                ),
                        'campo' => array(                                   
                                    array('column'=>'nombre_tbl', 'label'=>'Tabla'),
                                    array('column'=>'nombre_campo', 'label'=>'Campo')                                      
                                    //array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                        ),
                        'rol_permisos' => array(
                            array('column'=>'nom_modulo', 'label'=>'Modulo'), 
                            array('column'=>'ch_insertar', 'label'=>'Insertar', 'attribs'=>'class="center_th"'),
                            array('column'=>'ch_editar', 'label'=>'Editar', 'attribs'=>'class="center_th"'),
                            array('column'=>'ch_consultar', 'label'=>'Consultar', 'attribs'=>'class="center_th"'),
                            array('column'=>'ch_eliminar', 'label'=>'Eliminar', 'attribs'=>'class="center_th"')
                            //array('column'=>'bt_campos', 'label'=>'Campos', 'attribs'=>'class="center_th"')
                        ),
                        'tipo_amoblamiento' => array(                                   
                                    array('column'=>'nombre_ta', 'label'=>'Nombre'), 
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="tipo-amobl-key-css_2"', 'attribs_head'=>'class="tipo-amobl-key-css_2 center_th"')
                                ),
                        'panorama' => array(                                   
                                    array('column'=>'id_panorama', 'label'=>'Panorama'), 
                                    array('column'=>'nom_edificacion', 'label'=>'Edificaci&oacute;n'),
                                    array('column'=>'fecha_creacion', 'label'=>'F.Inspecci&oacute;n'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'inspector', 'label'=>'Inspector'),
                                    array('column'=>'usuario_responsable', 'label'=>'Responsable'),
                                    array('column'=>'editar', 'label'=>'Acciones', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        ),
                        'tarea_panorama' => array( 
                                    array('column'=>'nombreTipoRiesgo', 'label'=>'Tipo riesgo'),
                                    array('column'=>'titulo', 'label'=>'Nombre'), 
                                    array('column'=>'nombreTipoEjecucion', 'label'=>'Plazo'),
                                    array('column'=>'fechaVence', 'label'=>'Vence'),
                                    array('column'=>'nombreEstado', 'label'=>'Estado'),
                                    array('column'=>'puntaje', 'label'=>'Puntaje'),         
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        ),
                        'seguimiento_tarea' => array(                                   
                                    array('column'=>'codSeguimiento', 'label'=>'No. seguimiento'),
                                    array('column'=>'tituloTarea', 'label'=>'Nombre tarea'), 
                                    array('column'=>'nombreEstado', 'label'=>'Estado'),
                                    array('column'=>'observacion', 'label'=>'Descripci&oacute;n')
                                    //array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        ),
                        'observacion_visita' => array(
                            array('column'=>'codVisita', 'label'=>'No. Visita'),
                            array('column'=>'codObservacion', 'label'=>'No. Observacion'), 
                            array('column'=>'fechaVisita', 'label'=>'Fecha creacion visita'),
                            array('column'=>'observacion', 'label'=>'Observacion'),
                            array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        ),
                        'contratos_visita' => array(
                            array('column'=>'vt_cv_fk', 'label'=>'No. Visita'),
                            array('column'=>'suscriptor_cv', 'label'=>'Suscriptor'), 
                            array('column'=>'medidor_cv', 'label'=>'Medidor'),
                            array('column'=>'fecha_creacion', 'label'=>'Fecha creaci&oacute;n'),
                            array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')                            
                        ),
                        'visita_tecnica' => array(                                   
                                    array('column'=>'terreno_vt_fk', 'label'=>'Terreno'), 
                                    array('column'=>'atendido_por_vt', 'label'=>'Atendido por'),
                                    array('column'=>'inspector', 'label'=>'Inspector'),
                                    array('column'=>'objetivo_vt', 'label'=>'Objetivo'),
                                    array('column'=>'calidad_inmueble', 'label'=>'Calidad inmueble'),
                                    array('column'=>'tipo_visita', 'label'=>'Tipo visita'),
                                    array('column'=>'editar', 'label'=>'Acciones', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        )                         
                    );    

        return $cabecera[$cbz];
    }

   /*funcion para enviar correos 1*/

    public function enviarEmail($de,$para,$asunto,$mensaje){
        //configuracion para gmail
          $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $this->Utilidades_model->getParametro(5),
            'smtp_pass' => $this->Utilidades_model->getParametro(6),
            'smtp_crypto' => 'ssl',
            'mailtype' => 'html',
            'smtp_timeout' => '4',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE // cambio ever 18-07-2018
          ); 

          //cargamos la configuración para enviar con gmail
          $this->email->initialize($configGmail);

          $this->email->from($de);
          $this->email->to($para);          
          $this->email->subject($asunto);
          $this->email->message("<h2>Panorama de riesgos</h2><hr><br>".$mensaje);
          $envio = $this->email->send();         

          return $envio;


     }

     /*funcion para enviar correos 2*/

   public function enviarEmail2($from,$to,$asunto,$mensaje,$name,$pdf,$name_file){

          //set_time_limit(120);
          $aux_host = $this->Utilidades_model->getParametro(11);
          $aux_username = $this->Utilidades_model->getParametro(5);
          $aux_pass = $this->Utilidades_model->getParametro(6);                   
                    
          $mail = new PHPMailer();            

          //$mail->SMTPDebug  = 2; 
          $mail->IsSMTP(); 
          $mail->Timeout =   120;         
          $mail->Host = $aux_host;
          $mail->SMTPAuth = true;
          $mail->Username = $aux_username;  // Correo Electrónico
          $mail->Password = $aux_pass; // Contraseña
          $mail->SMTPSecure = 'tls';          
          $mail->Port = 587;           
          
          //configurar email 
          $mail->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );        
          $mail->SetFrom($from, $name);
          $mail->AddAddress($to);
          $mail->isHTML(true); 
          $mail->Subject  =  $asunto;
          $mail->CharSet = 'UTF-8';
          $mail->Body = $mensaje; //"Nombre: $name \n<br />".  
           if($pdf != ""){            
              $mail->addStringAttachment($pdf,$name_file);
           }      
          //$mail->WordWrap = 50; 

          if ($mail->Send()){
            $result = "OK";
          }else{
            $result = "NO";
          }

          $mail->SmtpClose();         

         return $result;


   }  
     /*funcion para subir archivos*/
     public function UploadFile($path,$nameImg, $typeFiles){ 
        $retorno="";        
        $config['upload_path'] = $path;                    
        $config['allowed_types'] = $typeFiles;
        $config['encrypt_name'] = false;
        $config['file_name'] = rand(10,100000) .'_'. $_FILES[$nameImg]["name"];       
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($nameImg)){
            $error = $this->upload->display_errors();
            $retorno=$error;           
            return false;
        }
        else{
            $file_data = $this->upload->data();
            return $file_data['file_name'];
        }
      }    

   /*esta funcion envia en el parametro where la condicion que quiero que se cumpla*/

    public function generarComboWhere($id, $tabla, $p_campo1, $p_campo2, $order, $seleccione, $where, $firtsMayus, $objAttr) {
        /*
            Descripción de parametros.
            -----------------------------------------------------------------------------------------------------------
            id : Identificador del selector
            tabla : Tabla de la db donde se consultan los datos
            campo1 : campo identificador (PK_ID), este es el value de la opcion en el selector
            campo2 : campo texto visual (DESCRIPCION), este es el html de la opcion en el selector
            order : campo por el que se va ha ordenar (1=PK_ID, 2=DESCRIPCION)
            seleccione : campo adicional a los items de la lista (''=null, ' '=item vacio, 'Selecione...'= item texto)
            where : condicion sql para filtrar registros consultados
            firtsMayus : formatea texto a, preimera letra en mayusculas y el resto en minusculas (true/false)
            objAttr : objecto con atribitos a añadir a la etiqueta select ("attributo"=>"valor_atributo")
        */

        $atributos = '';
        $seleccionar = '';
        foreach ($objAttr as $atributo => $value) {
            if($atributo != '_SELECCIONAR_'){
                $atributos .= $atributo.'="'.$value.'" ';
            }else{
                $seleccionar = $value;
            }            
        }
        
        $valorIni = $seleccione;
        $selInicio = '<select name="'.$id.'" id="'.$id.'" '.$atributos.'>';
        $selFin = "</select>";
        $cadena = "";
        
        if($valorIni != ''){
            $cadena = $cadena . '<option value ="-1" selected>' . $valorIni . '</option>';
        }
        
        $v_campo1 = explode('::',$p_campo1);
        $v_campo2 = explode('::',$p_campo2);
        $campo1 = $v_campo1[0];
        $campo2 = $v_campo2[0];
        $cast_campo1 = isset($v_campo1[1]) ? '::'.$v_campo1[1] : '';
        $cast_campo2 = isset($v_campo2[1]) ? '::'.$v_campo2[1] : '';

        try {
            $aux_array_coleccion = array('campo1' => $campo1,
                                         'campo2' => $campo2,
                                         'tabla'  => $tabla,
                                          'where'  => $where);

            $cadenaQuery = "SELECT DISTINCT codigo".$cast_campo1.", nombre".$cast_campo2." FROM public.fn_get_coleccion_where(?,?,?,?)";            
            
            $cadenaQuery = $cadenaQuery ." ORDER BY ".$order;

            $data=$this->db->query($cadenaQuery,$aux_array_coleccion);

            if ($data->num_rows() > 0) {
              
                foreach ($data->result() as  $fila) {
                    $selected = $seleccionar == $fila->codigo ? 'selected' : '';

                    if($firtsMayus){
                        $cadena = $cadena . '<option value="' . $fila->codigo .'" '.$selected.' >' .mb_convert_case($fila->nombre, MB_CASE_TITLE, 'UTF-8').'</option>';
                    }else{
                        $cadena = $cadena . '<option value="' . $fila->codigo .'" '.$selected.' >' . $fila->nombre .'</option>'; 
                    }
                }                
              
            }

            if($id != ''){
                    $cadena = $selInicio . $cadena . $selFin;
            }

            return $cadena;

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }   

    public function UploadImage($path,$nameImg, $typeFiles){

        $retorno="";        
        $config['upload_path'] = $path;                    
        $config['allowed_types'] = $typeFiles;
        $config['encrypt_name'] = false; 
        $config['max_size'] = '10240000000';
        $config['file_name'] = rand(10,100000).'_'.$this->limpiarCaracteresEspeciales($_FILES[$nameImg]["name"]);   
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($nameImg)){
            $error = $this->upload->display_errors();
            $retorno =$error;                              
            return false;
        }
        else{
            $file_data = $this->upload->data();
            return $file_data['file_name'];
        }
      }     

    /*Obtener ip*/
    public function getRealIpAddr() {
        
          if (isset($_SERVER["HTTP_CLIENT_IP"]))
            {
                return $_SERVER["HTTP_CLIENT_IP"];
            }
            elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
            {
                return $_SERVER["HTTP_X_FORWARDED"];
            }
            elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_FORWARDED"]))
            {
                return $_SERVER["HTTP_FORWARDED"];
            }
            else
            {
                return $_SERVER["REMOTE_ADDR"];
            }
    }


    
    public function getBrowser($user_agent){

        if(strpos($user_agent, 'MSIE') !== FALSE)
           return 'Internet explorer';
         elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
           return 'Microsoft Edge';
         elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
            return 'Internet explorer';
         elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
           return "Opera Mini";
         elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
           return "Opera";
         elseif(strpos($user_agent, 'Firefox') !== FALSE)
           return 'Mozilla Firefox';
         elseif(strpos($user_agent, 'Chrome') !== FALSE)
           return 'Google Chrome';
         elseif(strpos($user_agent, 'Safari') !== FALSE)
           return "Safari";
         else
           return 'No hemos podido detectar su navegador';


     }

     public function getDataSesion(){

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $user = $this->session->userdata('login_usuario');
        if(!$user){
            $user = 'sistema';
        }
        $browser = $this->Utilidades_model->getBrowser($user_agent);
        $ip = $this->Utilidades_model->getRealIpAddr();
        $result = array(
                        "user" => $user,
                        "browser" => $browser,
                        "ip" => $ip
                    );

        $retorno = $result['user'].'='.$result['ip'].'='.$result['browser'];

        return $retorno;

    } 

    /*funcion para darle formato de miles a un valor numerico*/

    function formatMiles($valor){
        $valCampo = str_replace('.','',$valor);
        $cadenaMiles = '';
        $contarMiles = 0;
        for($v=strlen($valCampo); $v>0; $v--){
            //console.log('VAR_V ->',v, ' = ',valCampo[v-1]);
            
            if($contarMiles % 3 == 0){
              $cadenaMiles = $valCampo[$v-1] . '.' .$cadenaMiles;
            }else{
              $cadenaMiles = $valCampo[$v-1] .''. $cadenaMiles;
            }
            $contarMiles++;
        }
        
        return substr($cadenaMiles, 0, strlen($cadenaMiles)-1);
    } 

      

    public function replaceCharSpec($str){ 

        $resReplace = str_replace('á','a',$str);
        $resReplace = str_replace('é','e',$resReplace);
        $resReplace = str_replace('í','i',$resReplace);
        $resReplace = str_replace('ó','o',$resReplace);
        $resReplace = str_replace('ú','u',$resReplace);
        $resReplace = str_replace('ñ','n',$resReplace);
        $resReplace = str_replace('Á','A',$resReplace);
        $resReplace = str_replace('É','E',$resReplace);
        $resReplace = str_replace('Í','I',$resReplace);
        $resReplace = str_replace('Ó','O',$resReplace);
        $resReplace = str_replace('Ú','U',$resReplace);
        $resReplace = str_replace('Ñ','N',$resReplace);
        $resReplace = str_replace('/','_',$resReplace);
        $resReplace = strtoupper($resReplace);
      
        return $resReplace;
    } 

   /*funcion para limpiar todos los caracterres especiales de una cadena*/
   public function limpiarCaracteresEspeciales($string ){
     $string = htmlentities($string);
     $string = preg_replace('/\&(.)[^;]*;/', '\1', $string);
     return $string;
   }    

   public function validaSession() {
        $codUser = $this->session->userdata('codigoUsuario');
        if(!$codUser){
            $this->llenarSesionInvitado();
            redirect('Home');
        }
   }

    public function getKeyIp(){
        $ipAddr = $_SERVER['REMOTE_ADDR'];
        $mes = date("m");
        $dia = date("d");
        $ipNum = str_replace(":","",str_replace(".", "", $ipAddr));
        $keyIp =  '-8'. $ipNum . $mes . $dia;
        $ressKey = intval($keyIp);
        //var_dump($ressKey);
        return  $ressKey;
    }

    public function encryptArgon2($cadena){
       $cadena_encrypt = password_hash($cadena, PASSWORD_ARGON2I);

       return $cadena_encrypt;
   }


   function getDateTime($date, $format){
        $datoFecha = '';

        if($date == '-1' || $date == ''){
            $datoFecha = date($format, time());
        }else{
            $datoFecha = date($format, $date);
        }
        
        return $datoFecha;
    }

    function llenarSesionInvitado(){
        $rolInvitado = 0;
        $result = $this->getDataPermisoRol($rolInvitado);
        $modulosNoAplica = json_decode($result->modulos_no_aplica, true);
        $datosUsuario= array(/*'codigoUsuario' => $result->id_user_pk,                                
                            'identificacion' => $result->identificacion_user,
                            'nombre1' => mb_convert_case($result->primer_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                            'nombre2' => mb_convert_case($result->segundo_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                            'apellido1' => mb_convert_case($result->primer_apellido_user, MB_CASE_TITLE, "UTF-8"),
                            'apellido2' => mb_convert_case($result->segundo_apellido_user, MB_CASE_TITLE, "UTF-8"),                               
                            'email' => $result->correo_user,                               
                            'codigo_rol' => $rolInvitado,*/
                            'modulos_no_aplica_arr' => $modulosNoAplica,
                            'modulos_no_aplica' => $this->getCalssPageNot($modulosNoAplica)
                            );
        
        $this->session->set_userdata($datosUsuario);

    }

    public function getDataPermisoRol($rol){

        $query = "SELECT
                    fn_get_css_no_permisos(".$rol.") AS modulos_no_aplica
                  ";

        $result = $this->db->query($query); 
        $datos = array();     

        if ($result->num_rows() > 0) {
             $datos = $result->row(); 
        }

        return  $datos;
    }


    public function getCalssPageNot($modulos){
        $str_class = '';
        $obj_modulos = $modulos;
  
        for($p=0; $p<count($obj_modulos); $p++){
            $str_class .= '.'.$obj_modulos[$p].'{ display:none !important; } ';
        }

        return $str_class;
    }

        /**
     * Reducción de imagen
     * 
     * Este método sirve para reducir los pixeles de una imagen hasta un mínimo 
     * de 600 x 400
     * 
     * @param string $imgFile Ruta relativa de la imagen a reducir
     * @param string $tipo    Tipo de imagen: PNG o JPG
     */
    public function reducirIMG($imgFile, $tipo = 'png') {
        if (isset($imgFile) && $imgFile != '') {

            //Imagen original
            $rtOriginal = $imgFile;

            //Crear variable
            if ($tipo == 'png') {
                $original = imagecreatefrompng($rtOriginal);
            } else {
                $original = imagecreatefromjpeg($rtOriginal);
            }

            //Ancho y alto máximo
            $max_ancho = 600;
            $max_alto = 400;

            //Medir la imagen
            list($ancho, $alto) = getimagesize($rtOriginal);

            //Ratio
            $x_ratio = $max_ancho / $ancho;
            $y_ratio = $max_alto / $alto;

            //Proporciones
            if (($ancho <= $max_ancho) && ($alto <= $max_alto)) {
                $ancho_final = $ancho;
                $alto_final = $alto;
            } else if (($x_ratio * $alto) < $max_alto) {
                $alto_final = ceil($x_ratio * $alto);
                $ancho_final = $max_ancho;
            } else {
                $ancho_final = ceil($y_ratio * $ancho);
                $alto_final = $max_alto;
            }

            //Crear un lienzo
            $lienzo = imagecreatetruecolor($ancho_final, $alto_final);

            //Copiar original en lienzo
            imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

            //Destruir la original
            imagedestroy($original);

            //Crear la imagen y guardar en directorio upload/
            if ($tipo == 'png') {
                imagepng($lienzo, $imgFile);
            } else {
                imagejpeg($lienzo, $imgFile);
            }
        }
    }

/**
     * Consumo WS Orfeo
     * 
     * @param type $imgBase64     Ruta relativa donde quedó el upload de la imagen
     * @param string $tipo        Tipo de fraude que se puede estar efectuando al predio
     * @param string $direccion 
     * @param string $predial     Número de predial 
     * @param string $nombre      Persona que está haciendo el reporte
     * @param string $correo      Correo electrónico de quien está haciendo el reporte
     * @param number $telefono    Número de teléfono de quien está haciendo el reporte
     * @param string $coordenadas Latitud y longitud
     * @param string $ip          Dirección IP de la máquina donde se hace el reporte
     * @param string $cedula      
     * @return int                Número de radicado
     */
    public function wsOrfeo($imgBase64, $tipo, $direccion, $predial, $nombre, 
                            $correo, $telefono, $coordenadas, $ip, $cedula) {
        //$BIENES_ORFEO_CAMPO_DOCUMENTO ='0';
        $BIENES_ORFEO_CAMPO_CEDULADEFECTO = '93939393';
        $BIENES_ORFEO_CAMPO_TIPOEMP = '1';
        $BIENES_ORFEO_CAMPO_IDCONT ='1';
        $BIENES_ORFEO_CAMPO_IDPAIS = '170';
        $BIENES_ORFEO_CAMPO_CODEP = '76';
        $BIENES_ORFEO_CAMPO_MUNI = '1';
        $BIENES_ORFEO_CAMPO_OBSERVACION = 'FRAUDE EN PREDIO, ';
        $BIENES_ORFEO_CAMPO_MEDIOREC = '3';
        $BIENES_ORFEO_CAMPO_ANEXOS = '7';
        $BIENES_ORFEO_CAMPO_CODDEPEN = '4137010';
        $BIENES_ORFEO_CAMPO_TIPORAD = '2';
        $BIENES_ORFEO_CAMPO_CUENTA = '4';
        $BIENES_ORFEO_CAMPO_DEPENDENCIA = '4137010';
        $BIENES_ORFEO_CAMPO_TIPOREM = '3'; // Tipo de remitente. Asociado con la tabla tipo_remitente (en la tabla de uds 0-Entidades,1-Otras empresas,
        $BIENES_ORFEO_CAMPO_TIPOREMITENTE = '671';
        $BIENES_ORFEO_CAMPO_DOCUMENTO = '0'; // Tipo de Documento.   Asociado a la tabla tipo_doc_identificacion con datos
        $BIENES_ORFEO_CAMPO_CODDIRRAD = '0'; // Codigo de carpeta a la cual se quiere enviar el radicado.  0 – La bandeja de
        $BIENES_ORFEO_CAMPO_CODDIR = '0'; //  Codigo tipo de carpeta.  0- Carpetas generales (Entrada, salida, internas)   1-
        $BIENES_ORFEO_CAMPO_DOCRAD = '66838856'; // Documento de identificacion de la persona radicadora.  Esta debe existir
        $BIENES_ORFEO_WSDL = $this->getParametro(10);//'http://172.18.26.33/webServ/wsRadicado2p.php?wsdl';
        $BIENES_ORFEO_CAMPO_DESCRIMG = 'Guardado por Bienes inmuebles'; // Tipo de solicitud
        $_FILESBIENES_ORFEO_CAMPO_OTRO = '';
        $BIENES_ORFEO_CAMPO_OTRO = 'Informativa';


        $nombre = explode(' ', $nombre);
        $destinatario1 = array(
            'documento' => $BIENES_ORFEO_CAMPO_DOCUMENTO,
            'cc_documento' => $cedula==""?$BIENES_ORFEO_CAMPO_CEDULADEFECTO:$cedula,
            'tipo_emp' => $BIENES_ORFEO_CAMPO_TIPOEMP,
            'nombre' => count($nombre)>0?$nombre[0]:'',
            'prim_apel' => count($nombre)>1?$nombre[1]:'',
            'seg_apel' => count($nombre)>2?$nombre[2]:'',
            'telefono' => $telefono!=""?$telefono:'',
            'direccion' => $direccion!=""?$direccion:'',
            'mail' => $correo!=""?$correo:'',
            'otro' => $BIENES_ORFEO_CAMPO_OTRO,//$_FILESBIENES_ORFEO_CAMPO_OTRO, //$tipo.'|'.$ip.' fecha: ' . date("Y-m-d"),
            'idcont' => $BIENES_ORFEO_CAMPO_IDCONT,
            'idpais' => $BIENES_ORFEO_CAMPO_IDPAIS,
            'codep' => $BIENES_ORFEO_CAMPO_CODEP,
            'muni' => $BIENES_ORFEO_CAMPO_MUNI
        );

        $arregloDatos = array();
        $arregloDatos[0] = $correo!=""?$correo:'';
        $arregloDatos[1] = $destinatario1;
        $arregloDatos[2] = ""; // Predio = se envia una cadena vacía
        $arregloDatos[3] = ""; // esp = se envia una cadena vacía
        $arregloDatos[4] = $BIENES_ORFEO_CAMPO_OBSERVACION.' '.$ip.' fecha: '.date("Y-m-d");
        $arregloDatos[5] = $BIENES_ORFEO_CAMPO_MEDIOREC;
        $arregloDatos[6] = $BIENES_ORFEO_CAMPO_ANEXOS;
        $arregloDatos[7] = $BIENES_ORFEO_CAMPO_CODDEPEN;
        $arregloDatos[8] = $BIENES_ORFEO_CAMPO_TIPORAD;
        $arregloDatos[9] = $BIENES_ORFEO_CAMPO_CUENTA;
        $arregloDatos[10] = $BIENES_ORFEO_CAMPO_DEPENDENCIA;
        $arregloDatos[11] = $BIENES_ORFEO_CAMPO_TIPOREM;
        $arregloDatos[12] = $BIENES_ORFEO_CAMPO_TIPOREMITENTE;
        $arregloDatos[13] = $BIENES_ORFEO_CAMPO_DOCUMENTO;           
        $arregloDatos[14] = $BIENES_ORFEO_CAMPO_CODDIRRAD;
        $arregloDatos[15] = $BIENES_ORFEO_CAMPO_CODDIR;
        $arregloDatos[16] = $BIENES_ORFEO_CAMPO_DOCRAD;
        $arregloDatos[17] = "";            //  Radicado asociado
        $arregloDatos[18] = "";            //  Número expediente

        $client = new SoapClient($BIENES_ORFEO_WSDL);
        $result = $client->__soapCall('radicarXDependencia', $arregloDatos);

        // Si hay genera un número de radicado y hay una imagen, se consume el otro WS
        if (isset($result->numeroRadicado) && $result->numeroRadicado!="" && $imgBase64!="") {
            $im = file_get_contents($imgBase64);
            $imgFile = base64_encode($im);
            $arregloDatos = array(); // imagen 64
            $arregloDatos[0] = $result->numeroRadicado;
            $arregloDatos[1] = str_replace('img/', '', $imgBase64); //$imgBase64; //$ext[count($ext)-1];
            $arregloDatos[2] = $BIENES_ORFEO_CAMPO_DOCRAD;
            $arregloDatos[3] = $imgFile;
            $arregloDatos[4] = $BIENES_ORFEO_CAMPO_DESCRIMG;
                                    
            $resultImg = $client->__soapCall('anexoRadicadov3', $arregloDatos);
        }
        
        return $result->numeroRadicado;        
    }

    public function getParametro($codigo_parametro){

       $parametros = array('codigo' => $codigo_parametro, 
                           'estado' => 1);
            
       $sql = "SELECT valor_pr FROM public.parametros WHERE id_pr = ? AND estado_pr_fk = ?";
       $result = $this->db->query($sql,$parametros);
       return $result->row()->valor_pr; 
    }

    /*funcion para convertir html en pdf*/
   public function crearPdf($view,$accion,$nom_pdf,$data){

      try {            
            ob_start();                  
            $this->load->view($view,$data);
            $content = ob_get_clean();
            $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8');  // despues del utf8  valor de los margenes ejemplo array (5, 5, 5, 8) (opcional)
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->setTestIsImage(false);            
            $html2pdf->writeHTML($content); 
            ob_end_clean();            
            $pdf = $html2pdf->output($nom_pdf,$accion); 

       } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
      }

      if ($accion == 'S') {
        return $pdf;
      }

   }    
      
     
 }

 ?>
    
   

     
