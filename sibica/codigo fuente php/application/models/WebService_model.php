<?php

class WebService_model extends CI_Model{
    
    public function __construct() {
        parent::__construct(); 
    }


    public function validTareasVencidasResponsable($numero_dias){

        $sql = "SELECT
                 DISTINCT
                 pr.id_panorama as cod_panorama,
                 pr.correo_responsable_panorama as correo

                FROM                
                public.tarea_panorama_pr tp

                INNER JOIN public.panorama_riesgo pr
                 ON pr.id_panorama = tp.panorama_tp_fk              

                WHERE

                 tp.fecha_vence_tp  = (SELECT CAST(now() AS DATE) + CAST('".$numero_dias." days' AS INTERVAL))";


        $result = $this->db->query($sql);
        return $result->result();
                
    }

     public function validTareasVencidasEjecutor($numero_dias){

        $sql = "SELECT
                 DISTINCT
                 pr.id_panorama as cod_panorama,               
                 ter.direccion_p as direccion_terreno,
                 ter.nombre_areacedida_p as nombre_terreno

                FROM                
                public.tarea_panorama_pr tp

                INNER JOIN public.panorama_riesgo pr
                 ON pr.id_panorama = tp.panorama_tp_fk

                INNER JOIN public.construccion cons
                 ON  pr.construcion_pr_fk = cons.id_const 

                INNER JOIN public.terreno ter
                 ON ter.identifica_p = cons.predialterreno_const_fk

                WHERE

                 tp.fecha_vence_tp  = (SELECT CAST(now() AS DATE) - CAST('".$numero_dias." days' AS INTERVAL))";


        $result = $this->db->query($sql);
        return $result->result();
                
    }



}

?>














