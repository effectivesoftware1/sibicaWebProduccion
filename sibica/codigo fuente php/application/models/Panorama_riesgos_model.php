<?php 

    class Panorama_riesgos_model extends CI_Model{
    
        public function __construct() {
            parent::__construct(); 
        } 


       public function getData($codigo_panorama){

            $sql = "SELECT 
                        pr.*,
                        e.nombre_estado as nombre_estado,
                        concat(us.primer_nombre_user,' ',us.segundo_nombre_user,' ',us.primer_apellido_user,' ',us.segundo_apellido_user) AS inspector,
                        fi.ruta_file as ruta_file,
                        fi.nombre_file as nombre_file,
                        COALESCE(cons.nombre_const,'') as nom_edificacion,
                        cons.predialterreno_const_fk as codigo_terreno,
                        cons.predial_edificacion_const as codigo_construccion

                    FROM 
                        public.panorama_riesgo pr 
                        
                        INNER JOIN public.estado e 
                         ON e.id_estado = pr.estado_pr_fk

                        INNER JOIN public.construccion cons
                         ON cons.id_const = pr.construcion_pr_fk

                        INNER JOIN public.user us
                         ON us.id_user_pk = pr.usuario_crea_fk                  

                        LEFT JOIN public.file fi
                        ON fi.id_file = pr.imagen_pr_fk

                        WHERE 
                          pr.id_panorama = (CASE WHEN $codigo_panorama = -1 THEN pr.id_panorama ELSE $codigo_panorama END)                          
                            
                        ORDER BY pr.fecha_creacion DESC";

            $result = $this->db->query($sql);
            return $result->result();
            
        }

        public function getDataFecha($p_fecha_inicial,$p_fecha_final){            
            
            $sql = "SELECT 
                        pr.*,
                        e.nombre_estado as nombre_estado,
                        concat(us.primer_nombre_user,' ',us.segundo_nombre_user,' ',us.primer_apellido_user,' ',us.segundo_apellido_user) AS inspector,
                        fi.ruta_file as ruta_file,
                        fi.nombre_file as nombre_file,
                        COALESCE(cons.nombre_const,'') as nom_edificacion,
                        cons.predialterreno_const_fk as codigo_terreno,
                        cons.predial_edificacion_const as codigo_construccion

                    FROM 
                        public.panorama_riesgo pr 
                        
                        INNER JOIN public.estado e 
                         ON e.id_estado = pr.estado_pr_fk

                        INNER JOIN public.construccion cons
                         ON cons.id_const = pr.construcion_pr_fk

                        INNER JOIN public.user us
                         ON us.id_user_pk = pr.usuario_crea_fk                  

                        LEFT JOIN public.file fi
                        ON fi.id_file = pr.imagen_pr_fk

                        WHERE 
                          pr.fecha_creacion >=  ? AND pr.fecha_creacion <= ? 
                           
                        ORDER BY pr.fecha_creacion DESC";

            $result = $this->db->query($sql,array('fecha_ini' => $p_fecha_inicial, 'fecha_fi' => $p_fecha_final));
            return $result->result();
            
        }  

        public function guardarPanorama($parameters){
            $query = "SELECT public.fn_guardar_panorama(?,?,?,?,?,?,?,?,?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        public function llamarTareaPanorama_data($objParam){
            $query = "SELECT public.fn_get_tarea_panorama(?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);           
            
            return $retorno;            
        }

        public function llamarSeguimientoTarea_data($objParam){
            $query = "SELECT public.fn_get_seguimiento_tarea(?,?) AS resp";        
            $result= $this->db->query($query,$objParam);
            $retorno = json_decode($result->row()->resp, true);

            return $retorno;            
        }

        public function getDatosPredio($id_predio,$codigo_predio_const){
            $sql = " SELECT 
                          COALESCE(id_depen_fk,0) as depencia, 
                          COALESCE(direccion_const,'') as direccion, 
                          COALESCE(nombre_const,'') as nombre,
                          extract(year from now()) as anio, 
                          (SELECT nextval('public.panorama_riesgos_id_seq')) as secuencia,
                          (SELECT id_estado FROM public.estado WHERE id_estado = 8) as codigo_estado,
                          (SELECT nombre_estado FROM public.estado WHERE id_estado = 8) as nombre_estado
                          
                        FROM 
                          public.construccion
                        WHERE
                          predialterreno_const_fk = ?
                          AND predial_edificacion_const = ?";
            $result = $this->db->query($sql,array('codigo' => $id_predio,'codigo_predio_const' => $codigo_predio_const));

            return $result->row();
        }

        public function guardarSeguimientoTarea($parameters){
            $query = "SELECT public.fn_guardar_seg_tarea(?,?,?,?,?,?,?,?) AS resp";        
            $result = $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        public function guardarTareaPanorama_data($parameters){
            $query = "SELECT public.fn_guardar_tarea_panorama(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) AS resp";        
            $result= $this->db->query($query,$parameters);
            return $result->row()->resp;
        }

        public function traerClasificanionRiesgo(){
            $query = "SELECT * FROM public.clasificacion_panorama ORDER BY id_clasificacion";        
            $result= $this->db->query($query);
            return $result->result();
        }

        public function validPanorama($objParam){
            $query = "SELECT count(*) AS resp FROM public.panorama_riesgo WHERE id_panorama = ".$objParam['codPanorama'];        
            $result= $this->db->query($query);
            $ress = $result->result();
            //var_dump($ress[0]->resp); 
            return intval($ress[0]->resp);
        }

        public function existePanorama($id_predio,$codigo_predio_const){            
            
            $sql = "SELECT 
                        MAX(pr.id_panorama) as codigo_panorama
                    FROM 
                        public.panorama_riesgo pr 

                        INNER JOIN public.construccion cons
                         ON cons.id_const = pr.construcion_pr_fk

                        WHERE 
                          cons.predialterreno_const_fk = ?
                          AND cons.predial_edificacion_const = ? 
                          AND pr.estado_pr_fk <> 9 ";  

            $result = $this->db->query($sql,array('id_predio' => $id_predio, 'codigo_predio_const' => $codigo_predio_const));
            
            if ($result->num_rows() > 0) {
                return $result->row()->codigo_panorama;
            }else{
                return false;
            }             
            
        }

        public function guardarTipoRiesgo($parametros){

            $sql = "insert into public.tipo_riesgo(nombre_tipo_riesgo,estado_tp_fk) values(?,?)";

            $query = $this->db->query($sql,$parametros);
            return $query;
        }

        /*public function llamarObservacionVisita_data($objParam){
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
        }*/

        public function reportResumenPanorama(){

            $sql = "SELECT
                      cp.nombre_clasificacion as clasificacion,
                      COUNT(pr.construcion_pr_fk) as numero_predio
                    FROM 
                      public.tarea_panorama_pr tp
                      
                      INNER JOIN public.panorama_riesgo pr
                       ON pr.id_panorama = tp.panorama_tp_fk
                      
                      INNER JOIN public.clasificacion_panorama cp
                       ON cp.id_clasificacion = tp.clasificacion_tp_fk
                       
                     /*WHERE 
                          pr.fecha_creacion >= (CASE WHEN p_fecha_inicial IS NULL THEN pr.fecha_creacion ELSE p_fecha_inicial END) AND pr.fecha_creacion <= (CASE WHEN p_fecha_final IS NULL THEN pr.fecha_creacion ELSE p_fecha_final END)*/
                     GROUP BY  cp.nombre_clasificacion";

            $result = $this->db->query($sql);

            return $result->result();
        }

         public function reportGenealPanorama(){

            $sql = "SELECT   
                      cp.nombre_clasificacion as clasificacion,
                      cons.predialterreno_const_fk }as num_terreno,
                      ba.barrio as barrio,
                      ba.comuna as comuna,
                      to_char(pr.fecha_creacion,'dd/mm/yyyy') as fecha_panorama
                      
                     
                    FROM 
                      public.tarea_panorama_pr tp
                      
                      INNER JOIN public.panorama_riesgo pr
                       ON pr.id_panorama = tp.panorama_tp_fk
                      
                      INNER JOIN public.construccion cons
                       ON cons.id_const = pr.construcion_pr_fk
                      
                      INNER JOIN public.terreno ter
                       ON ter.identifica_p = cons.predialterreno_const_fk    
                      
                      INNER JOIN public.clasificacion_panorama cp
                       ON cp.id_clasificacion = tp.clasificacion_tp_fk
                      
                      LEFT JOIN public.barrios ba
                       ON ba.id_barrio = ter.id_barrio  
                       
                       /*WHERE 
                          pr.fecha_creacion >= (CASE WHEN p_fecha_inicial IS NULL THEN pr.fecha_creacion ELSE p_fecha_inicial END) AND pr.fecha_creacion <= (CASE WHEN p_fecha_final IS NULL THEN pr.fecha_creacion ELSE p_fecha_final END)*/
                      ";


                $result = $this->db->query($sql);
                return $result->result();            
        }

    }
 ?>


