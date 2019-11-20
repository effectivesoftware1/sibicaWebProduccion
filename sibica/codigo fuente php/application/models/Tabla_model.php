<?php 

    class Tabla_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        } 

       public function getData(){
            
            $query = $this->db->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
            return $query->result();
            
        } 

        public function saveTablas($parameters){
            $query = "SELECT public.fn_guardar_tablas(?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        public function getDatosTablas(){
            
            $query = $this->db->query("SELECT nombre_tbl as tablename FROM public.tabla ORDER BY tablename");
            return $query->result();
            
        } 

        
    }
 ?>


