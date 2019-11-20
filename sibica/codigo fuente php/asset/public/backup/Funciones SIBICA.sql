-----------------------
-- FUNCTION public.fn_get_reporte_irregular_predio
----------------------- 
CREATE OR REPLACE FUNCTION public.fn_get_reporte_irregular_predio (
    p_predio terreno.identifica_p%type
  )
  RETURNS TEXT AS
  $body$
  DECLARE
  _c TEXT;
  sec_insidencia INTEGER;
  contar INTEGER;
  ress TEXT;
  msj_tipo_reporte TEXT;
  obs_reporte TEXT;
  tpy_reporte reporte_predio%ROWTYPE;
  tpy_terreno terreno%ROWTYPE;
  datos RECORD;
  BEGIN
      ress := '{';
      msj_tipo_reporte := '[';
      obs_reporte := '';
      
      SELECT 
          count(*) INTO contar
      FROM
		  reporte_predio rp
		  --estado et
		  --terreno tr
		  --INNER JOIN geo_predio_mc gp ON gp.id_shp = tr.id_shp_p
		  --INNER JOIN reporte_predio rp ON rp.the_geom = gp.the_geom
	  WHERE
          rp.predial = p_predio
		  AND rp.estado_reporte IS NULL;
		  --AND et.id_estado = 1
          --AND trim(lower(rp.estado_reporte)) = trim(lower(et.nombre_estado));	   
      	
      
      FOR datos IN (SELECT * FROM tipo_reporte WHERE estado_tr_fk = 1)
      LOOP
          msj_tipo_reporte := msj_tipo_reporte || '{';
          msj_tipo_reporte := msj_tipo_reporte || '"id":"' || datos.id_tr || '",';
          msj_tipo_reporte := msj_tipo_reporte || '"nombre":"' || datos.nombre_tr || '",';
          msj_tipo_reporte := msj_tipo_reporte || '"mensaje":"' || datos.mensaje_tr || '"';
          msj_tipo_reporte := msj_tipo_reporte || '},';
      END LOOP;
      msj_tipo_reporte := substr(msj_tipo_reporte, 0, length(msj_tipo_reporte)) || ']';
      --msj_tipo_reporte := msj_tipo_reporte || ']';
  	    
      IF contar > 0 THEN
          SELECT 
              --rp.observacion_ciudadano INTO obs_reporte
			  rp.* INTO tpy_reporte
          FROM              
			  reporte_predio rp
			  --estado et
			  --terreno tr
              --INNER JOIN geo_predio_mc gp ON gp.id_shp = tr.id_shp_p
              --INNER JOIN reporte_predio rp ON rp.the_geom = gp.the_geom
          WHERE
              rp.predial = p_predio
			  AND rp.estado_reporte IS NULL;
			  --AND et.id_estado = 1
			  --AND trim(lower(rp.estado_reporte)) = trim(lower(et.nombre_estado));
      END IF;
	  
	  SELECT
		* INTO tpy_terreno
	   FROM public.terreno
	   WHERE identifica_p = p_predio;
      
      ress := ress || '"msj_reporte":' || msj_tipo_reporte || ',';
	  ress := ress || '"existe_reporte":' || contar || ',';
      ress := ress || '"tipo_reporte":"' || COALESCE(tpy_reporte.tipo_reporte, '') || '",';
	  ress := ress || '"predial":"' || CASE WHEN p_predio <> '-1' THEN p_predio ELSE '' END || '",';
	  ress := ress || '"direccion":"' || COALESCE(tpy_reporte.direccion_predio_reporte, COALESCE(tpy_terreno.direccion_p, '')) || '",';
	  ress := ress || '"nombre":"' || COALESCE(tpy_reporte.ciudadano_reporte,'') || '",';
	  ress := ress || '"cedula":"' || COALESCE(tpy_reporte.cedula_reporte,'') || '",';
	  --ress := ress || '"correo":"' || COALESCE(tpy_reporte.ciudadano_reporte,'') || '",';
	  ress := ress || '"telefono":"' || COALESCE(tpy_reporte.telefono_reporte,'') || '",';
	  ress := ress || '"adjunto":"' || COALESCE(tpy_reporte.foto_reporte,'') || '",';
	  ress := ress || '"observacion":"' || COALESCE(tpy_reporte.observacion_ciudadano,'') || '",';
	  ress := ress || '"orfeo":"' || COALESCE(tpy_reporte.radicado_orfeo,'') || '",';
      ress := ress || '"obs_reporte":"' || COALESCE(tpy_reporte.observacion_ciudadano,'') || '"';
      ress := ress || '}';
      
      return ress;


      EXCEPTION
        WHEN OTHERS THEN
        ress := '{}';

        return ress;

  END;
  $body$
  LANGUAGE 'plpgsql'
  VOLATILE
  CALLED ON NULL INPUT
  SECURITY INVOKER
  COST 100;
-----------------------
-- FUNCTION public.fn_set_reporte_irregular_predio
-----------------------

CREATE OR REPLACE FUNCTION public.fn_set_reporte_irregular_predio (
  p_predio varchar,
  p_tipo_reporte varchar,
  p_predial varchar,
  p_direccion varchar,
  p_nombre varchar,
  p_cedula varchar,
  p_correo varchar,
  p_telefono varchar,
  p_adjunto varchar,
  p_observacion text,
  p_ip reporte_predio.dir_ip_reporte%type,
  p_radicado_orfeo reporte_predio.radicado_orfeo%type,
  p_datos_session text
)
RETURNS text AS
$body$
  DECLARE
    _c TEXT;
    sec_insidencia INTEGER;
    contar INTEGER;
    ress TEXT;
    v_them_geo geo_predio_mc.the_geom%type;--TEXT;
    msj_tipo_reporte TEXT;
    obs_reporte TEXT;
    datos RECORD;
    result_sesion TEXT;
	v_estado TEXT;
  BEGIN
      SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
      
      ress := 'Se registro correctamente el reporte';
      --Consultar campo geo, con las coordenadas del predio     
      IF p_predio = '-1' THEN
		  v_them_geo := p_direccion;	  
	  ELSE
		  SELECT
			  gp.the_geom INTO v_them_geo
		  FROM
			  terreno tr
			  INNER JOIN geo_predio_mc gp ON gp.id_shp = tr.id_shp_p
		  WHERE
			  tr.identifica_p = p_predio;
	  END IF;
      --Consultar el nombre del estado 1: Activo 
	  /*SELECT 
		nombre_estado INTO v_estado
	  FROM
		public.estado
	  WHERE
		id_estado = 1;*/
	  
  	  INSERT INTO reporte_predio(
      	the_geom,
        tipo_reporte,
        fecha_reporte,
        predial,
        direccion_predio_reporte,
        ciudadano_reporte,
        cedula_reporte,
        telefono_reporte,
		--estado_reporte,
        foto_reporte,
		dir_ip_reporte,
        observacion_ciudadano,
		radicado_orfeo
      ) VALUES (
      	v_them_geo,
        p_tipo_reporte,
        now(),
        p_predio,
        p_direccion,
        p_nombre,
        p_cedula,
        p_telefono,
		--v_estado,
        p_adjunto,
		p_ip,
        p_observacion,
		p_radicado_orfeo
      );
             
      return ress;

      /*EXCEPTION
        WHEN OTHERS THEN
        ress := 'Ocurrio un error al registrar el reporte';
	
        return ress;*/

  END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------
