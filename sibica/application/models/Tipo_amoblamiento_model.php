<?php 

    class Tipo_amoblamiento_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        } 

       public function getData(){
            
            $query = $this->db->query("SELECT r.*,e.nombre_estado as nombre_estado, fi.ruta_file as ruta_file,nombre_file as nombre_file FROM public.tipo_amoblamiento r INNER JOIN public.estado e ON e.id_estado = r.estado_ta_fk left join public.file fi ON fi.id_file = r.icono_ta_fk order by r.nombre_ta");
            return $query->result();
            
        } 

        public function ejecutarSentencia($parameters){
            $query = "SELECT public.fn_guardar_tipo_amoblamiento(?,?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }


        
    }
 ?>