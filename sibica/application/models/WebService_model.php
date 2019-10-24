<?php

class WebService_model extends CI_Model{
  	
    public function __construct() {
        parent::__construct(); 
    }

    public function delteUsuariosDummy(){ 

        $query = "SELECT multi.fn_delete_user_dummy";
        $result = $this->db->query($query); 
       
        return $result->result(); 
    }

}

?>