<?php

class Home_model extends CI_Model{
  	
    public function __construct() {
        parent::__construct(); 
    }

    public function traerInfoPredio_data($objParam){            
        $sql = "SELECT
                    fn_get_dato_permiso_campo (id_p::TEXT ,".$objParam['codRol'].",'id_p','terreno') AS id_p,
                    fn_get_dato_permiso_campo (cedula_ppal_p::TEXT ,".$objParam['codRol'].",'cedula_ppal_p','terreno') AS cedula_ppal_p,
                    fn_get_dato_permiso_campo (id_catastro_p::TEXT ,".$objParam['codRol'].",'id_catastro_p','terreno') AS id_catastro_p,
                    fn_get_dato_permiso_campo (nupre_p::TEXT ,".$objParam['codRol'].",'nupre_p','terreno') AS nupre_p,
                    fn_get_dato_permiso_campo (dv_p::TEXT ,".$objParam['codRol'].",'dv_p','terreno') AS dv_p,
                    fn_get_dato_permiso_campo (codigonal_p::TEXT ,".$objParam['codRol'].",'codigonal_p','terreno') AS codigonal_p,
                    fn_get_dato_permiso_campo (codigounico_p::TEXT ,".$objParam['codRol'].",'codigounico_p','terreno') AS codigounico_p,
                    fn_get_dato_permiso_campo (identifica_p::TEXT ,".$objParam['codRol'].",'identifica_p','terreno') AS identifica_p,
                    fn_get_dato_permiso_campo (id_proyecto_p::TEXT ,".$objParam['codRol'].",'id_proyecto_p','terreno') AS id_proyecto_p,
                    fn_get_dato_permiso_campo (clase_inmueble_p::TEXT ,".$objParam['codRol'].",'clase_inmueble_p','terreno') AS clase_inmueble_p,
                    fn_get_dato_permiso_campo (id_cb_fk::TEXT ,".$objParam['codRol'].",'id_cb_fk','terreno') AS id_cb_fk,
                    fn_get_dato_permiso_campo (id_tb_fk::TEXT ,".$objParam['codRol'].",'id_tb_fk','terreno') AS id_tb_fk,
                    fn_get_dato_permiso_campo (id_tu_fk::TEXT ,".$objParam['codRol'].",'id_tu_fk','terreno') AS id_tu_fk,
                    fn_get_dato_permiso_campo (direccion_p::TEXT ,".$objParam['codRol'].",'direccion_p','terreno') AS direccion_p,
                    fn_get_dato_permiso_campo (direccioncatastro_p::TEXT ,".$objParam['codRol'].",'direccioncatastro_p','terreno') AS direccioncatastro_p,
                    fn_get_dato_permiso_campo (zona_p::TEXT ,".$objParam['codRol'].",'zona_p','terreno') AS zona_p,
                    fn_get_dato_permiso_campo (id_barrio::TEXT ,".$objParam['codRol'].",'id_barrio','terreno') AS id_barrio,
                    fn_get_dato_permiso_campo (pais_p::TEXT ,".$objParam['codRol'].",'pais_p','terreno') AS pais_p,
                    fn_get_dato_permiso_campo (ciudad_p::TEXT ,".$objParam['codRol'].",'ciudad_p','terreno') AS ciudad_p,
                    fn_get_dato_permiso_campo (lind_norte_p::TEXT ,".$objParam['codRol'].",'lind_norte_p','terreno') AS lind_norte_p,
                    fn_get_dato_permiso_campo (lind_sur_p::TEXT ,".$objParam['codRol'].",'lind_sur_p','terreno') AS lind_sur_p,
                    fn_get_dato_permiso_campo (lind_este_p::TEXT ,".$objParam['codRol'].",'lind_este_p','terreno') AS lind_este_p,
                    fn_get_dato_permiso_campo (lind_oeste_p::TEXT ,".$objParam['codRol'].",'lind_oeste_p','terreno') AS lind_oeste_p,
                    fn_get_dato_permiso_campo (lind_adic_p::TEXT ,".$objParam['codRol'].",'lind_adic_p','terreno') AS lind_adic_p,
                    fn_get_dato_permiso_campo (matricula_ppal_p::TEXT ,".$objParam['codRol'].",'matricula_ppal_p','terreno') AS matricula_ppal_p,
                    fn_get_dato_permiso_campo (mat_inmob_p::TEXT ,".$objParam['codRol'].",'mat_inmob_p','terreno') AS mat_inmob_p,
                    fn_get_dato_permiso_campo (id_madq_fk::TEXT ,".$objParam['codRol'].",'id_madq_fk','terreno') AS id_madq_fk,
                    fn_get_dato_permiso_campo (nombre_areacedida_p::TEXT ,".$objParam['codRol'].",'nombre_areacedida_p','terreno') AS nombre_areacedida_p,
                    fn_get_dato_permiso_campo (nit_cede_fk::TEXT ,".$objParam['codRol'].",'nit_cede_fk','terreno') AS nit_cede_fk,
                    fn_get_dato_permiso_campo (derecho_p::TEXT ,".$objParam['codRol'].",'derecho_p','terreno') AS derecho_p,
                    fn_get_dato_permiso_campo (afecta_pot_p::TEXT ,".$objParam['codRol'].",'afecta_pot_p','terreno') AS afecta_pot_p,
                    fn_get_dato_permiso_campo (asegurado_p::TEXT ,".$objParam['codRol'].",'asegurado_p','terreno') AS asegurado_p,
                    fn_get_dato_permiso_campo (suscep_vta_p::TEXT ,".$objParam['codRol'].",'suscep_vta_p','terreno') AS suscep_vta_p,
                    fn_get_dato_permiso_campo (id_depen_fk::TEXT ,".$objParam['codRol'].",'id_depen_fk','terreno') AS id_depen_fk,
                    fn_get_dato_permiso_campo (nombrecomun_p::TEXT ,".$objParam['codRol'].",'nombrecomun_p','terreno') AS nombrecomun_p,
                    fn_get_dato_permiso_campo (area_cesion_p::TEXT ,".$objParam['codRol'].",'area_cesion_p','terreno') AS area_cesion_p,
                    fn_get_dato_permiso_campo (area_actual_p::TEXT ,".$objParam['codRol'].",'area_actual_p','terreno') AS area_actual_p,
                    fn_get_dato_permiso_campo (area_sicat_p::TEXT ,".$objParam['codRol'].",'area_sicat_p','terreno') AS area_sicat_p,
                    fn_get_dato_permiso_campo (area_terreno_p::TEXT ,".$objParam['codRol'].",'area_terreno_p','terreno') AS area_terreno_p,
                    fn_get_dato_permiso_campo (fecha_estudio_titulo_p::TEXT ,".$objParam['codRol'].",'fecha_estudio_titulo_p','terreno') AS fecha_estudio_titulo_p,
                    fn_get_dato_permiso_campo (num_activofijo_p::TEXT ,".$objParam['codRol'].",'num_activofijo_p','terreno') AS num_activofijo_p,
                    fn_get_dato_permiso_campo (codigo_zhg_p::TEXT ,".$objParam['codRol'].",'codigo_zhg_p','terreno') AS codigo_zhg_p,
                    fn_get_dato_permiso_campo (cuenta_terreno_p::TEXT ,".$objParam['codRol'].",'cuenta_terreno_p','terreno') AS cuenta_terreno_p,
                    fn_get_dato_permiso_campo (propietario_antes_p::TEXT ,".$objParam['codRol'].",'propietario_antes_p','terreno') AS propietario_antes_p,
                    fn_get_dato_permiso_campo (actualiza_sap::TEXT ,".$objParam['codRol'].",'actualiza_sap','terreno') AS actualiza_sap,
                    fn_get_dato_permiso_campo (impto_predial_p::TEXT ,".$objParam['codRol'].",'impto_predial_p','terreno') AS impto_predial_p,
                    fn_get_dato_permiso_campo (id_shp_p::TEXT ,".$objParam['codRol'].",'id_shp_p','terreno') AS id_shp_p,
                    fn_get_dato_permiso_campo (fecha_levantamiento_p::TEXT ,".$objParam['codRol'].",'fecha_levantamiento_p','terreno') AS fecha_levantamiento_p,
                    fn_get_dato_permiso_campo (id_estado_fk::TEXT ,".$objParam['codRol'].",'id_estado_fk','terreno') AS id_estado_fk,
                    fn_get_dato_permiso_campo (fecha_creacion_p::TEXT ,".$objParam['codRol'].",'fecha_creacion_p','terreno') AS fecha_creacion_p,
                    fn_get_dato_permiso_campo (fecha_modifica_p::TEXT ,".$objParam['codRol'].",'fecha_modifica_p','terreno') AS fecha_modifica_p,
                    fn_get_dato_permiso_campo (migracion_siga::TEXT ,".$objParam['codRol'].",'migracion_siga','terreno') AS migracion_siga,
                    fn_get_dato_permiso_campo (id_capa::TEXT ,".$objParam['codRol'].",'id_capa','terreno') AS id_capa,
                    fn_get_dato_permiso_campo (doc_calidad_bien::TEXT ,".$objParam['codRol'].",'doc_calidad_bien','terreno') AS doc_calidad_bien,
                    fn_get_dato_permiso_campo (fecha_expedicion_cb_p::TEXT ,".$objParam['codRol'].",'fecha_expedicion_cb_p','terreno') AS fecha_expedicion_cb_p,
                    fn_get_dato_permiso_campo (orfeo_cb_p::TEXT ,".$objParam['codRol'].",'orfeo_cb_p','terreno') AS orfeo_cb_p,
                    fn_get_dato_permiso_campo (documento_p::TEXT ,".$objParam['codRol'].",'documento_p','terreno') AS documento_p,
                    fn_get_dato_permiso_campo (foto_p::TEXT ,".$objParam['codRol'].",'foto_p','terreno') AS foto_p,
                    fn_get_dato_permiso_campo (ubica_archivo_p::TEXT ,".$objParam['codRol'].",'ubica_archivo_p','terreno') AS ubica_archivo_p,
                    fn_get_dato_permiso_campo (mensaje_p::TEXT ,".$objParam['codRol'].",'mensaje_p','terreno') AS mensaje_p
                FROM 
                public.terreno
                WHERE 
                    identifica_p = '".$objParam['codPredio']."'
        ";

        $result = $this->db->query($sql);
        return $result->result();
        
    }
}

?>