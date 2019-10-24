<?php

class Reporte_irregular_model extends CI_Model{
  	
    public function __construct() {
        parent::__construct(); 
    }

    public function traerReporteIrregular_data($parameters){
        $sql = "SELECT public.fn_get_reporte_irregular_predio(?) AS result";
        $result = $this->db->query($sql,$parameters);
        $ress = json_decode($result->row()->result, true);    
        return $ress;        
    }

    public function guardarReporteIrregular_data($parameters){
        $sql = "SELECT public.fn_set_reporte_irregular_predio(?,?,?,?,?,?,?,?,?,?,?) AS result";
        $result = $this->db->query($sql,$parameters);
        $ress = $result->row()->result;    
        return $ress;
    }

}

?>