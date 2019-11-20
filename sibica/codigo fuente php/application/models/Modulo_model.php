<?php 

    class Modulo_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        } 

       public function getData(){
            
            $query = $this->db->query("SELECT * FROM public.modulo  ORDER BY nombre_mod");
            return $query->result();
            
        } 

        public function ejecutarSentencia($parameters){
            $query = "SELECT public.fn_guarda_parametro(?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        
    }
 ?>