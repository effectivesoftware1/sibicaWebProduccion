INSERT INTO   public.modulo(  id_mod,  nombre_mod,  descripcion_mod,  fecha_creacion_mod,  key_mod) VALUES (  1,  'Usuaarios',  'Modulo de gestion usuarios',  now(),  'usuarios-key-css');
INSERT INTO   public.modulo(  id_mod,  nombre_mod,  descripcion_mod,  fecha_creacion_mod,  key_mod) VALUES (  2,  'Modulos',  'Modulo de gestion modulos',  now(),  'modulos-key-css');
INSERT INTO   public.modulo(  id_mod,  nombre_mod,  descripcion_mod,  fecha_creacion_mod,  key_mod) VALUES (  3,  'Roles',  'Modulo de gestion roles',  now(),  'roles-key-css');
INSERT INTO   public.modulo(  id_mod,  nombre_mod,  descripcion_mod,  fecha_creacion_mod,  key_mod) VALUES (  4,  'Tablas',  'Modulo de gestion tablas',  now(),  'tablas-key-css');
INSERT INTO   public.modulo(  id_mod,  nombre_mod,  descripcion_mod,  fecha_creacion_mod,  key_mod) VALUES (  5,  'Campos',  'Modulo de gestion campos',  now(),  'campos-key-css');
COMMIT;

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
                                              mpx.rol_mp_fk = p_cod_rol)
                    
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
PARALLEL UNSAFE
COST 100;
