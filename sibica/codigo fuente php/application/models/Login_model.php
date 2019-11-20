<?php 

  require_once("config.php");
  class Login_model extends CI_Model{
    
     public function __construct() {
        parent::__construct(); 
     }    

    public function getDatosUsuaro($codigo){  

        $query = "SELECT 
                      us.*,
                        es.nombre_estado as nombre_estado,
                        dp.nombre_depen as nombre_dependencia,
                        ro.nombre_rol as nombre_rol,
                        CONCAT(us.primer_nombre_user,' ',us.segundo_nombre_user,' ',us.primer_apellido_user,' ',us.segundo_apellido_user) AS nombre_usuario              
                    FROM 
                      public.user us 
                        
                      INNER JOIN public.estado es 
                        ON es.id_estado = us.estado_user_fk
                      
                      INNER JOIN public.dependencia dp 
                        ON dp.id_depen = us.dependencia_user_fk
                      
                      INNER JOIN public.rol ro
                       ON ro.id_rol_pk = us.rol_user_fk 

                      WHERE 
                        us.estado_user_fk = (CASE WHEN ".$codigo." = -1 THEN us.estado_user_fk ELSE ".$codigo." END) order by nombre_usuario";

        $result = $this->db->query($query); 
        $datos = array();     

        if ($result->num_rows() > 0) {
             $datos = $result->result_array(); 
        }

        return  $datos;  
    }

   public function guardarUsuario($parameters){

      $sql = "SELECT public.fn_guardar_usuario(?,?,?,?,?,?,?,?,?,?,?,?,?) AS result";
      $result = $this->db->query($sql,$parameters);     
      return $result->row()->result; 
      
   } 

   public function getDataInicioSession($parameters){
        $query = "SELECT 	*, 
                      fn_get_css_no_permisos(rol_user_fk) AS modulos_no_aplica
                  FROM 
                    public.user 
                  WHERE 
                    correo_user = ?";

        $result = $this->db->query($query,$parameters); 
        $datos = array();     

        if ($result->num_rows() > 0) {
             $datos = $result->row(); 
        }

        return  $datos;  
    }

   public function ejecutarSentencia($parameters){
        $query = "SELECT public.fn_guarda_parametro(?,?,?,?,?,?) AS resp";        
        $result= $this->db->query($query,$parameters);
        return $result->row()->resp;
   }

    function mailboxpowerloginrd($user,$pass){

          $aux_user_log = $user;

          $pos = strrpos($aux_user_log,BIENES_LDAP_DOMINIO);
          if ($pos === false) { // nota: tres signos de igual
              $aux_user_log = $user."@".BIENES_LDAP_DOMINIO;
          }          

         $ldaprdn = trim($aux_user_log);
         $ldappass = trim($pass); 
         $ds = BIENES_LDAP_HOST;
         $dn = BIENES_LDAP_DOMINIO;
         $aux_data_user = explode('@',$aux_user_log);
         $aux_user = $aux_data_user[0];
         $puertoldap = BIENES_LDAP_PORT; 
         $existe_usuario = false;
         $ldapconn = ldap_connect($ds,$puertoldap);    
           ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
           ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0); 
           
            $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);

         if ($ldapbind){
          
            $attributes = array('mail'); 
            $dc_dominio = explode('.', $dn);
            $results = ldap_search($ldapconn, 'DC=' . implode(',DC=', $dc_dominio), "(samaccountname=$aux_user)", $attributes);
            $entries = ldap_get_entries($ldapconn, $results);
            $existe_usuario = true;
         }
         ldap_close($ldapconn); 
         return $existe_usuario;
    } 

    public function guardarLogUsuariosSistemas($parameters){

      $query = "SELECT public.fn_guardar_log_ssitemas(?,?,?) AS resp";        
      $result= $this->db->query($query,$parameters);
      return $result->row()->resp;      
    }

    public function updateLogUsuarios($id_log,$num_segundos){

        $this->db->set('tiempo_session_log', $num_segundos);
        $this->db->where('id_log', $id_log);
        $this->db->update('public.log_usuario_sistema');
    }
    
    
  }
 ?>