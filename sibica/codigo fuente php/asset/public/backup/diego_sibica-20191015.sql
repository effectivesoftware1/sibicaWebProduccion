CREATE TABLE public.tipo_ejecucion (
  id_tipo_ejecucion SERIAL NOT NULL,
  nombre_te VARCHAR(100) NOT NULL,
  estado_te_fk INTEGER,
  PRIMARY KEY(id_tipo_ejecucion)
) 
WITH (oids = false);

-------------------------------------------------------

ALTER TABLE public.calificacion_panorama
  RENAME COLUMN panorama_cp_fk TO tarea_cp_fk;

COMMENT ON COLUMN public.calificacion_panorama.tarea_cp_fk
IS 'Campo donde se guarda la llave foranea que hace referencia a la tabla tarea_panorama';

-------------------------------------------------------

CREATE TABLE public.tipo_riesgo (
  id_tipo_riesgo SERIAL NOT NULL,
  nombre_tipo_riesgo VARCHAR(100) NOT NULL,
  estado_tr_fk INTEGER,  
  PRIMARY KEY(id_tipo_riesgo)
) 
WITH (oids = false);

-------------------------------------------------------

ALTER TABLE public.tarea_panorama_pr
  ADD COLUMN file_tp_fk INTEGER;
  
-------------------------------------------------------

CREATE SEQUENCE public.tarea_panorama_pr_id_tarea_seq
MAXVALUE 2147483647;

ALTER TABLE public.tarea_panorama_pr
  ALTER COLUMN id_tarea TYPE INTEGER;

ALTER TABLE public.tarea_panorama_pr
  ALTER COLUMN id_tarea SET DEFAULT nextval('public.tarea_panorama_pr_id_tarea_seq'::text);
  
-------------------------------------------------------

CREATE SEQUENCE public.calificacion_panorama_id_calificacion_seq
MAXVALUE 2147483647;

ALTER TABLE public.calificacion_panorama
  ALTER COLUMN id_calificacion TYPE INTEGER;

ALTER TABLE public.calificacion_panorama
  ALTER COLUMN id_calificacion SET DEFAULT nextval('public.calificacion_panorama_id_calificacion_seq'::text);
  
------------------------------------------------------

ALTER TABLE public.tarea_panorama_pr
  ALTER COLUMN panorama_tp_fk TYPE BIGINT;
  
------------------------------------------------------

-- object recreation
ALTER TABLE public.calificacion_panorama
  DROP CONSTRAINT fk_calificacion_panorama RESTRICT;

ALTER TABLE public.calificacion_panorama
  ADD CONSTRAINT fk_calificacion_panorama FOREIGN KEY (tarea_cp_fk)
    REFERENCES public.tarea_panorama_pr(id_tarea)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
	
------------------------------------------------------




