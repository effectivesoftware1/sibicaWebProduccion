--------------------------
--public.fn_get_reporte_irregular_predio
--------------------------
CREATE OR REPLACE FUNCTION public.fn_get_reporte_irregular_predio (
    p_predio VARCHAR
  )
  RETURNS TEXT AS
  $body$
  DECLARE
  _c TEXT;
  sec_insidencia INTEGER;
  contar INTEGER;
  ress TEXT;
  msj_tipo_reporte TEXT;
  v_reporte public.reporte_predio%ROWTYPE;
  datos RECORD;
  BEGIN
      ress := '{';
      msj_tipo_reporte := '[';
            
      SELECT 
          count(*) INTO contar
      FROM
          terreno tr
          INNER JOIN geo_predio_mc gp ON gp.id_shp = tr.id_shp_p
          INNER JOIN reporte_predio rp ON rp.the_geom = gp.the_geom
      WHERE
          tr.identifica_p = p_predio;
          --AND rp.id_estado = 1    
      	
      
      FOR datos IN (SELECT * FROM tipo_reporte WHERE estado_tr_fk = 1)
      LOOP
          msj_tipo_reporte := msj_tipo_reporte || '{';
          msj_tipo_reporte := msj_tipo_reporte || '"id":"' || datos.id_tipo_reporte || '",';
          msj_tipo_reporte := msj_tipo_reporte || '"nombre":"' || datos.nombre_tipo_reporte || '",';
          msj_tipo_reporte := msj_tipo_reporte || '"mensaje":"' || datos.mensaje || '"';
          msj_tipo_reporte := msj_tipo_reporte || '},';
      END LOOP;
      msj_tipo_reporte := substr(msj_tipo_reporte, 0, length(msj_tipo_reporte)) || ']';
      --msj_tipo_reporte := msj_tipo_reporte || ']';
  	    
      IF contar > 0 THEN
          SELECT 
              rp.* INTO v_reporte
          FROM
              terreno tr
              INNER JOIN geo_predio_mc gp ON gp.id_shp = tr.id_shp_p
              INNER JOIN reporte_predio rp ON rp.the_geom = gp.the_geom
          WHERE
              tr.identifica_p = p_predio;
      END IF;
      
      ress := ress || '"msj_reporte":' || msj_tipo_reporte || ',';
      ress := ress || '"predial":"' || COALESCE(v_reporte.predial, '') || '",';
      ress := ress || '"direccion":"' || COALESCE(v_reporte.direccion_predio_reporte, '') || '",';
      ress := ress || '"nombre":"' || COALESCE(v_reporte.ciudadano_reporte, '') || '",';
      ress := ress || '"cedula":"' || COALESCE(v_reporte.cedula_reporte, '') || '",';
      ress := ress || '"correo":"' || COALESCE(contar::text, '') || '",';
      ress := ress || '"telefono":"' || COALESCE(v_reporte.telefono_reporte, '') || '",';
      ress := ress || '"adjunto":"' || COALESCE(v_reporte.foto_reporte, '') || '",';
      ress := ress || '"observacion":"' || COALESCE(v_reporte.observacion_ciudadano, '') || '",';
      ress := ress || '"tipo_reporte":"' || COALESCE(v_reporte.tipo_reporte, '') || '",';
      ress := ress || '"existe_reporte":' || contar || '';
      ress := ress || '}';
      
      return ress;


      /*EXCEPTION
        WHEN OTHERS THEN
        ress := '{--}';*/

        return ress;

  END;
  $body$
  LANGUAGE 'plpgsql'
  VOLATILE
  CALLED ON NULL INPUT
  SECURITY INVOKER
  COST 100;
  
--------------------------
--public.fn_set_reporte_irregular_predio
--------------------------
CREATE OR REPLACE FUNCTION public.fn_set_reporte_irregular_predio (
    p_predio VARCHAR,
    p_tipo_reporte VARCHAR,
    p_predial VARCHAR,
    p_direccion VARCHAR,
    p_nombre VARCHAR,
    p_cedula VARCHAR,
    p_correo VARCHAR,
    p_telefono VARCHAR,
    p_adjunto VARCHAR,
    p_observacion TEXT,
    p_datos_session text
  )
  RETURNS TEXT AS
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
  BEGIN
      SELECT public.fn_set_session ('cadena_session',p_datos_session) into result_sesion;
      
      ress := 'Se registro correctamente el reporte';
            
      SELECT
          gp.the_geom INTO v_them_geo
      FROM
          terreno tr
          INNER JOIN geo_predio_mc gp ON gp.id_shp = tr.id_shp_p
      WHERE
          tr.identifica_p = p_predio;
        
  	  INSERT INTO reporte_predio(
      	the_geom,
        tipo_reporte,
        fecha_reporte,
        predial,
        direccion_predio_reporte,
        ciudadano_reporte,
        cedula_reporte,
        telefono_reporte,
        foto_reporte,
        observacion_ciudadano        
      ) VALUES (
      	v_them_geo,
        p_tipo_reporte,
        now(),
        p_predial,
        p_direccion,
        p_nombre,
        p_cedula,
        p_telefono,
        p_adjunto,
        p_observacion
      );
             
      return ress;

      EXCEPTION
        WHEN OTHERS THEN
        ress := 'Ocurrio un error al registrar el reporte';
	
        return ress;

  END;
  $body$
  LANGUAGE 'plpgsql'
  VOLATILE
  CALLED ON NULL INPUT
  SECURITY INVOKER  
  COST 100;