-- FUNCTION public.fn_get_campo_permiso_rol_modulo
-----------------------
CREATE OR REPLACE FUNCTION public.fn_get_campo_permiso_rol_modulo (
  p_cod_modulo modulo.id_mod%type,
  p_cod_rol rol.id_rol_pk%type,
  p_cod_campo campo.id_campo%type
)
RETURNS INTEGER AS
$body$
DECLARE
	ress INTEGER;
BEGIN
	SELECT
        CASE WHEN count(*) > 0 THEN 1 ELSE 0 END INTO ress                    
    FROM 
        modulo_permiso_campo mpc
        INNER JOIN modulo_permiso mp ON mp.id_mp_pk = mpc.modulo_permiso_fk
    WHERE
    	mp.modulo_mp_fk = p_cod_modulo
        AND mp.rol_mp_fk = p_cod_rol
        AND mpc.campo_fk = p_cod_campo;

	return ress;


  	EXCEPTION
      WHEN OTHERS THEN
      ress := 0;

      return ress;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

------------------------------------------
-- FUNCTION public.fn_get_campos_rol_modulo
------------------------------------------
CREATE OR REPLACE FUNCTION public.fn_get_campos_rol_modulo (
  p_cod_modulo modulo.id_mod%type,
  p_cod_rol rol.id_rol_pk%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '[ ';
    FOR datos IN (SELECT
					  tb.id_tbl_pk AS cod_tabla,
                      tb.nombre_tbl AS nom_tabla,
                      cp.id_campo AS cod_campo,
                      cp.nombre_campo AS nom_campo,
                      public.fn_get_campo_permiso_rol_modulo(p_cod_modulo, p_cod_rol, cp.id_campo) AS estado                    
                  FROM 
                      tabla tb
                      INNER JOIN campo cp ON tb.id_tbl_pk = cp.tabla_campo_fk
                  ORDER BY tb.id_tbl_pk, cp.id_campo)
    LOOP
    	ress := ress || '{';
    	ress := ress || '"cod_tabla":"' || datos.cod_tabla || '",';
        ress := ress || '"nom_tabla":"' || datos.nom_tabla || '",';
        ress := ress || '"cod_campo":"' || datos.cod_campo || '",';
        ress := ress || '"nom_campo":"' || datos.nom_campo || '",';
        ress := ress || '"estado":"' || datos.estado || '"';
        ress := ress || '},';
                
    END LOOP;
    ress := substr(ress, 0, length(ress));
	ress := ress || ']';

	return ress;


  	EXCEPTION
      WHEN OTHERS THEN
      ress := '[ ]';

      return ress;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100;

-----------------------
-- FUNCTION public.fn_get_permisos_rol
-----------------------
CREATE OR REPLACE FUNCTION public.fn_get_permisos_rol(
	p_cod_rol rol.id_rol_pk%type
)
RETURNS TABLE (
  cod_modulo_permiso INTEGER,
  cod_modulo INTEGER,
  nom_modulo VARCHAR,
  cod_rol INTEGER,
  insertar INTEGER,
  editar INTEGER,
  consultar INTEGER,
  eliminar INTEGER,
  cod_estado INTEGER,
  campos VARCHAR
) AS
$body$
DECLARE
  _c text;
    
BEGIN		

	CREATE TEMP TABLE temp_aux_permisos_rol(
    	cod_modulo_permiso INTEGER,
        cod_modulo INTEGER,
        nom_modulo VARCHAR,
        cod_rol INTEGER,
        insertar INTEGER,
        editar INTEGER,
        consultar INTEGER,
        eliminar INTEGER,
		cod_estado INTEGER,
        campos VARCHAR
      ) ON COMMIT DROP;           
	
	
	INSERT INTO temp_aux_permisos_rol(
    	cod_modulo_permiso,
        cod_modulo,
        nom_modulo,
        cod_rol,
        insertar,
        editar,
        consultar,
        eliminar,
		cod_estado,
        campos
    )
  	SELECT
    	mp.id_mp_pk,
        md.id_mod,
        md.nombre_mod,        
        mp.rol_mp_fk,
        mp.insertar_mp,
        mp.editar_mp,
        mp.consultar_mp,
        mp.eliminar_mp,
        mp.estado_mp_fk,
        '[]' AS campos --fn_get_campos_rol_modulo(md.id_mod, p_cod_rol) AS campos        
    FROM
    	modulo_permiso mp
        INNER JOIN modulo md ON mp.modulo_mp_fk = md.id_mod
    WHERE
    	mp.rol_mp_fk = p_cod_rol
    UNION SELECT
    	-1 AS id_mp_pk,
        md.id_mod,
        md.nombre_mod,        
        p_cod_rol AS rol_mp_fk,
        0 AS insertar_mp,
        0 AS editar_mp,
        0 AS consultar_mp,
        0 AS eliminar_mp,
        1 AS estado_mp_fk,
        '[]' AS campos --fn_get_campos_rol_modulo(md.id_mod, p_cod_rol) AS campos
    FROM
    	modulo md
    WHERE
    	md.id_mod NOT IN (SELECT 
    						mpr.modulo_mp_fk 
        					FROM modulo_permiso mpr 
                            WHERE mpr.rol_mp_fk = p_cod_rol)
	ORDER BY 3 -- Ordenar por el nombre del modulo				
	;
   
      
  	RETURN QUERY    
    	SELECT 
      		*
    	FROM
     		temp_aux_permisos_rol;  
    
EXCEPTION
WHEN OTHERS THEN
  raise notice '% %', SQLERRM, SQLSTATE; 
  --GET STACKED DIAGNOSTICS _c = PG_EXCEPTION_CONTEXT;        
  CREATE TEMP TABLE temp_aux_permisos_rol(
    	cod_modulo_permiso INTEGER,
        cod_modulo INTEGER,
        nom_modulo VARCHAR,
        cod_rol INTEGER,
        insertar INTEGER,
        editar INTEGER,
        consultar INTEGER,
        eliminar INTEGER,
		cod_estado INTEGER,
        campos VARCHAR
      ) ON COMMIT DROP; 
          
  INSERT INTO temp_aux_permisos_rol(
    	cod_modulo_permiso,
        cod_modulo,
        nom_modulo,
        cod_rol,
        insertar,
        editar,
        consultar,
        eliminar,
		cod_estado,
        campos
    )
  	VALUES(
      -1,
      -1,
      '-1',
      -1,
      -1,
      -1,
      -1,
      -1,
      -1,
      '[]'
    );
  
  RETURN QUERY    
    SELECT 
      *
    FROM
     temp_aux_permisos_rol;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100 ROWS 1000;

-----------------------
-- FUNCTION public.guardar_permisos_rol
-----------------------
CREATE OR REPLACE FUNCTION public.guardar_permisos_rol (
	p_cod_modulo_permiso modulo_permiso.id_mp_pk%type,
 	p_cod_modulo modulo.id_mod%type,
  	p_cod_rol rol.id_rol_pk%type,
  	p_insertar modulo_permiso.insertar_mp%type,
    p_editar modulo_permiso.editar_mp%type,
    p_consultar modulo_permiso.consultar_mp%type,
    p_eliminar modulo_permiso.eliminar_mp%type,
    p_estado estado.id_estado%type,
    p_datos_session text
)
RETURNS modulo_permiso.id_mp_pk%type AS
$body$
DECLARE
v_cod_mp modulo_permiso.id_mp_pk%type;
result_sesion TEXT; 


BEGIN
	SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
	
	IF p_cod_modulo_permiso > 0 THEN
    	v_cod_mp := p_cod_modulo_permiso;
        UPDATE public.modulo_permiso 
        SET 
          estado_mp_fk = p_estado,
          insertar_mp = p_insertar,
          editar_mp = p_editar,
          consultar_mp = p_consultar,
          eliminar_mp = p_eliminar
        WHERE
        	id_mp_pk = v_cod_mp
        ;       
    ELSE
    	v_cod_mp := nextval('sq_modulo_permiso');
        INSERT INTO public.modulo_permiso
        (
          id_mp_pk,
          modulo_mp_fk,
          rol_mp_fk,
          fecha_creacion_mp,
          estado_mp_fk,
          insertar_mp,
          editar_mp,
          consultar_mp,
          eliminar_mp
        )
        VALUES (
          v_cod_mp,
          p_cod_modulo,
          p_cod_rol,
          now(),
          p_estado,
          p_insertar,
          p_editar,
          p_consultar,
          p_eliminar
        );    	
    END IF;
    

  	RETURN v_cod_mp;

  	EXCEPTION
  	WHEN OTHERS THEN
    	--GET STACKED DIAGNOSTICS _c = PG_EXCEPTION_CONTEXT;
    	--ress := 'error|motivo error '||SQLERRM||'codigo error '||SQLSTATE||'detalles '||_c;
        v_cod_mp := -1;
    	RETURN v_cod_mp;
    
    

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------
-- FUNCTION public.guardar_permisos_rol_campos
-----------------------
CREATE OR REPLACE FUNCTION public.guardar_permisos_rol_campos (
	p_cod_modulo_permiso modulo_permiso.id_mp_pk%type,
 	p_cod_campo campo.id_campo%type,
    p_datos_session text
)
RETURNS modulo_permiso_campo.id_mpc%type AS
$body$
DECLARE
    v_cod_mpc modulo_permiso_campo.id_mpc%type;
    result_sesion TEXT;
BEGIN
	v_cod_mpc := nextval('sq_modulo_permiso_campo');
    SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
	
	INSERT INTO public.modulo_permiso_campo
    (
      id_mpc,
      modulo_permiso_fk,
      campo_fk,
      fecha_creacion_mpc
    )
    VALUES (
      v_cod_mpc,
      p_cod_modulo_permiso,
      p_cod_campo,
      now()
    );    

  	RETURN v_cod_mpc;

  	EXCEPTION
  	WHEN OTHERS THEN
    	--GET STACKED DIAGNOSTICS _c = PG_EXCEPTION_CONTEXT;
    	--ress := 'error|motivo error '||SQLERRM||'codigo error '||SQLSTATE||'detalles '||_c;
        v_cod_mpc := -1;
    	RETURN v_cod_mpc;
    
    

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------
-- FUNCTION public.fn_get_css_no_permisos
-----------------------
CREATE OR REPLACE FUNCTION public.fn_get_css_no_permisos (
  p_cod_rol rol.id_rol_pk%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '["NA"';
    FOR datos IN (SELECT 
						md.id_mod,
                        md.key_mod,
    					mp.id_mp_pk,
                        mp.insertar_mp,
                        mp.editar_mp,
                        mp.consultar_mp,
                        mp.eliminar_mp,
                        mp.estado_mp_fk                       
    				FROM
                    	modulo md
                        INNER JOIN modulo_permiso mp ON mp.modulo_mp_fk = md.id_mod
                    WHERE
                    	mp.rol_mp_fk = p_cod_rol
						AND mp.rol_mp_fk >= 0
                        --AND mp.estado_mp_fk = 1
                    UNION SELECT 
                        md.id_mod,
                        md.key_mod,
                        -1 AS id_mp_pk,
                        0 AS insertar_mp,
                        0 AS editar_mp,
                        0 AS consultar_mp,
                        0 AS eliminar_mp,
                        2 AS estado_mp_fk                       
                    FROM
                          modulo md
                    WHERE
                    	md.id_mod NOT IN(SELECT 
                        					mdx.id_mod                     
                                          FROM
                                              modulo mdx
                                              INNER JOIN modulo_permiso mpx ON mpx.modulo_mp_fk = mdx.id_mod
                                          WHERE
                                              mpx.rol_mp_fk = p_cod_rol
											  AND mpx.rol_mp_fk >= 0
											  )
                    
    				)
    LOOP
    	IF datos.key_mod IS NOT NULL THEN
            IF datos.estado_mp_fk = 1 THEN
                IF datos.consultar_mp <> 1 THEN
                    ress := ress || ',"' || datos.key_mod ||'"';
                    ress := ress || ',"' || datos.key_mod ||'_3"';
                END IF;
                IF datos.insertar_mp <> 1 THEN
                    ress := ress || ',"' || datos.key_mod ||'_1"';
                END IF;
                IF datos.editar_mp <> 1 THEN
                    ress := ress || ',"' || datos.key_mod ||'_2"';
                END IF;
                IF datos.eliminar_mp <> 1 THEN
                    ress := ress || ',"' || datos.key_mod ||'_4"';
                END IF;
            ELSE
            	ress := ress || ',"' || datos.key_mod ||'"';
                ress := ress || ',"' || datos.key_mod ||'_1"';
                ress := ress || ',"' || datos.key_mod ||'_2"';
                ress := ress || ',"' || datos.key_mod ||'_3"';
                ress := ress || ',"' || datos.key_mod ||'_4"';
            END IF;
    	END IF;
    END LOOP;
	ress := ress || ']';

	IF	p_cod_rol < 0 THEN
    	ress :=  '["NA"]';
    END IF;
    
	return ress;


  	EXCEPTION
      WHEN OTHERS THEN
      ress := '["NA"]';

      return ress;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

 -----------------------
-- FUNCTION public.fn_get_dato_permiso_campo
-----------------------
CREATE OR REPLACE FUNCTION public.fn_get_dato_permiso_campo (
  p_dato TEXT,
  p_cod_rol rol.id_rol_pk%type,
  p_nom_campo campo.nombre_campo%type,
  p_nom_tabla tabla.nombre_tbl%type,
  p_cod_modulo modulo.id_mod%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '';
    
    SELECT 
    	count(*) INTO contar
    FROM
    	campo cp
        INNER JOIN tabla tb ON tb.id_tbl_pk = cp.tabla_campo_fk
        INNER JOIN modulo_permiso_campo mpc ON mpc.campo_fk = cp.id_campo
        INNER JOIN modulo_permiso mp ON mp.id_mp_pk = mpc.modulo_permiso_fk
    WHERE
    	cp.nombre_campo = p_nom_campo
        AND tb.nombre_tbl = p_nom_tabla
        AND mp.rol_mp_fk = p_cod_rol
		AND mp.modulo_mp_fk = p_cod_modulo;
    
    IF contar > 0 OR p_cod_rol < 0 THEN
    	ress = p_dato;
    END IF;    
    
    
	return ress;

/*
  	EXCEPTION
      WHEN OTHERS THEN
      ress := 'NA';
*/
      return ress;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;







------------------------------------------------------------------------------------------------
-- PANORAMA DE RIESGO
------------------------------------------------------------------------------------------------

---------------------------------
-- fn_get_tarea_panorama
---------------------------------
CREATE OR REPLACE FUNCTION public.fn_get_tarea_panorama (
  p_cod_panorama panorama_riesgo.id_panorama%type,
  p_cod_tarea tarea_panorama.id_tarea%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '[ ';
    FOR datos IN (SELECT
					  tp.*,
                      et.nombre_estado,
                      fl.nombre_file,
                      fl.ruta_file,
                      cp.probabilidad_cp,
                      cp.exposicion_cp,
                      cp.severidad_cp,
					  cp.proteccion_cp,
                      cp.puntaje_cp,
                      cl.nombre_clasificacion,
                      tr.nombre_tipo_riesgo,
                      te.nombre_te
                  FROM 
                      tarea_panorama_pr tp
                      INNER JOIN estado et ON et.id_estado = tp.estado_tp_fk
                      INNER JOIN calificacion_panorama cp ON cp.tarea_cp_fk = tp.id_tarea 
                      INNER JOIN tipo_ejecucion te ON te.id_tipo_ejecucion = tp.tipo_ejecucion_tp_fk
                      INNER JOIN tipo_riesgo tr ON tr.id_tipo_riesgo = tp.tipo_riesgo_tp_fk
					  INNER JOIN file fl ON fl.id_file = tp.file_tp_fk
                      INNER JOIN clasificacion_panorama cl ON cl.id_clasificacion = tp.clasificacion_tp_fk
	             WHERE
                      tp.id_tarea = CASE WHEN p_cod_tarea = -1 THEN tp.id_tarea ELSE p_cod_tarea END
                      AND tp.panorama_tp_fk = CASE WHEN p_cod_panorama = -1 THEN tp.panorama_tp_fk ELSE p_cod_panorama END
                  ORDER BY tp.id_tarea)
    LOOP    
    	ress := ress || '{';
    	ress := ress || '"codPanorama":"' || datos.panorama_tp_fk || '",';
        ress := ress || '"codTarea":"' || datos.id_tarea || '",';
        ress := ress || '"titulo":"' || datos.titulo_tarea || '",';
        ress := ress || '"codTipoRiesgo":"' || datos.tipo_riesgo_tp_fk || '",';
        ress := ress || '"nombreTipoRiesgo":"' || datos.nombre_tipo_riesgo || '",';
        ress := ress || '"codTipoEjecucion":"' || datos.tipo_ejecucion_tp_fk || '",';
        ress := ress || '"nombreTipoEjecucion":"' || datos.nombre_te || '",';
        ress := ress || '"fechaVence":"' || datos.fecha_vence_tp || '",';
        ress := ress || '"codEstado":"' || datos.estado_tp_fk || '",';
        ress := ress || '"nombreEstado":"' || datos.nombre_estado || '",';        
        ress := ress || '"foto":"",';
        ress := ress || '"observacion":"' || datos.descripcion_tarea || '",';
		ress := ress || '"mejora":"' || datos.oportunidad_mejora || '",';
        ress := ress || '"probabilidad":"' || datos.probabilidad_cp || '",';
        ress := ress || '"severidad":"' || datos.severidad_cp || '",';
        ress := ress || '"exposicion":"' || datos.exposicion_cp || '",';
        ress := ress || '"proteccion":"' || datos.proteccion_cp || '",';
        ress := ress || '"puntaje":"' || datos.puntaje_cp || '",';
        ress := ress || '"codRiesgo":"'|| datos.clasificacion_tp_fk ||'",';
        ress := ress || '"nombreRiesgo":"'|| datos.nombre_clasificacion ||'",';
        ress := ress || '"fechaCrea":"' || datos.fecha_creacion_tp || '",';
		ress := ress || '"nameFile":"' || datos.nombre_file || '",';
		ress := ress || '"patFile":"' || datos.ruta_file || '",';
        ress := ress || '"seguimiento":' || public.fn_get_seguimiento_tarea(datos.id_tarea, -1);
        ress := ress || '},';                
    END LOOP;
    ress := substr(ress, 0, length(ress));
	ress := ress || ']';

	return ress;


  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

---------------------------------
-- fn_get_seguimiento_tarea
---------------------------------
CREATE OR REPLACE FUNCTION public.fn_get_seguimiento_tarea (
  p_cod_tarea tarea_panorama.id_tarea%type,
  p_cod_seguimiento seguimiento_tarea.id_seguimiento%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
tpy_tarea tarea_panorama_pr%ROWTYPE;
cantidadRegistros INTEGER;
BEGIN
	ress := '[ ';
	cantidadRegistros := 0;
	
	--Se agrga informacion de la tarea
	IF p_cod_tarea > -1 THEN
		SELECT
			* INTO tpy_tarea
		FROM
			tarea_panorama_pr
		WHERE
			id_tarea = p_cod_tarea;
	END IF;
	
	
    FOR datos IN (SELECT
					  sg.*,
                      et.nombre_estado,
                      tp.titulo_tarea,
                      tp.panorama_tp_fk
                  FROM 
                      seguimiento_tarea sg
                      INNER JOIN estado et ON et.id_estado = sg.estado_st_fk
                      INNER JOIN tarea_panorama_pr tp ON tp.id_tarea = sg.tarea_st_fk
                  WHERE 
                  	  sg.id_seguimiento = CASE WHEN p_cod_seguimiento = -1 THEN sg.id_seguimiento ELSE p_cod_seguimiento END
                      AND sg.tarea_st_fk = CASE WHEN p_cod_tarea = -1 THEN sg.tarea_st_fk ELSE p_cod_tarea END
                  ORDER BY sg.id_seguimiento)
    LOOP
		cantidadRegistros := cantidadRegistros + 1;
    	ress := ress || '{';
    	ress := ress || '"codPanorama":"' || datos.panorama_tp_fk || '",';
        ress := ress || '"codTarea":"' || datos.tarea_st_fk || '",';
        ress := ress || '"tituloTarea":"' || datos.titulo_tarea || '",';
        ress := ress || '"codSeguimiento":"' || datos.id_seguimiento || '",';
        ress := ress || '"codEstado":"' || datos.estado_st_fk || '",';
        ress := ress || '"nombreEstado":"' || datos.nombre_estado || '",';
        ress := ress || '"foto":"' || datos.id_seguimiento || '",';
        ress := ress || '"observacion":"' || datos.observacion || '",';
        ress := ress || '"fechaCrea":"' || datos.fecha_creacion || '"';
        ress := ress || '},';
                
    END LOOP;
    ress := substr(ress, 0, length(ress));
	
	IF p_cod_tarea > -1 AND cantidadRegistros = 0 THEN
		ress := ress || '{';
    	ress := ress || '"codPanorama":"' || tpy_tarea.panorama_tp_fk || '",';
        ress := ress || '"codTarea":"' || tpy_tarea.id_tarea || '",';
        ress := ress || '"tituloTarea":"' || tpy_tarea.titulo_tarea || '",';
        ress := ress || '"codSeguimiento":"",';
        ress := ress || '"codEstado":"' || tpy_tarea.estado_tp_fk || '",';
        ress := ress || '"nombreEstado":"",';
        ress := ress || '"foto":"",';
        ress := ress || '"observacion":"",';
        ress := ress || '"fechaCrea":""';
        ress := ress || '}';
	END IF;	
	
	ress := ress || ']';

	return ress;


  	EXCEPTION
      WHEN OTHERS THEN
      ress := '[ ]';

      return ress;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------
-- FUNCTION public.fn_guardar_tarea_panorama
-----------------------

CREATE OR REPLACE FUNCTION public.fn_guardar_tarea_panorama (
  p_panorama panorama_riesgo.id_panorama%type,
  p_tarea tarea_panorama.id_tarea%type,
  p_titulo tarea_panorama.titulo_tarea%type,
  p_tipo_riesgo tipo_riesgo.id_tipo_riesgo%type,
  p_tipo_ejecucion tipo_ejecucion.id_tipo_ejecucion%type,
  p_fecha_vence tarea_panorama.fecha_vence_tp%type,
  p_estado tarea_panorama.estado_tp_fk%type,
  p_observacion tarea_panorama.descripcion_tarea%type,
  p_mejora tarea_panorama.oportunidad_mejora%type,
  p_probabilidad calificacion_panorama.probabilidad_cp%type,
  p_severidad calificacion_panorama.severidad_cp%type,
  p_exposicion calificacion_panorama.exposicion_cp%type,
  p_proteccion calificacion_panorama.proteccion_cp%type,
  p_puntaje calificacion_panorama.puntaje_cp%type,
  p_riesgo tarea_panorama_pr.calificacion%type,
  p_usuario_crea numeric,
  p_pathFile text,
  p_nameFile text,
  p_datos_session text
)
RETURNS text AS
$body$
  DECLARE
    _c TEXT;
    sec_insidencia INTEGER;
    contar INTEGER;
    ress TEXT;
    v_them_geo TEXT;
    msj_tipo_reporte TEXT;
    obs_reporte TEXT;
    datos RECORD;
    result_sesion TEXT;
    v_seq_tarea tarea_panorama.id_tarea%type;
    v_seq_file file.id_file%type;
  BEGIN
      SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;      
      ress := 'Se registro correctamente el registro';      
  	  
      IF p_tarea = -1 THEN
          --Se agrega la imagen a la tabla file
          v_seq_file := nextval('public.file_id_file_seq');      
          INSERT INTO public.file
          (
            id_file,
            nombre_file,
            ruta_file
          )
          VALUES (
            v_seq_file,
            p_nameFile,
            p_pathFile
          );     
      
      	  --Se agrega la tarea del panorama
		  v_seq_tarea := nextval('public.tarea_panorama_pr_id_tarea_seq');
          INSERT INTO public.tarea_panorama_pr
          (
            id_tarea,
            panorama_tp_fk,
            titulo_tarea,
            descripcion_tarea,
            usuario_crea_tp_fk,
            clasificacion_tp_fk,
            calificacion,
            estado_tp_fk,
            fecha_vence_tp,
            oportunidad_mejora,
            tipo_ejecucion_tp_fk,
            tipo_riesgo_tp_fk,
            file_tp_fk
          )
          VALUES (
            v_seq_tarea,
            p_panorama,
          	p_titulo,
            p_observacion,
            p_usuario_crea,
            p_riesgo,
            p_puntaje,
            p_estado,
            p_fecha_vence,
            p_mejora,
            p_tipo_ejecucion,
            p_tipo_riesgo,
            v_seq_file
          );
          
          --Se guarda la calificacion de la tarea
          INSERT INTO public.calificacion_panorama
          (
            tarea_cp_fk,
            probabilidad_cp,
            severidad_cp,
            exposicion_cp,
            proteccion_cp,
            puntaje_cp
          )
          VALUES (
            v_seq_tarea,
            p_probabilidad,
            p_severidad,
            p_exposicion,
            p_proteccion,
            p_puntaje
          );
          
	  ELSE
        --Se actulaiza el archivo de la tarea
      	UPDATE public.file 
        SET 
          nombre_file = p_nameFile,
          ruta_file = p_pathFile
         WHERE 
          id_file IN (SELECT file_tp_fk FROM tarea_panorama_pr WHERE id_tarea = p_tarea);
      
      	--Se actulaiza la tarea
      	UPDATE public.tarea_panorama_pr 
        SET 
          panorama_tp_fk = p_panorama,
          titulo_tarea = p_titulo,
          descripcion_tarea = p_observacion,
          usuario_crea_tp_fk = p_usuario_crea,
          clasificacion_tp_fk = p_riesgo,
          calificacion = p_puntaje,
          estado_tp_fk = p_estado,
          fecha_vence_tp = p_fecha_vence,
          oportunidad_mejora = p_mejora,
          tipo_ejecucion_tp_fk = p_tipo_ejecucion,
          tipo_riesgo_tp_fk = p_tipo_riesgo
        WHERE 
          id_tarea = p_tarea;
        
        --Se actualiza la calificaion de la tarea
        UPDATE public.calificacion_panorama 
        SET 
          probabilidad_cp = p_probabilidad,
          severidad_cp = p_severidad,
          exposicion_cp = p_exposicion,
          proteccion_cp = p_proteccion,
          puntaje_cp = p_puntaje
        WHERE 
          tarea_cp_fk = p_tarea;
	  END IF;
             
      return ress;
	  /*
      EXCEPTION
        WHEN OTHERS THEN
        ress := 'Ocurrio un error al registrar el reporte';
	  */
        return ress;

  END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-------------------------------------------------
--public.fn_guardar_seg_tarea
-------------------------------------------------
CREATE OR REPLACE FUNCTION public.fn_guardar_seg_tarea (
  p_datasesion text,
  p_files_delete text,
  p_files_save text,
  p_codigo_panorama integer,
  p_codigo_tarea integer,
  p_codigo_estado integer,
  p_observacion varchar
)
RETURNS varchar AS
$body$
DECLARE 
   
  ppp TEXT;
  fila_dato RECORD;
  v_codigo_seg public.seguimiento_tarea.id_seguimiento%TYPE;
  sec_file public.file.id_file%TYPE;
  v_nom_file  public.file.nombre_file%TYPE; 
  v_ruta_file  public.file.ruta_file%TYPE;
  v_retorno varchar;
  
BEGIN

   		SELECT public.fn_set_session ('cadena_session',p_datasesion) into ppp;
         v_retorno := 'Registro guardado correctamente.';
   		
        /*IF(p_files_delete <> '[]' AND p_files_delete <> '' AND p_files_delete IS NOT NULL)THEN 
         FOR fila_dato IN EXECUTE (SELECT public.fn_split_data (p_files_delete,',')) LOOP
          
           v_codigo_file := fila_dato.codigo_file;
                      
           DELETE FROM 
              multi.multi_producto_imagen 
            WHERE 
              fk_file = v_codigo_file;
              
         	DELETE FROM 
            	multi.multi_file 
          	WHERE 
            	pk_id = v_codigo_file;          	                
              
          END LOOP;
        END IF;*/   
        
       SELECT NEXTVAL('public.seguimiento_tarea_id_seguimiento_seq') INTO v_codigo_seg;                
                      
        INSERT INTO 
          public.seguimiento_tarea
        (
          id_seguimiento,
          tarea_st_fk,
          observacion,
          estado_st_fk                    
        )
        VALUES (
          v_codigo_seg,
          p_codigo_tarea,
          p_observacion,
          p_codigo_estado          
        );

		--Se actualiza el estado de la tarea del panorama
		UPDATE public.tarea_panorama_pr
		SET	estado_tp_fk = p_codigo_estado
		WHERE id_tarea = p_codigo_tarea;
         
		IF(p_files_save <> '[]' AND p_files_save <> '' AND p_files_save IS NOT NULL)THEN  
			FOR fila_dato IN EXECUTE (SELECT public.fn_json_to_query(p_files_save)) LOOP         
           
               	v_nom_file := fila_dato.nombre;
               	v_ruta_file := fila_dato.ruta;
                
                SELECT NEXTVAL('public.file_id_file_seq') INTO sec_file;
            
                INSERT INTO 
                    public.file
                  (
                    id_file,
                    nombre_file,
                    ruta_file               
                  )
                  VALUES (
                    sec_file,
                    v_nom_file,
                    v_ruta_file             
                  );
                  
                  
                  INSERT INTO 
                    public.seguimiento_tarea_file
                  (                    
                    st_stf_fk,
                    file_stf_fk
                  )
                  VALUES (
                    v_codigo_seg,
                    sec_file
                  );    
              
          END LOOP; 
       END IF;      
          
  return v_retorno;
  
 /* EXCEPTION
WHEN OTHERS THEN
    raise notice '% %', SQLERRM, SQLSTATE; 
    --GET STACKED DIAGNOSTICS _c = PG_EXCEPTION_CONTEXT;    
          
  return  
        'Se presento un error en la base de datos al momento de guardar el registro.';
    
   */ 
          
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------------------------------------------
--public.fn_validar_estado_panorama
-----------------------------------------------------------

CREATE OR REPLACE FUNCTION public.fn_validar_estado_panorama (
	cod_panorama panorama_riesgo.id_panorama%type
)
RETURNS varchar AS
$body$
DECLARE    
  ppp TEXT;
  fila_dato RECORD;
  v_tareas_incompletas INTEGER;
  v_tareas_completas INTEGER;
  v_tareas_count INTEGER;
  v_estado_get_panorama INTEGER;
  v_estado_set_panorama INTEGER;
  v_retorno varchar(50);
BEGIN
  v_retorno := 'Estado panorama ';
  --Traer estado actual del panorama de riesgo
  SELECT estado_pr_fk INTO v_estado_get_panorama
  FROM panorama_riesgo
  WHERE id_panorama = cod_panorama;
  
  --Cantidad de tareas que posee el panorama de riesgos
  SELECT count(*) INTO v_tareas_count
  FROM tarea_panorama_pr
  WHERE panorama_tp_fk = cod_panorama;
  
  --Cantidad de tareas terminadas correctamente que posee el panoramam de riesgos
  SELECT count(*) INTO v_tareas_completas
  FROM tarea_panorama_pr tr
  WHERE panorama_tp_fk = cod_panorama
  AND estado_tp_fk = 9;
  
  --Cantidad de tareas incompletas que pose el panorama de riesgos
  SELECT count(*) INTO v_tareas_incompletas
  FROM tarea_panorama_pr tr
  WHERE panorama_tp_fk = cod_panorama
  AND estado_tp_fk = 11;
  
  --Se pone el estado del panorama en estado cumplido totalmente
  IF v_tareas_count = v_tareas_completas THEN
	v_estado_set_panorama := 9;
  ELSE
	--Se pone el estado del panorama en estado incumplido
  	IF v_tareas_count = v_tareas_incompletas THEN
    	v_estado_set_panorama := 11;
    ELSE
    	--Se pone el estado del panorama en estado cumplido parcialmente
    	v_estado_set_panorama := 10;
    END IF;
  END IF;
  
  v_retorno := v_retorno || v_estado_get_panorama;
  IF v_estado_set_panorama <> v_estado_get_panorama THEN
  	v_retorno := 'Cambio estado panorama a '||v_estado_set_panorama;
  END IF;
          
  return v_retorno;
  
 /* EXCEPTION
WHEN OTHERS THEN
    raise notice '% %', SQLERRM, SQLSTATE; 
    --GET STACKED DIAGNOSTICS _c = PG_EXCEPTION_CONTEXT;    
          
  return  
        'Se presento un error en la base de datos al momento de guardar el registro.';
    
   */ 
          
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;


------------------------------------------------------
-- VISITA TECNICA
------------------------------------------------------

-----------------------------------------------------------
--public.fn_get_observacion_visita
-----------------------------------------------------------
CREATE OR REPLACE FUNCTION public.fn_get_observacion_visita (
  p_cod_visita visita_tecnica.id_vt%type,
  p_cod_observacion observacion_visita.id_ov%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '[ ';
    FOR datos IN (SELECT
					  ov.*,
                      vt.fecha_inicio_vt                      
                  FROM 
                      observacion_visita ov
                      INNER JOIN visita_tecnica vt ON vt.id_vt = ov.vt_ov_fk                      
	             WHERE
                      ov.id_ov = CASE WHEN p_cod_observacion = -1 THEN ov.id_ov ELSE p_cod_observacion END
                      AND ov.vt_ov_fk = CASE WHEN p_cod_visita = -1 THEN ov.vt_ov_fk ELSE p_cod_visita END
                  ORDER BY ov.id_ov)
    LOOP    
    	ress := ress || '{';
    	ress := ress || '"codVisita":"' || datos.vt_ov_fk || '",';
        ress := ress || '"codObservacion":"' || datos.id_ov || '",';
        ress := ress || '"fechaVisita":"' || datos.fecha_inicio_vt || '",';
        ress := ress || '"observacion":"' || datos.nombre_ov || '",';
        ress := ress || '"fileDoc":' || public.fn_get_observa_visita_file(datos.id_ov, 2) || ',';
        ress := ress || '"fileImg":' || public.fn_get_observa_visita_file(datos.id_ov, 1) || ',';
		ress := ress || '"persona":' || public.fn_get_observa_visita_persona(datos.id_ov);
        ress := ress || '},';                
    END LOOP;
    ress := substr(ress, 0, length(ress));
	ress := ress || ']';

	return ress;

  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------------------------------------------
--public.fn_set_observacion_visita
-----------------------------------------------------------

CREATE OR REPLACE FUNCTION public.fn_set_observacion_visita (
  p_cod_visita visita_tecnica.id_vt%type,
  p_cod_observacion observacion_visita.id_ov%type,
  p_observacion observacion_visita.nombre_ov%type,
  p_datos_session TEXT
)
RETURNS observacion_visita.id_ov%type AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress_id_ov observacion_visita.id_ov%type;
datos RECORD;
result_sesion TEXT;
BEGIN
	SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
	ress_id_ov := p_cod_observacion;
    
    IF p_cod_observacion < 0 THEN
        ress_id_ov := nextval('observacion_visita_id_ov_seq');
        INSERT INTO public.observacion_visita
        (
          id_ov,
          nombre_ov,
          vt_ov_fk,
          fecha_registro
        )
        VALUES (
          ress_id_ov,
          p_observacion,
          p_cod_visita,
          now()
        );
    ELSE
    	UPDATE public.observacion_visita 
        SET 
          nombre_ov = p_observacion
        WHERE 
          id_ov = p_cod_observacion
        ;    
    END IF;

	return ress_id_ov;

  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------------------------------------------
--public.fn_set_observacion_visita_file
-----------------------------------------------------------

CREATE OR REPLACE FUNCTION public.fn_set_observacion_visita_file (
  p_cod_observacion observacion_visita.id_ov%type,
  p_nombre_file file.nombre_file%type,
  p_ruta_file file.ruta_file%type,
  p_tipo_file tipo_file.id_tf%type,
  p_datos_session TEXT
)
RETURNS file.id_file%type AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress_id_file file.id_file%type;
datos RECORD;
result_sesion TEXT;
BEGIN
	SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
    ress_id_file := nextval('file_id_file_seq');
    
    --Se inserta el archivo en la tabala file
    INSERT INTO public.file
      (
        id_file,
        nombre_file,
        ruta_file,
        fecha_creacion,
        tipo_file_fk
      )
      VALUES (
        ress_id_file,
        p_nombre_file,
        p_ruta_file,
        now(),
        p_tipo_file
      );
      
      --Se inserta el registro de relacion entre el file y la observacion en la tabla file_observacion
      INSERT INTO public.file_observacion
      (
        fo_file_fk,
        ov_fo_fk
      )
      VALUES (
        ress_id_file,
        p_cod_observacion
      );      
      

	return ress_id_file;

  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;


-----------------------------------------------------------
--public.fn_get_observa_visita_persona
-----------------------------------------------------------
CREATE OR REPLACE FUNCTION public.fn_get_observa_visita_persona (
  p_cod_observacion observacion_visita.id_ov%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '[ ';
    FOR datos IN (SELECT
					  pr.*                     
                  FROM 
                      observacion_visita ov
					  INNER JOIN observacionv_persona op ON op.observacion_visita_fk = ov.id_ov
                      INNER JOIN persona pr ON pr.id_persona = op.persona_fk                      
	             WHERE
                      ov.id_ov = CASE WHEN p_cod_observacion = -1 THEN ov.id_ov ELSE p_cod_observacion END
                  ORDER BY ov.id_ov)
    LOOP    
    	ress := ress || '{';
    	ress := ress || '"documento_ovp":"' || datos.documento || '",';
        ress := ress || '"nombre_ovp":"' || datos.nombre_persona || '",';
        ress := ress || '"cargo_ovp":"' || datos.cargo || '",';
        ress := ress || '"correo_ovp":"' || datos.email || '"'
        ress := ress || '},';                
    END LOOP;
    ress := substr(ress, 0, length(ress));
	ress := ress || ']';

	return ress;

  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;


-----------------------------------------------------------
--public.fn_get_observa_visita_file
-----------------------------------------------------------
CREATE OR REPLACE FUNCTION public.fn_get_observa_visita_file (
  p_cod_observacion observacion_visita.id_ov%type,
  p_tipo_file tipo_file.id_tf%type
)
RETURNS TEXT AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress TEXT;
datos RECORD;
BEGIN
	ress := '[ ';
    FOR datos IN (SELECT
					  fl.*                     
                  FROM 
                      observacion_visita ov
					  INNER JOIN file_observacion flo ON flo.ov_fo_fk = ov.id_ov
                      INNER JOIN file fl ON fl.id_file = flo.fo_file_fk                      
	             WHERE
                      ov.id_ov = CASE WHEN p_cod_observacion = -1 THEN ov.id_ov ELSE p_cod_observacion END
					  AND fl.tipo_file_fk = CASE WHEN p_tipo_file = -1 THEN fl.tipo_file_fk ELSE p_tipo_file END
                  ORDER BY ov.id_ov)
    LOOP    
    	ress := ress || '{';
    	ress := ress || '"id_file":"' || datos.id_file || '",';
        ress := ress || '"nombre_file":"' || datos.nombre_file || '",';
        ress := ress || '"ruta_file":"' || datos.ruta_file || '",';
        ress := ress || '"tipo_file":"' || datos.tipo_file_fk || '"';
        ress := ress || '},';                
    END LOOP;
    ress := substr(ress, 0, length(ress));
	ress := ress || ']';

	return ress;

  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

-----------------------------------------------------------
--public.fn_set_observacion_visita_persona
-----------------------------------------------------------

CREATE OR REPLACE FUNCTION public.fn_set_observacion_visita_persona (
  p_cod_observacion integer,
  p_documento varchar,
  p_nombre varchar,
  p_cargo varchar,
  p_email varchar,
  p_datos_session text,
  p_firma text
)
RETURNS integer AS
$body$
DECLARE
_c TEXT;
sec_insidencia INTEGER;
contar INTEGER;
ress_id_ovp persona.id_persona%type;
datos RECORD;
result_sesion TEXT;
BEGIN
	SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
	
    IF p_cod_observacion > 0 THEN
        ress_id_ovp := nextval('persona_id_persona_seq');
        --Insertar persona
        INSERT INTO public.persona
        (
          id_persona,
          nombre_persona,
          documento,
          cargo,
          email,
          firma_persona
        )
        VALUES (
          ress_id_ovp,
          p_nombre,
          p_documento,
          p_cargo,
          p_email,
          p_firma
        );
        
		--Insertar relacion persona observacion
        INSERT INTO public.observacionv_persona
        (
          persona_fk,
          observacion_visita_fk
        )
        VALUES (
          ress_id_ovp,
          p_cod_observacion
        );
    
    END IF;

	return ress_id_ovp;

  	/*EXCEPTION
      WHEN OTHERS THEN
      ress := '[NULL]';

     return ress;*/

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

ALTER FUNCTION public.fn_set_observacion_visita_persona (p_cod_observacion integer, p_documento varchar, p_nombre varchar, p_cargo varchar, p_email varchar, p_datos_session text, p_firma text)
  OWNER TO sibica;
