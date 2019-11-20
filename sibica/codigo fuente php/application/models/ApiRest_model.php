<?php

class ApiRest_model extends CI_Model{
  	
    public function __construct() {
        parent::__construct(); 
        $this->load->model('Utilidades_model');
    }

    public function get(){

      $query = $this->db->get('multi.multi_prueba_ang');
      return $query->result();
        
    } 

    public function get_one($codigo){

      $this->db->select('*');
      $this->db->where('pk_id =', $codigo);
      $this->db->from('multi.multi_prueba_ang');     

      return $this->db->get()->row();             
    }   

    public function add($datos){ 

     $result = $this->db->insert('multi.multi_prueba_ang', $datos);

     return $result;     
        
    }


    public function update($codigo,$data){
       
      $this->db->where('pk_id', $codigo);
      $result = $this->db->update('multi.multi_prueba_ang', $data); 

      return  $result;     
        
    }

    public function put($codigo){

       $this->db->where('pk_id', $codigo);
       result = $this->db->delete('multi.multi_prueba_ang');

       return  $result; 
    }    
    
}

?>