<?php

class Map_arcgis_model extends CI_Model{
  	
    public function __construct() {
        parent::__construct(); 
    }

    public function getPredios(){
        $ress = array();
        $query =  "SELECT 
                        pred.gid,
                        terr.nombre_areacedida_p AS nombre,
                        COALESCE(terr.direccion_p, '') AS direccion, 
                        COALESCE(tb.nombre_tb, '') AS nombre_tb, 
                        COALESCE(terr.identifica_p, '') AS predial, 
                        COALESCE(terr.nombrecomun_p, '') AS nombre_comun, 
                        COALESCE(ct.predial_edificacion_const, '') AS predial2, 
                        COALESCE(terr.mat_inmob_p, '') AS matricula,
                        CASE cp.id_capa
                            WHEN 1 THEN '#FF0000'
                            WHEN 2 THEN '#FF8000'
                            WHEN 3 THEN '#800080'
                            WHEN 4 THEN '#FFFF00'
                            WHEN 5 THEN '#6A6A6A'
                            WHEN 6 THEN '#00FF00'
                            WHEN 7 THEN '#FA045D'
                        END AS id_capa,
                        REPLACE(TO_CHAR(ST_X(ST_CENTROID((ST_DumpPoints(st_astext(st_transform(pred.the_geom, 4326)))).geom)), '99D9999999999'), ',', '.') AS lng,
                        REPLACE(TO_CHAR(ST_Y(ST_CENTROID((ST_DumpPoints(st_astext(st_transform(pred.the_geom, 4326)))).geom)), '99D9999999999'), ',', '.') AS lat
                    FROM 
                        geo_predio_mc pred
                        LEFT JOIN terreno terr ON pred.id_shp = terr.id_shp_p
                        LEFT JOIN tipo_bien tb ON tb.id_tb = terr.id_tb_fk
                        LEFT JOIN construccion ct ON ct.predialterreno_const_fk = terr.identifica_p
                        LEFT JOIN capa cp ON cp.id_capa = terr.id_capa
                    LIMIT 10000";
        $result = $this->db->query($query);        

        if ($result->num_rows() > 0) {
            $ress = $result->result(); 
        }
        
        return $ress;
    }

    public function getConstrucion(){
        $ress = array();
        $query =  "SELECT 
                        const.gid AS gid,
                        capa.nombre_capa AS nombre,
                        REPLACE(TO_CHAR(ST_X(ST_CENTROID((ST_DumpPoints(st_astext(st_transform(const.the_geom, 4326)))).geom)), '99D9999999999'), ',', '.') AS lng,
                        REPLACE(TO_CHAR(ST_Y(ST_CENTROID((ST_DumpPoints(st_astext(st_transform(const.the_geom, 4326)))).geom)), '99D9999999999'), ',', '.') AS lat
                    FROM 
                        geo_constr_mc const
                        LEFT JOIN capa capa ON const.id_tipo_const = capa.id_capa";
        $result = $this->db->query($query);        

        if ($result->num_rows() > 0) {
            $ress = $result->result(); 
        }
        
        return $ress;
    }

    public function getCategorias(){
        $this->db->select('*');
        $this->db->from('multi.multi_categoria');
        $this->db->where('fk_estado', 1);
        $this->db->where('pk_id !=', 0);
        $consulta = $this->db->get();
        
        return $consulta->result();
    }

}

?>