<?php 

  defined('BASEPATH') OR exit('No direct script access allowed');
  header("Access-Control-Allow-Origin: * ");
  class Login extends CI_Controller{
    
     public function __construct() {
        parent::__construct(); 
        $this->load->model('Login_model'); 
        $this->load->model('Utilidades_model');
        //$this->load->library('Auth_AD');     
     }
    
     public function loguear(){           
      $usuario = trim($this->input->post('email'));
      $clave = trim($this->input->post('clave'));
      $aux_clave = md5($clave);
      $datos = array('login' => $usuario);
     
        $result = $this->Login_model->getDataInicioSession($datos);      
        if ($result != false AND $aux_clave == $result->clave_user AND $result->estado_user_fk == 1){ /*AND password_verify($clave,$result->clave_user)*/          
              $modulosNoAplica = json_decode($result->modulos_no_aplica, true);
              $datosUsuario= array('codigoUsuario' => $result->id_user_pk,                                
                                  'identificacion' => $result->identificacion_user,
                                  'nombre1' => mb_convert_case($result->primer_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                                  'nombre2' => mb_convert_case($result->segundo_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                                  'apellido1' => mb_convert_case($result->primer_apellido_user, MB_CASE_TITLE, "UTF-8"),
                                  'apellido2' => mb_convert_case($result->segundo_apellido_user, MB_CASE_TITLE, "UTF-8"),                               
                                  'email' => $result->correo_user,                                
                                  'codigo_rol' => $result->rol_user_fk,
                                  'modulos_no_aplica_arr' => $modulosNoAplica,
                                  'modulos_no_aplica' => $this->Utilidades_model->getCalssPageNot($modulosNoAplica),
                                  'login_usuario' => $usuario
                                  );
             
              $this->session->set_userdata($datosUsuario);
              $data["respuesta"] = 'OK'; 
              $this->validUser($usuario,2);  

              $user_agent = $_SERVER['HTTP_USER_AGENT'];       
              $browser = $this->Utilidades_model->getBrowser($user_agent);
              $ip = $this->Utilidades_model->getRealIpAddr();

              $datosLogUsuarios = array('usuario_log' => $usuario,
                                        'ip_addres_log' => $ip, 
                                        'navegador_log' => $browser);

              $datosRetorno = $this->Login_model->guardarLogUsuariosSistemas($datosLogUsuarios);        
              $arrayData = explode("%", $datosRetorno);
              $this->session->set_userdata("sec_log_usuario",$arrayData[0]);
              $this->session->set_userdata("fecha_session",$arrayData[1]);

         }else if($result != false AND $aux_clave == $result->clave_user AND $result->estado_user_fk == 2){
             $data["respuesta"] = 'El usuario ingresado se encuentra inactivo.'; 
         }else if($result != false AND $aux_clave == $result->clave_user AND $result->estado_user_fk == 6){
             $data["respuesta"] = 'El usuario ingresado se encuentra bloqueado.';
         }else if($result != false AND $aux_clave != $result->clave_user){          
             if ($result->num_fails_sesion >= 3) {
                 $this->bloquearUser($usuario);
                 $data["respuesta"] = 'El usuario ingresado se encuentra bloqueado.';
             }else{
                 $data["respuesta"] = 'No existe ning&uacute;n usuario con los datos ingresados.';
             }
             $this->validUser($usuario,1);
         }else{               
                $validDirectActivo = $this->Login_model->mailboxpowerloginrd($usuario,$clave);//$this->auth_ad->login($usuario, $clave);

                if ($validDirectActivo) {
                  $datosUsuario= array('codigoUsuario' => -1,                                
                                        'identificacion' => -1,
                                        'nombre1' => $usuario,                                
                                        'nombre2' => "",                                
                                        'apellido1' => "",
                                        'apellido2' => "",                               
                                        'email' => $usuario,                                
                                        'codigo_rol' => -1,
                                        'modulos_no_aplica_arr' => array(),
                                        'modulos_no_aplica' => ''
                                        );
                   
                    $this->session->set_userdata($datosUsuario);
                    $data["respuesta"] = 'OK'; 

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];       
                    $browser = $this->Utilidades_model->getBrowser($user_agent);
                    $ip = $this->Utilidades_model->getRealIpAddr();

                   $datosLogUsuarios = array('usuario_log' => $usuario,
                                        'ip_addres_log' => $ip, 
                                        'navegador_log' => $browser);
                    $datosRetorno = $this->Login_model->guardarLogUsuariosSistemas($datosLogUsuarios);        
                    $arrayData = explode("%", $datosRetorno);
                    $this->session->set_userdata("sec_log_usuario",$arrayData[0]);
                    $this->session->set_userdata("fecha_session",$arrayData[1]);

                }else{
                    $data["respuesta"] = 'No existe ning&uacute;n usuario con los datos ingresados.';
                }
         }    
       
         $this->output->set_content_type('application/json')->set_output(json_encode($data));       
      
 }    

    public function guardarUsuario(){

      $this->Utilidades_model->validaSession();
      $usuario = trim($this->input->post("email"));
      $clave = trim($this->input->post("clave")) == "" ? "-1" : trim($this->input->post("clave"));
      $codigo_usuario = $this->input->post("codigo_usuario");

       if ($clave != "-1") {          
          $clave = md5($clave);//$this->Utilidades_model->encryptArgon2($clave);
       }
            
       $obj = array(      
                   'codigo' => $codigo_usuario,                               
                   'identificacion' => null,//trim($this->input->post("identificacion")),                  
                   'nombre1' => $this->input->post("nombre1"),
                   'nombre2' => $this->input->post("nombre2"), 
                   'apellido1' => $this->input->post("apellido1"),
                   'apellido2' => $this->input->post("apellido2"), 
                   'email' => $usuario,  
                   'clave' => $clave,
                   'estado' =>  $this->input->post("estado"),                      
                   'dependencia' => $this->input->post("dependencia"),                   
                   'rol' => $this->input->post("rol"),
                   'email_anterior' => $this->input->post("email_anterior"),
                   'dataSesion' => $this->Utilidades_model->getDataSesion()                                   
                   );         
         
          $result["result"] = $this->Login_model->guardarUsuario($obj);
          $result["tabla"] = $this->crearTablaUsuario();

          $this->output->set_content_type('application/json')->set_output(json_encode($result));
    
  }  

   public function logout() {

      $fecha_session = $this->session->userdata('fecha_session');
      $sec_log_usuario = $this->session->userdata('sec_log_usuario');               

      $date1 = new DateTime($fecha_session);

      $date2 = new DateTime("now");
      $diff = $date1->diff($date2);
      $segundos_sesion = (($diff->days * 24 ) * 60 ) + ( $diff->i * 60 ) + $diff->s;      
          
      $this->Login_model->updateLogUsuarios($sec_log_usuario,$segundos_sesion);
      $this->session->sess_destroy();
      redirect('Home');
   }   

  public function crearTablaUsuario(){
        
        $columnas = $this->Utilidades_model->columnCbz('usuario');
        $datos =   $this->Login_model->getDatosUsuaro(-1);                  
        
        //adicionar editar y eliminar
       for($e=0; $e < count($datos); $e++){
         
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

   public function loguearMobileExt(){
           
      $usuario = trim($_REQUEST["mail"]);
      $clave = trim($_REQUEST["pass"]); 
      $status = 0;  
      $mensaje = ""; 
      $datosUsuario = array();
      $respuesta = array();
      $aux_clave = md5($clave);

      $datos= array('login' => $usuario);

      $result = $this->Login_model->getDataInicioSession($datos);
      
      if ($result != false AND $aux_clave == $result->clave_user AND $result->estado_user_fk == 1){ /*password_verify($clave,$result->clave_user)*/        
            $modulosNoAplica = json_decode($result->modulos_no_aplica, true);
            $datosUsuario = array('codigoUsuario' => $result->id_user_pk,                                
                                'identificacion' => $result->identificacion_user,
                                'nombre1' => mb_convert_case($result->primer_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                                'nombre2' => mb_convert_case($result->segundo_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                                'apellido1' => mb_convert_case($result->primer_apellido_user, MB_CASE_TITLE, "UTF-8"),
                                'apellido2' => mb_convert_case($result->segundo_apellido_user, MB_CASE_TITLE, "UTF-8"),                               
                                'email' => $result->correo_user,                                
                                'codigo_rol' => $result->rol_user_fk,
                                'modulos_no_aplica_arr' => $modulosNoAplica,
                                'modulos_no_aplica' => $this->Utilidades_model->getCalssPageNot($modulosNoAplica),
                                'fecha_session' => $result->fecha_creacion_user
                                );
           
            $status = 1;
            $mensaje = "Usuario logeado correctamente";
            $this->validUser($usuario,2);

            $user_agent = $_SERVER['HTTP_USER_AGENT'];       
            $browser = $this->Utilidades_model->getBrowser($user_agent);
            $ip = $this->Utilidades_model->getRealIpAddr();

            $datosLogUsuarios = array('usuario_log' => $usuario,
                                      'ip_addres_log' => $ip, 
                                      'navegador_log' => $browser);

            $datosRetorno = $this->Login_model->guardarLogUsuariosSistemas($datosLogUsuarios);        
            $arrayData = explode("%", $datosRetorno);
            $this->session->set_userdata("sec_log_usuario",$arrayData[0]);
            $this->session->set_userdata("fecha_session",$arrayData[1]);                     

       }else if($result != false AND $aux_clave == $result->clave_user AND $result->estado_user_fk == 2){
           $mensaje = 'El usuario ingresado se encuentra inactivo.'; 
       }else if($result != false AND $aux_clave == $result->clave_user AND $result->estado_user_fk == 6){
           $mensaje = 'El usuario ingresado se encuentra bloqueado.';
       }else if($result != false AND $aux_clave != $result->clave_user){          
           if ($result->num_fails_sesion >= 3) {
               $this->bloquearUser($usuario);
               $mensaje = 'El usuario ingresado se encuentra bloqueado.';
           }else{
               $mensaje = 'No existe ning&uacute;n usuario con los datos ingresados.';
           }
           $this->validUser($usuario,1);
       }else{
          //$mensaje = 'No existe ningún usuario con los datos ingresados.';
          $validDirectActivo = $this->Login_model->mailboxpowerloginrd($usuario,$clave);//$this->auth_ad->login($usuario, $clave);
          
          if ($validDirectActivo) {

              $datosUsuario = array('codigoUsuario' => -1,                                
                                    'identificacion' => -1,
                                    'nombre1' => $usuario,                                
                                    'nombre2' => "",                                
                                    'apellido1' => "",
                                    'apellido2' => "",                               
                                    'email' => $usuario,                                
                                    'codigo_rol' => -1
                                    );
               
               $status = 1;
               $mensaje = "Usuario logueado correctamente.";

              $user_agent = $_SERVER['HTTP_USER_AGENT'];       
              $browser = $this->Utilidades_model->getBrowser($user_agent);
              $ip = $this->Utilidades_model->getRealIpAddr();

              $datosLogUsuarios = array('usuario_log' => $usuario,
                                        'ip_addres_log' => $ip, 
                                        'navegador_log' => $browser);

              $datosRetorno = $this->Login_model->guardarLogUsuariosSistemas($datosLogUsuarios);        
              $arrayData = explode("%", $datosRetorno);
              $this->session->set_userdata("sec_log_usuario",$arrayData[0]);
              $this->session->set_userdata("fecha_session",$arrayData[1]); 
           
          }else{
              $mensaje = "No existe ning&uacute;n usuario con los datos ingresados.";
          } 

    }   

     $respuesta = array('status' => $status, 
                          'message' => $mensaje,
                          'data' => $datosUsuario); 
     
       $this->output->set_content_type('application/json')->set_output(json_encode($respuesta));       
      
 }

     public function validUser($login,$accion){  

        if ($accion == 1) {

            $objParam = array(
                    "tipo" => "update",
                    "tabla" => "public.user",
                    "campos" => "num_fails_sesion = num_fails_sesion+1",                       
                    "datos"  => "",             
                    "condicional" => "correo_user = '".$login."'",
                    'dataSesion' => $this->Utilidades_model->getDataSesion()
                    );
        }else{

          $objParam = array(
                    "tipo" => "update",
                    "tabla" => "public.user",
                    "campos" => "num_fails_sesion = 0",                       
                    "datos"  => "",             
                    "condicional" => "correo_user = '".$login."'",
                    'dataSesion' => $this->Utilidades_model->getDataSesion()
                    );

        }
        $resultado = $this->Login_model->ejecutarSentencia($objParam);        
    } 

     public function bloquearUser($login){       

            $objParam = array(
                    "tipo" => "update",
                    "tabla" => "public.user",
                    "campos" => "estado_user_fk = 6",                       
                    "datos"  => "",             
                    "condicional" => "correo_user = '".$login."'",
                    'dataSesion' => $this->Utilidades_model->getDataSesion()
                    );

            $resultado = $this->Login_model->ejecutarSentencia($objParam); 
    }

    public function loginDA($usuario, $password) {
        //sxMod::setVar('Bienes', 'LDAP', array('host'=>'192.168.1.2', 'port'=>389, 'dominio'=>'nexura.nx'));

        $usuario = blindSqlInjection(removeTags(cleanCRLF(cleanXSS(multipleHtmlEntityDecode($usuario)))));
        $password = blindSqlInjection(removeTags(cleanCRLF(cleanXSS(multipleHtmlEntityDecode($password)))));

        // Se genera el JWT
        /*$nombre = explode(',', $entries[0]['dn']);
        $time = time(); // (60*60*24*365);
        $token = array(
            'iat' => $time, // Tiempo que inició el token
            'exp' => $time + BIENES_TOKENTIME, // Tiempo que expirará el token (1 año)
            'data' => [// información del usuario
                'id' => 1,
                'name' => 'jpoblano@info.info'
            ]
        );
        $jwt = JWT::encode($token, BIENES_TOKENKEY);*/

        $ldap_connect = ldap_connect(BIENES_LDAP_HOST, BIENES_LDAP_PORT);        
        
        if (!$ldap_connect) {
            return array('success' => 0, 'msg' => BIENES_LDAP_ERROR);
        }

        ldap_set_option($ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_connect, LDAP_OPT_REFERRALS, 0);

        $loginTmp = trim($usuario) . '@' . BIENES_LDAP_DOMINIO;
        $ldapbind = ldap_bind($ldap_connect, $loginTmp, trim($password));

        /*
         * En caso de conexión correcta, al sistema, se busca en la DB LDAP el 
         * usuario para entregar sus credenciales
         */
        if ($ldapbind) {
            $_COOKIE['tokenSID'] = false;
            $_SESSION['Bienes']['token'] = '';

            $attributes = array('mail');
            // Search AD
            $dc_dominio = explode('.', BIENES_LDAP_DOMINIO);
            $results = ldap_search($ldap_connect, 'DC=' . implode(',DC=', $dc_dominio), "(samaccountname=$usuario)", $attributes);
            $entries = ldap_get_entries($ldap_connect, $results);

            // Se genera el JWT
            $nombre = explode(',', $entries[0]['dn']);
            $time = time(); // (60*60*24*365);
            $token = array(
                'iat' => $time, // Tiempo que inició el token
                'exp' => $time + BIENES_TOKENTIME, // Tiempo que expirará el token (1 año)
                'data' => [// información del usuario
                    'id' => $entries[0]['mail'][0],
                    'name' => str_replace('CN=', '', $nombre[0])
                ]
            );
            $jwt = JWT::encode($token, BIENES_TOKENKEY);

            if ($entries[0]['mail']['count'] > 0) {
                setcookie("tokenSID", $jwt, $time + BIENES_TOKENTIME);
                return array('success' => 1, 'msg' => BIENES_LOGINOK, 'data' => array('nombre' => $token['data']['name'], 'token' => $jwt));
            } else {
                return array('success' => 0, 'msg' => BIENES_LDAP_LOGINNOTOK);
            }
        } else {
            return array('success' => 0, 'msg' => BIENES_LDAP_LOGINNOTOK);
        }
    }

  }   


 ?>