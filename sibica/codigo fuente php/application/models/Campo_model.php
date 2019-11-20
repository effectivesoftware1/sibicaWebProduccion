<?php 

    class Campo_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        }


        public function getDataCampos(){

            $consulta = "SELECT nombre_campo,nombre_tbl  FROM public.campo ca INNER JOIN public.tabla ta ON ta.id_tbl_pk = ca.tabla_campo_fk ORDER BY nombre_tbl";           
     
            $result = $this->db->query($consulta);
            return $result->result();
            
        }  

       public function getDataCamposChema($tabla){

            $consulta = "SELECT column_name  FROM information_schema.columns WHERE table_schema = 'public' AND table_name   = ? ORDER BY column_name";           
     
            $result = $this->db->query($consulta,array('tabla' =>$tabla));
            return $result->result();
            
        } 

        public function saveCampos($parameters){
            $query = "SELECT public.fn_guardar_campos(?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }
        
    }
 ?>


