<?php

class Home_model extends CI_Model{
  	
    public function __construct() {
        parent::__construct(); 
    }

    public function traerInfoPredio_data($objParam){            
        $sql = "SELECT
                    fn_get_dato_permiso_campo (terr.id_p::TEXT ,".$objParam['codRol'].",'id_p','terreno',".$objParam['codModulo'].") AS id_p,
                    fn_get_dato_permiso_campo (terr.cedula_ppal_p::TEXT ,".$objParam['codRol'].",'cedula_ppal_p','terreno',".$objParam['codModulo'].") AS cedula_ppal_p,
                    fn_get_dato_permiso_campo (terr.id_catastro_p::TEXT ,".$objParam['codRol'].",'id_catastro_p','terreno',".$objParam['codModulo'].") AS id_catastro_p,
                    fn_get_dato_permiso_campo (terr.nupre_p::TEXT ,".$objParam['codRol'].",'nupre_p','terreno',".$objParam['codModulo'].") AS nupre_p,
                    fn_get_dato_permiso_campo (terr.dv_p::TEXT ,".$objParam['codRol'].",'dv_p','terreno',".$objParam['codModulo'].") AS dv_p,
                    fn_get_dato_permiso_campo (terr.codigonal_p::TEXT ,".$objParam['codRol'].",'codigonal_p','terreno',".$objParam['codModulo'].") AS codigonal_p,
                    fn_get_dato_permiso_campo (terr.codigounico_p::TEXT ,".$objParam['codRol'].",'codigounico_p','terreno',".$objParam['codModulo'].") AS codigounico_p,
                    fn_get_dato_permiso_campo (terr.identifica_p::TEXT ,".$objParam['codRol'].",'identifica_p','terreno',".$objParam['codModulo'].") AS identifica_p,
                    fn_get_dato_permiso_campo (terr.id_proyecto_p::TEXT ,".$objParam['codRol'].",'id_proyecto_p','terreno',".$objParam['codModulo'].") AS id_proyecto_p,
                    fn_get_dato_permiso_campo (terr.clase_inmueble_p::TEXT ,".$objParam['codRol'].",'clase_inmueble_p','terreno',".$objParam['codModulo'].") AS clase_inmueble_p,
                    fn_get_dato_permiso_campo (terr.id_cb_fk::TEXT ,".$objParam['codRol'].",'id_cb_fk','terreno',".$objParam['codModulo'].") AS id_cb_fk,
                    fn_get_dato_permiso_campo (terr.id_tb_fk::TEXT ,".$objParam['codRol'].",'id_tb_fk','terreno',".$objParam['codModulo'].") AS id_tb_fk,
                    fn_get_dato_permiso_campo (terr.id_tu_fk::TEXT ,".$objParam['codRol'].",'id_tu_fk','terreno',".$objParam['codModulo'].") AS id_tu_fk,
                    fn_get_dato_permiso_campo (terr.direccion_p::TEXT ,".$objParam['codRol'].",'direccion_p','terreno',".$objParam['codModulo'].") AS direccion_p,
                    fn_get_dato_permiso_campo (terr.direccioncatastro_p::TEXT ,".$objParam['codRol'].",'direccioncatastro_p','terreno',".$objParam['codModulo'].") AS direccioncatastro_p,
                    fn_get_dato_permiso_campo (terr.zona_p::TEXT ,".$objParam['codRol'].",'zona_p','terreno',".$objParam['codModulo'].") AS zona_p,
                    fn_get_dato_permiso_campo (terr.id_barrio::TEXT ,".$objParam['codRol'].",'id_barrio','terreno',".$objParam['codModulo'].") AS id_barrio,
                    fn_get_dato_permiso_campo (terr.pais_p::TEXT ,".$objParam['codRol'].",'pais_p','terreno',".$objParam['codModulo'].") AS pais_p,
                    fn_get_dato_permiso_campo (terr.ciudad_p::TEXT ,".$objParam['codRol'].",'ciudad_p','terreno',".$objParam['codModulo'].") AS ciudad_p,
                    fn_get_dato_permiso_campo (terr.lind_norte_p::TEXT ,".$objParam['codRol'].",'lind_norte_p','terreno',".$objParam['codModulo'].") AS lind_norte_p,
                    fn_get_dato_permiso_campo (terr.lind_sur_p::TEXT ,".$objParam['codRol'].",'lind_sur_p','terreno',".$objParam['codModulo'].") AS lind_sur_p,
                    fn_get_dato_permiso_campo (terr.lind_este_p::TEXT ,".$objParam['codRol'].",'lind_este_p','terreno',".$objParam['codModulo'].") AS lind_este_p,
                    fn_get_dato_permiso_campo (terr.lind_oeste_p::TEXT ,".$objParam['codRol'].",'lind_oeste_p','terreno',".$objParam['codModulo'].") AS lind_oeste_p,
                    fn_get_dato_permiso_campo (terr.lind_adic_p::TEXT ,".$objParam['codRol'].",'lind_adic_p','terreno',".$objParam['codModulo'].") AS lind_adic_p,
                    fn_get_dato_permiso_campo (terr.matricula_ppal_p::TEXT ,".$objParam['codRol'].",'matricula_ppal_p','terreno',".$objParam['codModulo'].") AS matricula_ppal_p,
                    fn_get_dato_permiso_campo (terr.mat_inmob_p::TEXT ,".$objParam['codRol'].",'mat_inmob_p','terreno',".$objParam['codModulo'].") AS mat_inmob_p,
                    fn_get_dato_permiso_campo (terr.id_madq_fk::TEXT ,".$objParam['codRol'].",'id_madq_fk','terreno',".$objParam['codModulo'].") AS id_madq_fk,
                    fn_get_dato_permiso_campo (terr.nombre_areacedida_p::TEXT ,".$objParam['codRol'].",'nombre_areacedida_p','terreno',".$objParam['codModulo'].") AS nombre_areacedida_p,
                    fn_get_dato_permiso_campo (terr.nit_cede_fk::TEXT ,".$objParam['codRol'].",'nit_cede_fk','terreno',".$objParam['codModulo'].") AS nit_cede_fk,
                    fn_get_dato_permiso_campo (terr.derecho_p::TEXT ,".$objParam['codRol'].",'derecho_p','terreno',".$objParam['codModulo'].") AS derecho_p,
                    fn_get_dato_permiso_campo (terr.afecta_pot_p::TEXT ,".$objParam['codRol'].",'afecta_pot_p','terreno',".$objParam['codModulo'].") AS afecta_pot_p,
                    fn_get_dato_permiso_campo (terr.asegurado_p::TEXT ,".$objParam['codRol'].",'asegurado_p','terreno',".$objParam['codModulo'].") AS asegurado_p,
                    fn_get_dato_permiso_campo (terr.suscep_vta_p::TEXT ,".$objParam['codRol'].",'suscep_vta_p','terreno',".$objParam['codModulo'].") AS suscep_vta_p,
                    fn_get_dato_permiso_campo (terr.id_depen_fk::TEXT ,".$objParam['codRol'].",'id_depen_fk','terreno',".$objParam['codModulo'].") AS id_depen_fk,
                    fn_get_dato_permiso_campo (terr.nombrecomun_p::TEXT ,".$objParam['codRol'].",'nombrecomun_p','terreno',".$objParam['codModulo'].") AS nombrecomun_p,
                    fn_get_dato_permiso_campo (terr.area_cesion_p::TEXT ,".$objParam['codRol'].",'area_cesion_p','terreno',".$objParam['codModulo'].") AS area_cesion_p,
                    fn_get_dato_permiso_campo (terr.area_actual_p::TEXT ,".$objParam['codRol'].",'area_actual_p','terreno',".$objParam['codModulo'].") AS area_actual_p,
                    fn_get_dato_permiso_campo (terr.area_sicat_p::TEXT ,".$objParam['codRol'].",'area_sicat_p','terreno',".$objParam['codModulo'].") AS area_sicat_p,
                    fn_get_dato_permiso_campo (terr.area_terreno_p::TEXT ,".$objParam['codRol'].",'area_terreno_p','terreno',".$objParam['codModulo'].") AS area_terreno_p,
                    fn_get_dato_permiso_campo (terr.fecha_estudio_titulo_p::TEXT ,".$objParam['codRol'].",'fecha_estudio_titulo_p','terreno',".$objParam['codModulo'].") AS fecha_estudio_titulo_p,
                    fn_get_dato_permiso_campo (terr.num_activofijo_p::TEXT ,".$objParam['codRol'].",'num_activofijo_p','terreno',".$objParam['codModulo'].") AS num_activofijo_p,
                    fn_get_dato_permiso_campo (terr.codigo_zhg_p::TEXT ,".$objParam['codRol'].",'codigo_zhg_p','terreno',".$objParam['codModulo'].") AS codigo_zhg_p,
                    fn_get_dato_permiso_campo (terr.cuenta_terreno_p::TEXT ,".$objParam['codRol'].",'cuenta_terreno_p','terreno',".$objParam['codModulo'].") AS cuenta_terreno_p,
                    fn_get_dato_permiso_campo (terr.propietario_antes_p::TEXT ,".$objParam['codRol'].",'propietario_antes_p','terreno',".$objParam['codModulo'].") AS propietario_antes_p,
                    fn_get_dato_permiso_campo (terr.actualiza_sap::TEXT ,".$objParam['codRol'].",'actualiza_sap','terreno',".$objParam['codModulo'].") AS actualiza_sap,
                    fn_get_dato_permiso_campo (terr.impto_predial_p::TEXT ,".$objParam['codRol'].",'impto_predial_p','terreno',".$objParam['codModulo'].") AS impto_predial_p,
                    fn_get_dato_permiso_campo (terr.id_shp_p::TEXT ,".$objParam['codRol'].",'id_shp_p','terreno',".$objParam['codModulo'].") AS id_shp_p,
                    fn_get_dato_permiso_campo (terr.fecha_levantamiento_p::TEXT ,".$objParam['codRol'].",'fecha_levantamiento_p','terreno',".$objParam['codModulo'].") AS fecha_levantamiento_p,
                    fn_get_dato_permiso_campo (terr.id_estado_fk::TEXT ,".$objParam['codRol'].",'id_estado_fk','terreno',".$objParam['codModulo'].") AS id_estado_fk,
                    fn_get_dato_permiso_campo (terr.fecha_creacion_p::TEXT ,".$objParam['codRol'].",'fecha_creacion_p','terreno',".$objParam['codModulo'].") AS fecha_creacion_p,
                    fn_get_dato_permiso_campo (terr.fecha_modifica_p::TEXT ,".$objParam['codRol'].",'fecha_modifica_p','terreno',".$objParam['codModulo'].") AS fecha_modifica_p,
                    fn_get_dato_permiso_campo (terr.migracion_siga::TEXT ,".$objParam['codRol'].",'migracion_siga','terreno',".$objParam['codModulo'].") AS migracion_siga,
                    fn_get_dato_permiso_campo (terr.id_capa::TEXT ,".$objParam['codRol'].",'id_capa','terreno',".$objParam['codModulo'].") AS id_capa,
                    fn_get_dato_permiso_campo (terr.doc_calidad_bien::TEXT ,".$objParam['codRol'].",'doc_calidad_bien','terreno',".$objParam['codModulo'].") AS doc_calidad_bien,
                    fn_get_dato_permiso_campo (terr.fecha_expedicion_cb_p::TEXT ,".$objParam['codRol'].",'fecha_expedicion_cb_p','terreno',".$objParam['codModulo'].") AS fecha_expedicion_cb_p,
                    fn_get_dato_permiso_campo (terr.orfeo_cb_p::TEXT ,".$objParam['codRol'].",'orfeo_cb_p','terreno',".$objParam['codModulo'].") AS orfeo_cb_p,
                    fn_get_dato_permiso_campo (terr.documento_p::TEXT ,".$objParam['codRol'].",'documento_p','terreno',".$objParam['codModulo'].") AS documento_p,
                    fn_get_dato_permiso_campo (terr.foto_p::TEXT ,".$objParam['codRol'].",'foto_p','terreno',".$objParam['codModulo'].") AS foto_p,
                    fn_get_dato_permiso_campo (terr.ubica_archivo_p::TEXT ,".$objParam['codRol'].",'ubica_archivo_p','terreno',".$objParam['codModulo'].") AS ubica_archivo_p,
                    fn_get_dato_permiso_campo (terr.mensaje_p::TEXT ,".$objParam['codRol'].",'mensaje_p','terreno',".$objParam['codModulo'].") AS mensaje_p,
                    '--------------------- NOMBRES ---------------------' AS keys_0,
                    fn_get_dato_permiso_campo (proy.nombre_pro::TEXT ,".$objParam['codRol'].",'nombre_pro','proyecto',".$objParam['codModulo'].") AS nombre_pro,
                    fn_get_dato_permiso_campo (calb.nombre_cb::TEXT ,".$objParam['codRol'].",'nombre_cb','calidad_bien',".$objParam['codModulo'].") AS nombre_cb,
                    fn_get_dato_permiso_campo (tipb.nombre_tb::TEXT ,".$objParam['codRol'].",'nombre_tb','tipo_bien',".$objParam['codModulo'].") AS nombre_tb,
                    fn_get_dato_permiso_campo (barr.barrio::TEXT ,".$objParam['codRol'].",'barrio','barrios',".$objParam['codModulo'].") AS barrio,
                    fn_get_dato_permiso_campo (modo.nombre_madq::TEXT ,".$objParam['codRol'].",'nombre_madq','modo_adq',".$objParam['codModulo'].") AS nombre_madq,
                    fn_get_dato_permiso_campo (terc.nombre_tcro::TEXT ,".$objParam['codRol'].",'nombre_tcro','tercero',".$objParam['codModulo'].") AS nombre_tcro,
                    fn_get_dato_permiso_campo (tercp.nombre_tcro::TEXT,".$objParam['codRol'].",'nombre_tcro','tercero',".$objParam['codModulo'].") AS nombre_tcro_p,
                    fn_get_dato_permiso_campo (clas.clase::TEXT ,".$objParam['codRol'].",'clase','clase_inmueble',".$objParam['codModulo'].") AS clase,
                    fn_get_dato_permiso_campo (usop.nombre_tu::TEXT ,".$objParam['codRol'].",'nombre_tu','uso_predio',".$objParam['codModulo'].") AS nombre_tu,
                    fn_get_dato_permiso_campo (ciud.nombre_ciu::TEXT ,".$objParam['codRol'].",'nombre_ciu','ciudad',".$objParam['codModulo'].") AS nombre_ciu,
                    fn_get_dato_permiso_campo (depa.nombre_dep::TEXT ,".$objParam['codRol'].",'nombre_dep','departamento',".$objParam['codModulo'].") AS nombre_dep,
                    fn_get_dato_permiso_campo (depe.nombre_depen::TEXT ,".$objParam['codRol'].",'nombre_depen','dependencia',".$objParam['codModulo'].") AS nombre_depen,
                    fn_get_dato_permiso_campo (cuen.nombre_cuenta::TEXT ,".$objParam['codRol'].",'nombre_cuenta','cuenta',".$objParam['codModulo'].") AS nombre_cuenta,
                    fn_get_dato_permiso_campo (esta.nombre_estado::TEXT ,".$objParam['codRol'].",'nombre_estado','estado',".$objParam['codModulo'].") AS nombre_estado,
                    fn_get_dato_permiso_campo (cap.nombre_capa::TEXT ,".$objParam['codRol'].",'nombre_capa','capa',".$objParam['codModulo'].") AS nombre_capa,
                    '--------------------- CONSTRUCCION ---------------------' AS keys_1,
                    fn_get_dato_permiso_campo (cons.id_const::TEXT ,".$objParam['codRol'].",'id_const','construccion',".$objParam['codModulo'].") AS cons_id_const,
                    fn_get_dato_permiso_campo (cons.predialterreno_const_fk::TEXT ,".$objParam['codRol'].",'predialterreno_const_fk','construccion',".$objParam['codModulo'].") AS cons_predialterreno_const_fk,
                    fn_get_dato_permiso_campo (cons.predial_edificacion_const::TEXT ,".$objParam['codRol'].",'predial_edificacion_const','construccion',".$objParam['codModulo'].") AS cons_predial_edificacion_const,
                    fn_get_dato_permiso_campo (cons.id_catastro_const::TEXT ,".$objParam['codRol'].",'id_catastro_const','construccion',".$objParam['codModulo'].") AS cons_id_catastro_const,
                    fn_get_dato_permiso_campo (cons.activofijo_const::TEXT ,".$objParam['codRol'].",'activofijo_const','construccion',".$objParam['codModulo'].") AS cons_activofijo_const,
                    fn_get_dato_permiso_campo (cons.codigonal_const::TEXT ,".$objParam['codRol'].",'codigonal_const','construccion',".$objParam['codModulo'].") AS cons_codigonal_const,
                    fn_get_dato_permiso_campo (cons.codigounico_const::TEXT ,".$objParam['codRol'].",'codigounico_const','construccion',".$objParam['codModulo'].") AS cons_codigounico_const,
                    fn_get_dato_permiso_campo (cons.direccion_const::TEXT ,".$objParam['codRol'].",'direccion_const','construccion',".$objParam['codModulo'].") AS cons_direccion_const,
                    fn_get_dato_permiso_campo (cons.nombre_const::TEXT ,".$objParam['codRol'].",'nombre_const','construccion',".$objParam['codModulo'].") AS cons_nombre_const,
                    fn_get_dato_permiso_campo (cons.numpisos_const::TEXT ,".$objParam['codRol'].",'numpisos_const','construccion',".$objParam['codModulo'].") AS cons_numpisos_const,
                    fn_get_dato_permiso_campo (cons.numconstruccion_const::TEXT ,".$objParam['codRol'].",'numconstruccion_const','construccion',".$objParam['codModulo'].") AS cons_numconstruccion_const,
                    fn_get_dato_permiso_campo (cons.ano_const::TEXT ,".$objParam['codRol'].",'ano_const','construccion',".$objParam['codModulo'].") AS cons_ano_const,
                    fn_get_dato_permiso_campo (cons.sismoresiste_const::TEXT ,".$objParam['codRol'].",'sismoresiste_const','construccion',".$objParam['codModulo'].") AS cons_sismoresiste_const,
                    fn_get_dato_permiso_campo (cons.afecta_pot_const::TEXT ,".$objParam['codRol'].",'afecta_pot_const','construccion',".$objParam['codModulo'].") AS cons_afecta_pot_const,
                    fn_get_dato_permiso_campo (cons.area_edifica_const::TEXT ,".$objParam['codRol'].",'area_edifica_const','construccion',".$objParam['codModulo'].") AS cons_area_edifica_const,
                    fn_get_dato_permiso_campo (cons.area_anexos_const::TEXT ,".$objParam['codRol'].",'area_anexos_const','construccion',".$objParam['codModulo'].") AS cons_area_anexos_const,
                    fn_get_dato_permiso_campo (cons.impto_predial_const::TEXT ,".$objParam['codRol'].",'impto_predial_const','construccion',".$objParam['codModulo'].") AS cons_impto_predial_const,
                    fn_get_dato_permiso_campo (cons.mat_inmob_const::TEXT ,".$objParam['codRol'].",'mat_inmob_const','construccion',".$objParam['codModulo'].") AS cons_mat_inmob_const,
                    fn_get_dato_permiso_campo (cons.cuenta_const::TEXT ,".$objParam['codRol'].",'cuenta_const','construccion',".$objParam['codModulo'].") AS cons_cuenta_const,
                    fn_get_dato_permiso_campo (cons.nombre_cuenta_const::TEXT ,".$objParam['codRol'].",'nombre_cuenta_const','construccion',".$objParam['codModulo'].") AS cons_nombre_cuenta_const,
                    fn_get_dato_permiso_campo (cons.gid::TEXT ,".$objParam['codRol'].",'gid','construccion',".$objParam['codModulo'].") AS cons_gid,
                    fn_get_dato_permiso_campo (cons.id_capa_const::TEXT ,".$objParam['codRol'].",'id_capa_const','construccion',".$objParam['codModulo'].") AS cons_id_capa_const,
                    fn_get_dato_permiso_campo (cons.orfeo_cb_const::TEXT ,".$objParam['codRol'].",'orfeo_cb_const','construccion',".$objParam['codModulo'].") AS cons_orfeo_cb_const,
                    fn_get_dato_permiso_campo (cons.fecha_registro_const::TEXT ,".$objParam['codRol'].",'fecha_registro_const','construccion',".$objParam['codModulo'].") AS cons_fecha_registro_const,
                    fn_get_dato_permiso_campo (cons.id_tb_fk::TEXT ,".$objParam['codRol'].",'id_tb_fk','construccion',".$objParam['codModulo'].") AS cons_id_tb_fk,
                    fn_get_dato_permiso_campo (cons.id_tu_fk::TEXT ,".$objParam['codRol'].",'id_tu_fk','construccion',".$objParam['codModulo'].") AS cons_id_tu_fk,
                    fn_get_dato_permiso_campo (cons.id_depen_fk::TEXT ,".$objParam['codRol'].",'id_depen_fk','construccion',".$objParam['codModulo'].") AS cons_id_depen_fk,
                    fn_get_dato_permiso_campo (cons.derecho_c::TEXT ,".$objParam['codRol'].",'derecho_c','construccion',".$objParam['codModulo'].") AS cons_derecho_c,
                    fn_get_dato_permiso_campo (cons.fecha_modifica_const::TEXT ,".$objParam['codRol'].",'fecha_modifica_const','construccion',".$objParam['codModulo'].") AS cons_fecha_modifica_const,
                    fn_get_dato_permiso_campo (contipo.nombre_tb::TEXT ,".$objParam['codRol'].",'nombre_tb','tipo_bien',".$objParam['codModulo'].") AS cons_nombre_tb,
                    fn_get_dato_permiso_campo (conuso.nombre_tu::TEXT ,".$objParam['codRol'].",'nombre_tu','uso_predio',".$objParam['codModulo'].") AS cons_nombre_tu,
                    '--------------------- AVALUO ---------------------' AS keys_2,
                    fn_get_dato_permiso_campo (aval.id_aval::TEXT ,".$objParam['codRol'].",'id_aval','avaluo',".$objParam['codModulo'].") AS aval_id_aval,
                    fn_get_dato_permiso_campo (aval.predial_terreno_aval::TEXT ,".$objParam['codRol'].",'predial_terreno_aval','avaluo',".$objParam['codModulo'].") AS aval_predial_terreno_aval,
                    fn_get_dato_permiso_campo (aval.predial_construccion_aval::TEXT ,".$objParam['codRol'].",'predial_construccion_aval','avaluo',".$objParam['codModulo'].") AS aval_predial_construccion_aval,
                    fn_get_dato_permiso_campo (aval.año::TEXT ,".$objParam['codRol'].",'año','avaluo',".$objParam['codModulo'].") AS aval_anio,
                    fn_get_dato_permiso_campo (aval.valor_cial_terreno_aval::TEXT ,".$objParam['codRol'].",'valor_cial_terreno_aval','avaluo',".$objParam['codModulo'].") AS aval_valor_cial_terreno_aval,
                    fn_get_dato_permiso_campo (aval.valor_cial_contruccion_aval::TEXT ,".$objParam['codRol'].",'valor_cial_contruccion_aval','avaluo',".$objParam['codModulo'].") AS aval_valor_cial_contruccion_aval,
                    fn_get_dato_permiso_campo (aval.valor_cial_anexos_aval::TEXT ,".$objParam['codRol'].",'valor_cial_anexos_aval','avaluo',".$objParam['codModulo'].") AS aval_valor_cial_anexos_aval,
                    '--------------------- CONTRATO ---------------------' AS keys_3,
                    fn_get_dato_permiso_campo (cont.id_cont::TEXT ,".$objParam['codRol'].",'id_cont','contrato',".$objParam['codModulo'].") AS cont_id_cont,
                    fn_get_dato_permiso_campo (cont.predial_cont_fk::TEXT ,".$objParam['codRol'].",'predial_cont_fk','contrato',".$objParam['codModulo'].") AS cont_predial_cont_fk,
                    fn_get_dato_permiso_campo (cont.numero_cont::TEXT ,".$objParam['codRol'].",'numero_cont','contrato',".$objParam['codModulo'].") AS cont_numero_cont,
                    fn_get_dato_permiso_campo (cont.id_tc_fk::TEXT ,".$objParam['codRol'].",'id_tc_fk','contrato',".$objParam['codModulo'].") AS cont_id_tc_fk,
                    fn_get_dato_permiso_campo (cont.area_entregada_cont::TEXT ,".$objParam['codRol'].",'area_entregada_cont','contrato',".$objParam['codModulo'].") AS cont_area_entregada_cont,
                    fn_get_dato_permiso_campo (cont.fecha_ini_cont::TEXT ,".$objParam['codRol'].",'fecha_ini_cont','contrato',".$objParam['codModulo'].") AS cont_fecha_ini_cont,
                    fn_get_dato_permiso_campo (cont.fecha_fin_cont::TEXT ,".$objParam['codRol'].",'fecha_fin_cont','contrato',".$objParam['codModulo'].") AS cont_fecha_fin_cont,
                    fn_get_dato_permiso_campo (cont.id_estado_fk::TEXT ,".$objParam['codRol'].",'id_estado_fk','contrato',".$objParam['codModulo'].") AS cont_id_estado_fk,
                    fn_get_dato_permiso_campo (cont.nit_entidad_cont::TEXT ,".$objParam['codRol'].",'nit_entidad_cont','contrato',".$objParam['codModulo'].") AS cont_nit_entidad_cont,
                    fn_get_dato_permiso_campo (cont.idusu_cont_fk::TEXT ,".$objParam['codRol'].",'idusu_cont_fk','contrato',".$objParam['codModulo'].") AS cont_idusu_cont_fk,
                    fn_get_dato_permiso_campo (cont.lind_norte_cont::TEXT ,".$objParam['codRol'].",'lind_norte_cont','contrato',".$objParam['codModulo'].") AS cont_lind_norte_cont,
                    fn_get_dato_permiso_campo (cont.lind_sur_cont::TEXT ,".$objParam['codRol'].",'lind_sur_cont','contrato',".$objParam['codModulo'].") AS cont_lind_sur_cont,
                    fn_get_dato_permiso_campo (cont.lind_este_cont::TEXT ,".$objParam['codRol'].",'lind_este_cont','contrato',".$objParam['codModulo'].") AS cont_lind_este_cont,
                    fn_get_dato_permiso_campo (cont.lind_oeste_cont::TEXT ,".$objParam['codRol'].",'lind_oeste_cont','contrato',".$objParam['codModulo'].") AS cont_lind_oeste_cont,
                    fn_get_dato_permiso_campo (cont.lind_adic_cont::TEXT ,".$objParam['codRol'].",'lind_adic_cont','contrato',".$objParam['codModulo'].") AS cont_lind_adic_cont,
                    fn_get_dato_permiso_campo (cont.id_const_fk::TEXT ,".$objParam['codRol'].",'id_const_fk','contrato',".$objParam['codModulo'].") AS cont_id_const_fk,
                    fn_get_dato_permiso_campo (cont.cantidad_ocupa_cont::TEXT ,".$objParam['codRol'].",'cantidad_ocupa_cont','contrato',".$objParam['codModulo'].") AS cont_cantidad_ocupa_cont,
                    fn_get_dato_permiso_campo (cont.porcentaje_ocupa_cont::TEXT ,".$objParam['codRol'].",'porcentaje_ocupa_cont','contrato',".$objParam['codModulo'].") AS cont_porcentaje_ocupa_cont,
                    fn_get_dato_permiso_campo (cont.valor_canon_cont::TEXT ,".$objParam['codRol'].",'valor_canon_cont','contrato',".$objParam['codModulo'].") AS cont_valor_canon_cont,
                    fn_get_dato_permiso_campo (cont.tipo_ocupante_cont::TEXT ,".$objParam['codRol'].",'tipo_ocupante_cont','contrato',".$objParam['codModulo'].") AS cont_tipo_ocupante_cont,
                    '--------------------- DOCUMENTO ---------------------' AS keys_4,
                    fn_get_dato_permiso_campo (docu.id_doc::TEXT ,".$objParam['codRol'].",'id_doc','documento',".$objParam['codModulo'].") AS docu_id_doc,
                    fn_get_dato_permiso_campo (docu.id_tipod_fk::TEXT ,".$objParam['codRol'].",'id_tipod_fk','documento',".$objParam['codModulo'].") AS docu_id_tipod_fk,
                    fn_get_dato_permiso_campo (docu.numero_doc::TEXT ,".$objParam['codRol'].",'numero_doc','documento',".$objParam['codModulo'].") AS docu_numero_doc,
                    fn_get_dato_permiso_campo (docu.fecha_doc::TEXT ,".$objParam['codRol'].",'fecha_doc','documento',".$objParam['codModulo'].") AS docu_fecha_doc,
                    fn_get_dato_permiso_campo (docu.id_not_fk::TEXT ,".$objParam['codRol'].",'id_not_fk','documento',".$objParam['codModulo'].") AS docu_id_not_fk,
                    fn_get_dato_permiso_campo (docu.id_oficina_expe::TEXT ,".$objParam['codRol'].",'id_oficina_expe','documento',".$objParam['codModulo'].") AS docu_id_oficina_expe,
                    fn_get_dato_permiso_campo (docu.ciudad_doc::TEXT ,".$objParam['codRol'].",'ciudad_doc','documento',".$objParam['codModulo'].") AS docu_ciudad_doc,
                    fn_get_dato_permiso_campo (doctipo.nombre_tipod::TEXT ,".$objParam['codRol'].",'nombre_tipod','tipo_doc',".$objParam['codModulo'].") AS docu_nombre_tipod,
                    fn_get_dato_permiso_campo (docciudad.nombre_ciu::TEXT ,".$objParam['codRol'].",'nombre_ciu','ciudad',".$objParam['codModulo'].") AS docu_nombre_ciu,
                    fn_get_dato_permiso_campo (docnotaria.nombre_not::TEXT ,".$objParam['codRol'].",'nombre_not','notaria',".$objParam['codModulo'].") AS docu_nombre_not,
                    fn_get_dato_permiso_campo (docofi.nombre_oficina::TEXT ,".$objParam['codRol'].",'nombre_oficina','oficina_expedicion_doc',".$objParam['codModulo'].") AS docu_nombre_oficina,
                    '--------------------- MATRICULA ---------------------' AS keys_5,
                    fn_get_dato_permiso_campo (matr.id_mat::TEXT ,".$objParam['codRol'].",'id_mat','matricula',".$objParam['codModulo'].") AS matr_id_mat,
                    fn_get_dato_permiso_campo (matr.numero_mat::TEXT ,".$objParam['codRol'].",'numero_mat','matricula',".$objParam['codModulo'].") AS matr_numero_mat,
                    fn_get_dato_permiso_campo (matr.fecha_mat::TEXT ,".$objParam['codRol'].",'fecha_mat','matricula',".$objParam['codModulo'].") AS matr_fecha_mat,
                    fn_get_dato_permiso_campo (matr.ciudad_mat::TEXT ,".$objParam['codRol'].",'ciudad_mat','matricula',".$objParam['codModulo'].") AS matr_ciudad_mat,
                    fn_get_dato_permiso_campo (matr.estado_juridico_mat::TEXT ,".$objParam['codRol'].",'estado_juridico_mat','matricula',".$objParam['codModulo'].") AS matr_estado_juridico_mat,
                    fn_get_dato_permiso_campo (matr.cantidad_gravamen_mat::TEXT ,".$objParam['codRol'].",'cantidad_gravamen_mat','matricula',".$objParam['codModulo'].") AS matr_cantidad_gravamen_mat,
                    fn_get_dato_permiso_campo (matr.procontra_mat::TEXT ,".$objParam['codRol'].",'procontra_mat','matricula',".$objParam['codModulo'].") AS matr_procontra_mat,
                    fn_get_dato_permiso_campo (matr.otroprop_mat::TEXT ,".$objParam['codRol'].",'otroprop_mat','matricula',".$objParam['codModulo'].") AS matr_otroprop_mat,
                    fn_get_dato_permiso_campo (matr.tipoprop_mat::TEXT ,".$objParam['codRol'].",'tipoprop_mat','matricula',".$objParam['codModulo'].") AS matr_tipoprop_mat,
                    '--------------------- OBSERVACION ---------------------' AS keys_6,
                    fn_get_dato_permiso_campo (obse.id_obs::TEXT ,".$objParam['codRol'].",'id_obs','observacion',".$objParam['codModulo'].") AS obse_id_obs,
                    fn_get_dato_permiso_campo (obse.predial_obs_fk::TEXT ,".$objParam['codRol'].",'predial_obs_fk','observacion',".$objParam['codModulo'].") AS obse_predial_obs_fk,
                    fn_get_dato_permiso_campo (obse.fecha_obs::TEXT ,".$objParam['codRol'].",'fecha_obs','observacion',".$objParam['codModulo'].") AS obse_fecha_obs,
                    fn_get_dato_permiso_campo (obse.observacion_obs::TEXT ,".$objParam['codRol'].",'observacion_obs','observacion',".$objParam['codModulo'].") AS obse_observacion_obs,
                    fn_get_dato_permiso_campo (obse.id_usu_fk::TEXT ,".$objParam['codRol'].",'id_usu_fk','observacion',".$objParam['codModulo'].") AS obse_id_usu_fk,
                    fn_get_dato_permiso_campo (obse.tipo_ob::TEXT ,".$objParam['codRol'].",'tipo_ob','observacion',".$objParam['codModulo'].") AS obse_tipo_ob,
                    '--------------------- REPORTE_PREDIO ---------------------' AS keys_7,
                    fn_get_dato_permiso_campo (repo.id_reporte::TEXT ,".$objParam['codRol'].",'id_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_id_reporte,
                    fn_get_dato_permiso_campo (repo.the_geom::TEXT ,".$objParam['codRol'].",'the_geom','reporte_predio',".$objParam['codModulo'].") AS repo_the_geom,
                    fn_get_dato_permiso_campo (repo.predial::TEXT ,".$objParam['codRol'].",'predial','reporte_predio',".$objParam['codModulo'].") AS repo_predial,
                    fn_get_dato_permiso_campo (repo.tipo_reporte::TEXT ,".$objParam['codRol'].",'tipo_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_tipo_reporte,
                    fn_get_dato_permiso_campo (repo.fecha_reporte::TEXT ,".$objParam['codRol'].",'fecha_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_fecha_reporte,
                    fn_get_dato_permiso_campo (repo.direccion_predio_reporte::TEXT ,".$objParam['codRol'].",'direccion_predio_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_direccion_predio_reporte,
                    fn_get_dato_permiso_campo (repo.dir_ip_reporte::TEXT ,".$objParam['codRol'].",'dir_ip_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_dir_ip_reporte,
                    fn_get_dato_permiso_campo (repo.estado_reporte::TEXT ,".$objParam['codRol'].",'estado_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_estado_reporte,
                    fn_get_dato_permiso_campo (repo.foto_reporte::TEXT ,".$objParam['codRol'].",'foto_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_foto_reporte,
                    fn_get_dato_permiso_campo (repo.ciudadano_reporte::TEXT ,".$objParam['codRol'].",'ciudadano_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_ciudadano_reporte,
                    fn_get_dato_permiso_campo (repo.cedula_reporte::TEXT ,".$objParam['codRol'].",'cedula_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_cedula_reporte,
                    fn_get_dato_permiso_campo (repo.telefono_reporte::TEXT ,".$objParam['codRol'].",'telefono_reporte','reporte_predio',".$objParam['codModulo'].") AS repo_telefono_reporte,
                    fn_get_dato_permiso_campo (repo.radicado_orfeo::TEXT ,".$objParam['codRol'].",'radicado_orfeo','reporte_predio',".$objParam['codModulo'].") AS repo_radicado_orfeo,
                    fn_get_dato_permiso_campo (repo.observacion::TEXT ,".$objParam['codRol'].",'observacion','reporte_predio',".$objParam['codModulo'].") AS repo_observacion,
                    fn_get_dato_permiso_campo (repo.fecha_solicitud_restitucion::TEXT ,".$objParam['codRol'].",'fecha_solicitud_restitucion','reporte_predio',".$objParam['codModulo'].") AS repo_fecha_solicitud_restitucion,
                    fn_get_dato_permiso_campo (repo.oficio_solicitud::TEXT ,".$objParam['codRol'].",'oficio_solicitud','reporte_predio',".$objParam['codModulo'].") AS repo_oficio_solicitud,
                    fn_get_dato_permiso_campo (repo.fecha_inspeccion::TEXT ,".$objParam['codRol'].",'fecha_inspeccion','reporte_predio',".$objParam['codModulo'].") AS repo_fecha_inspeccion,
                    fn_get_dato_permiso_campo (repo.inspeccion::TEXT ,".$objParam['codRol'].",'inspeccion','reporte_predio',".$objParam['codModulo'].") AS repo_inspeccion,
                    fn_get_dato_permiso_campo (repo.observacion_ciudadano::TEXT ,".$objParam['codRol'].",'observacion_ciudadano','reporte_predio',".$objParam['codModulo'].") AS repo_observacion_ciudadano,
                    '--------------------- SERVICIO_PUBLICO ---------------------' AS keys_8,
                    fn_get_dato_permiso_campo (serv.id_sp::TEXT ,".$objParam['codRol'].",'id_sp','servicio_publico',".$objParam['codModulo'].") AS serv_id_sp,
                    fn_get_dato_permiso_campo (serv.predial_sp::TEXT ,".$objParam['codRol'].",'predial_sp','servicio_publico',".$objParam['codModulo'].") AS serv_predial_sp,
                    fn_get_dato_permiso_campo (serv.suscriptor_sp::TEXT ,".$objParam['codRol'].",'suscriptor_sp','servicio_publico',".$objParam['codModulo'].") AS serv_suscriptor_sp,
                    fn_get_dato_permiso_campo (serv.medidor_acueducto_sp::TEXT ,".$objParam['codRol'].",'medidor_acueducto_sp','servicio_publico',".$objParam['codModulo'].") AS serv_medidor_acueducto_sp,
                    fn_get_dato_permiso_campo (serv.medidor_energia_sp::TEXT ,".$objParam['codRol'].",'medidor_energia_sp','servicio_publico',".$objParam['codModulo'].") AS serv_medidor_energia_sp
                FROM 
                    public.terreno terr
                    LEFT JOIN construccion cons ON cons.predialterreno_const_fk = terr.identifica_p
                        LEFT JOIN tipo_bien contipo ON contipo.id_tb = cons.id_tb_fk
                        LEFT JOIN uso_predio conuso ON conuso.id_tu = cons.id_tu_fk
                    LEFT JOIN avaluo aval ON aval.predial_terreno_aval = terr.identifica_p
                    LEFT JOIN contrato cont ON cont.predial_cont_fk = terr.identifica_p
                    LEFT JOIN matricula matr ON matr.numero_mat = terr.mat_inmob_p
                    LEFT JOIN observacion obse ON obse.predial_obs_fk = terr.identifica_p
                    LEFT JOIN reporte_predio repo ON repo.predial = terr.identifica_p AND repo.estado_reporte IS NULL
                    LEFT JOIN servicio_publico serv ON serv.predial_sp = cons.predial_edificacion_const
                    LEFT JOIN proyecto proy ON terr.id_proyecto_p = proy.id_pro
                    LEFT JOIN calidad_bien calb ON calb.id_cb = terr.id_cb_fk
                    LEFT JOIN tipo_bien tipb ON tipb.id_tb = terr.id_tb_fk
                    LEFT JOIN barrios barr ON barr.id_barrio = terr.id_barrio
                    LEFT JOIN modo_adq modo ON modo.id_madq = terr.id_madq_fk
                    LEFT JOIN tercero terc ON terc.nit_tcro = terr.nit_cede_fk
                    LEFT JOIN tercero tercp ON tercp.nit_tcro = terr.propietario_antes_p
                    LEFT JOIN clase_inmueble clas ON clas.id_clase = terr.clase_inmueble_p
                    LEFT JOIN uso_predio usop ON usop.id_tu = terr.id_tu_fk
                    LEFT JOIN ciudad ciud ON ciud.cod_ciu = terr.ciudad_p
                    LEFT JOIN departamento depa ON depa.cod_dep = ciud.cod_dep
                    LEFT JOIN dependencia depe ON depe.id_depen = terr.id_depen_fk
                    LEFT JOIN cuenta cuen ON cuen.num_cuenta = terr.cuenta_terreno_p
                    LEFT JOIN estado esta ON esta.id_estado = terr.id_estado_fk
                    LEFT JOIN capa cap ON cap.id_capa = terr.id_capa
                    LEFT JOIN documento_predio docp ON docp.predial_p = terr.identifica_p
                        LEFT JOIN documento docu ON docu.numero_doc = docp.id_doc
                        LEFT JOIN tipo_doc doctipo ON doctipo.id_tipod = docu.id_tipod_fk AND doctipo.id_tipod = 1
                        LEFT JOIN ciudad docciudad ON docciudad.cod_ciu = docu.ciudad_doc
                        LEFT JOIN notaria docnotaria ON docnotaria.id_not = docu.id_not_fk
                        LEFT JOIN oficina_expedicion_doc docofi ON docofi.id_oficina = docu.id_oficina_expe
                WHERE 
                    terr.identifica_p = '".$objParam['codPredio']."'
        "; //AND cons.predial_edificacion_const = '".$objParam['codconstruccion']."'

        $sql .= $objParam['codconstruccion'] == '-1' || $objParam['codconstruccion'] == '' ? "" : " AND cons.predial_edificacion_const = '".$objParam['codconstruccion']."' ";
        $result = $this->db->query($sql);
        return $result->result();        
    }

    public function getPoligonoPredio($codPredio){
        $ress = array();
        $query =  "SELECT 
                        pred.gid,
                        terr.nombre_areacedida_p AS nombre,
                        COALESCE(terr.direccion_p, '') AS direccion, 
                        COALESCE(terr.identifica_p, '') AS predial, 
                        COALESCE(terr.nombrecomun_p, '') AS nombre_comun, 
                        COALESCE(terr.mat_inmob_p, '') AS matricula,
                        REPLACE(TO_CHAR(ST_X(ST_CENTROID((ST_DumpPoints(st_astext(st_transform(pred.the_geom, 6249)))).geom)), '99,99999'), ',', '.') AS lng,
                        REPLACE(TO_CHAR(ST_Y(ST_CENTROID((ST_DumpPoints(st_astext(st_transform(pred.the_geom, 6249)))).geom)), '99,99999'), ',', '.') AS lat
                    FROM 
                        geo_predio_mc pred
                        LEFT JOIN terreno terr ON pred.id_shp = terr.id_shp_p
                    WHERE
                        terr.identifica_p = '".$codPredio."'";
        $result = $this->db->query($query);        

        if ($result->num_rows() > 0) {
            $ress = $result->result(); 
        }
        
        return $ress;
    }

    public function getReporteTerreno_data($objParam){
        $ress = array();
        $query =  "SELECT 
                        *
                    FROM 
                        public.vw_saneamiento vws
                        INNER JOIN public.terreno tr ON tr.identifica_p = vws.predial_terreno
                        LEFT JOIN public.barrios br ON br.id_barrio = tr.id_barrio 
                    WHERE
                        vws.predial_terreno LIKE '%".$objParam['predio']."%'
                    ";
        
        $query .= $objParam['barrio'] == '-1' ? "" : " AND tr.id_barrio = '".$objParam['barrio']."' ";
        $query .= $objParam['comuna'] == '-1' ? "" : " AND br.comuna = '".$objParam['comuna']."' ";
        $query .= $objParam['tipoBien'] == '-1' ? "" : " AND tr.id_tb_fk = ".$objParam['tipoBien']." ";
        $query .= $objParam['tipoUso'] == '-1' ? "" : " AND tr.id_tb_fk = ".$objParam['tipoUso']." ";
        $query .= $objParam['areaCesion'] == '' ? "" : " AND tr.area_cesion_p = ".$objParam['areaCesion']." ";
        $query .= $objParam['calidad'] == '-1' ? "" : " AND tr.id_cb_fk = ".$objParam['calidad']." ";

        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            $ress = $result->result(); 
        }
        
        return $ress;
    }

    public function guardarAudiDoc_data($parameters){
        $sql = "SELECT public.fn_set_auditoria_descarga_doc(?,?,?) AS result";
        $result = $this->db->query($sql,$parameters);
        $ress = $result->row()->result;    
        return $ress;
    }

}

?>