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
        $sql = "SELECT public.fn_set_reporte_irregular_predio(?,?,?,?,?,?,?,?,?,?,?,?,?) AS result";
        $result = $this->db->query($sql,$parameters);
        $ress = $result->row()->result;    
        return $ress;
    }

    public function getPoligonoCordenadas($codPredio){
        $ress = array();
        $query =  "SELECT 
                        st_astext(st_transform(pred.the_geom, 6249)) AS coordenadas
                    FROM 
                        geo_predio_mc pred
                        LEFT JOIN terreno terr ON pred.id_shp = terr.id_shp_p
                    WHERE
                        terr.identifica_p = '".$codPredio."'";
        $result = $this->db->query($query);        

        if ($result->num_rows() > 0) {
            $datos = $result->result();
            $ress = $datos[0]->coordenadas;
        }
        
        return $ress;
    }

}

?>