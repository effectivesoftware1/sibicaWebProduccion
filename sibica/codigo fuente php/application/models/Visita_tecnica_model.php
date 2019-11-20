<?php 

    class Visita_tecnica_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        } 


       public function getData($codigo_visita){

            $sql = "SELECT 
                        vt.*,                        
                        concat(us.primer_nombre_user,' ',us.segundo_nombre_user,' ',us.primer_apellido_user,' ',us.segundo_apellido_user) AS inspector,
                        fi.ruta_file as ruta_file,
                        fi.nombre_file as nombre_file,
                        --public.fn_get_contratos_visita(vt.id_vt) as contratos,
                        ci.nombre_ci as calidad_inmueble,
                        tv.nombre_tv as tipo_visita,
                        to_char(vt.fecha_inicio_vt,'dd/mm/yyyy') as fecha_inspeccion                         

                    FROM 
                        public.visita_tecnica vt 

                        /*INNER JOIN public.terreno ter
                         ON ter.identifica_p = vt.terreno_vt_fk*/

                        INNER JOIN public.user us
                         ON us.id_user_pk = vt.user_vt_fk

                        INNER JOIN public.calidad_inmueble ci
                         ON ci.id_ci = vt.calidad_inmueble_vt_fk

                        INNER JOIN public.tipo_visita tv
                         ON tv.id_tv = vt.tv_vt_fk                   

                        LEFT JOIN public.file fi
                        ON fi.id_file = vt.file_vt_fk

                        WHERE 
                          vt.id_vt = (CASE WHEN $codigo_visita = -1 THEN vt.id_vt  ELSE $codigo_visita END)                          
                            
                        ORDER BY vt.fecha_inicio_vt DESC";

            $result = $this->db->query($sql);
            return $result->result();
            
        }        

        public function guardarVisitaTecn($parameters){

            $query = "SELECT public.fn_guardar_visita_tecnica(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
            
        }

        public function getDatosPredio($id_predio,$codigo_predio_const){
             /*$sql = " SELECT                           
                          COALESCE(direccion_const,'') as direccion, 
                          COALESCE(nombre_const,'') as nombre,                          
                          (SELECT nextval('public.visita_tecnica_id_vt_seq')) as sec_vist
                          
                        FROM 
                          public.construccion
                        WHERE
                          predialterreno_const_fk = ?
                          AND predial_edificacion_const = ?";
            $result = $this->db->query($sql,array('codigo' => $id_predio,'codigo_predio_const' => $codigo_predio_const));
            */
            $sql = " SELECT COALESCE(direccion_p,'') as direccion,
                            COALESCE(nombre_areacedida_p,'') as nombre,
                            (SELECT nextval('public.visita_tecnica_id_vt_seq')) as sec_vist
                        FROM
                            public.terreno
                        WHERE
                            identifica_p = ?";
            $result = $this->db->query($sql,array('codigo' => $id_predio));

            return $result->row();

        }

        public function llamarObservacionVisita_data($objParam){
            $query = "SELECT public.fn_get_observacion_visita(?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);

            return $retorno;
        }

        public function guardarObservacionVisita_data($objParam){
            $query = "SELECT public.fn_set_observacion_visita(?,?,?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);

            return $retorno;
        }

        public function guardarObservacionVisitaFile_data($objParam){
            $query = "SELECT public.fn_set_observacion_visita_file(?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);

            return $retorno;
        }

        public function getContratoVisita($codigo_visita){

            $sql = "Select * from public.contrato_visita where  vt_cv_fk = ?";
            $query = $this->db->query($sql,array('codigo_visita' => $codigo_visita));
            return $query->result();
        }

        public function saveContratoVisita($objParam){

            $query = "SELECT public.fn_guardar_contrato_visita(?,?,?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);

            return $retorno;
            
        }

         public function getDataFecha($p_fecha_inicial,$p_fecha_final){            
            
            $sql = "SELECT 
                        vt.*,                        
                        concat(us.primer_nombre_user,' ',us.segundo_nombre_user,' ',us.primer_apellido_user,' ',us.segundo_apellido_user) AS inspector,
                        fi.ruta_file as ruta_file,
                        fi.nombre_file as nombre_file,
                        --public.fn_get_contratos_visita(vt.id_vt) as contratos,
                        ci.nombre_ci as calidad_inmueble,
                        tv.nombre_tv as tipo_visita,
                        to_char(vt.fecha_inicio_vt,'dd/mm/yyyy') as fecha_inspeccion                        

                    FROM 
                        public.visita_tecnica vt 

                        /*INNER JOIN public.terreno ter
                         ON ter.identifica_p = vt.terreno_vt_fk*/

                        INNER JOIN public.user us
                         ON us.id_user_pk = vt.user_vt_fk 

                        INNER JOIN public.calidad_inmueble ci
                         ON ci.id_ci = vt.calidad_inmueble_vt_fk

                        INNER JOIN public.tipo_visita tv
                         ON tv.id_tv = vt.tv_vt_fk                 

                        LEFT JOIN public.file fi
                        ON fi.id_file = vt.file_vt_fk

                        WHERE 
                          vt.fecha_inicio_vt >=  ? AND vt.fecha_inicio_vt <= ? 
                           
                        ORDER BY vt.fecha_inicio_vt DESC";

            $result = $this->db->query($sql,array('fecha_ini' => $p_fecha_inicial, 'fecha_fi' => $p_fecha_final));
            return $result->result();
            
        }         

        public function guardarObservacionVisitapersona_data($objParam){
            $query = "SELECT public.fn_set_observacion_visita_persona(?,?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);

            return $retorno;
        }

        public function ejecutarSentencia($parameters){
            $query = "SELECT public.fn_guarda_parametro(?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        public function getDataExcel($codigo_visita){

            $sql = "SELECT                  
                        (CASE WHEN ter.id_cb_fk = 1 THEN 'X' ELSE '' END) as calidad_in_pu,
                        (CASE WHEN ter.id_cb_fk = 2 THEN 'X' ELSE '' END) as calidad_in_fiscal,
                        vt.objetivo_vt as objetivo,
                        to_char(vt.fecha_inicio_vt,'HH12:MI AM') as fecha_inicio,
                        to_char(vt.fecha_fin_vt,'HH12:MI AM') as fecha_fin,
                        to_char(vt.fecha_fin_vt,'dd/mm/yyyy') as fecha_visita,
                        COALESCE(ter.direccion_p,'') as direccion,                        
                        COALESCE(barrio.barrio,'') as barrio,
                        barrio.comuna as comuna,
                        (CASE WHEN vt.tv_vt_fk = 1 THEN 'X' ELSE '' END) as tip_vis_7,
                        (CASE WHEN vt.tv_vt_fk = 2 THEN 'X' ELSE '' END) as tip_vis_1,
                        (CASE WHEN vt.tv_vt_fk = 3 THEN 'X' ELSE '' END) as tip_vis_2,
                        (CASE WHEN vt.tv_vt_fk = 4 THEN 'X' ELSE '' END) as tip_vis_3,
                        (CASE WHEN vt.tv_vt_fk = 5 THEN 'X' ELSE '' END) as tip_vis_4,
                        (CASE WHEN vt.tv_vt_fk = 6 THEN 'X' ELSE '' END) as tip_vis_5,
                        (CASE WHEN vt.tv_vt_fk = 7 THEN 'X' ELSE '' END) as tip_vis_6,
                        (CASE WHEN vt.tv_vt_fk = 8 THEN 'X' ELSE '' END) as tip_vis_8,
                        vt.terreno_vt_fk AS num_predial,
                        COALESCE(cb.nombre_cb,'') as nom_calidad_bien,
                        COALESCE(ter.mat_inmob_p,'') as num_matricula,
                        '810 DE 1981/10/30' as ep,
                         COALESCE(ter.nombre_areacedida_p,'') as nombre_terreno,
                         COALESCE(tipb.nombre_tb,'') as nom_tipo_bien,
                         COALESCE(usop.nombre_tu,'') as nom_uso,
                         COALESCE(proy.nombre_pro,'') as nom_proyect,
                         fi.ruta_file as ruta_img_visita

                    FROM 
                        public.visita_tecnica vt

                        INNER JOIN public.terreno ter
                         ON ter.identifica_p = vt.terreno_vt_fk

                        LEFT JOIN public.calidad_bien cb
                         ON cb.id_cb = ter.id_cb_fk 

                        LEFT JOIN public.barrios barrio
                         ON barrio.id_barrio = ter.id_barrio

                        LEFT JOIN public.tipo_bien tipb 
                         ON tipb.id_tb = ter.id_tb_fk

                        LEFT JOIN public.uso_predio usop 
                         ON usop.id_tu = ter.id_tu_fk

                        LEFT JOIN public.proyecto proy 
                         ON proy.id_pro = ter.id_proyecto_p 
                        
                        LEFT JOIN public.file fi
                        ON fi.id_file = vt.file_vt_fk

                        WHERE 
                          vt.id_vt = ?";                         

            $result = $this->db->query($sql,array('codigo_visita' => $codigo_visita));
            return $result->row();
            
        }        
        

    }
 ?>


