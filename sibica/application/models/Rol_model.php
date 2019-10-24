<?php 

    class Rol_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        } 

       public function getDataRol(){
            
            $query = $this->db->query("SELECT r.*,e.nombre_estado as nombre_estado FROM public.rol r INNER JOIN public.estado e ON e.id_estado = r.estado_rol_fk WHERE id_rol_pk >= 0  order by r.nombre_rol");
            return $query->result();
            
        } 

        public function ejecutarSentencia($parameters){
            $query = "SELECT public.fn_guarda_parametro_rol(?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        public function traerPermisosRol_data($parameters){
            $query = "SELECT * FROM public.fn_get_permisos_rol(?) ";        
            $result = $this->db->query($query,$parameters);

            if ($result->num_rows() > 0) {
                return $result->result(); 
            }else{
                return array();
            }
        }

        public function guardarPermisosRol_data($parameters){
            $query = "SELECT public.guardar_permisos_rol(?,?,?,?,?,?,?,?,?) AS resp";        
            $result = $this->db->query($query, $parameters);
           
            return $result->row()->resp; 
        }

        public function guardarPermisosRolCampo_data($parameters){
            $query = "SELECT public.guardar_permisos_rol_campos(?,?,?) AS resp";        
            $result = $this->db->query($query, $parameters);

            return $result->row()->resp; 
        }

        public function EliminarPermisosRolCampo_data($codModuloPermiso){
            $query = "DELETE FROM public.modulo_permiso_campo WHERE modulo_permiso_fk = ".$codModuloPermiso;        
            $result = $this->db->query($query);

            return $result; 
        }

        
    }
 ?>