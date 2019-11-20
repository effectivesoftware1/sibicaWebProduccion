CREATE SEQUENCE public.log_usuario_sistema_id_log_seq
MAXVALUE 2147483647;

ALTER TABLE public.log_usuario_sistema
  ALTER COLUMN id_log TYPE INTEGER;

ALTER TABLE public.log_usuario_sistema
  ALTER COLUMN id_log SET DEFAULT nextval('public.log_usuario_sistema_id_log_seq'::text);
  
  
CREATE SEQUENCE public.auditoria_id_aud_seq
MAXVALUE 2147483647;

ALTER TABLE public.auditoria
  ALTER COLUMN id_aud TYPE INTEGER;

ALTER TABLE public.auditoria
  ALTER COLUMN id_aud SET DEFAULT nextval('public.auditoria_id_aud_seq'::text);
  
  
CREATE SEQUENCE public.file_id_file_seq
MAXVALUE 2147483647;

ALTER TABLE public.file
  ALTER COLUMN id_file TYPE INTEGER;

ALTER TABLE public.file
  ALTER COLUMN id_file SET DEFAULT nextval('public.file_id_file_seq'::text);
 

 CREATE SEQUENCE public.seguimiento_tarea_id_seguimiento_seq
MAXVALUE 2147483647;

ALTER TABLE public.seguimiento_tarea
  ALTER COLUMN id_seguimiento TYPE INTEGER;

ALTER TABLE public.seguimiento_tarea
  ALTER COLUMN id_seguimiento SET DEFAULT nextval('public.seguimiento_tarea_id_seguimiento_seq'::text);
  

CREATE SEQUENCE public.seguimiento_tarea_file_id_stf_seq
MAXVALUE 2147483647;

ALTER TABLE public.seguimiento_tarea_file
  ALTER COLUMN id_stf TYPE INTEGER;

ALTER TABLE public.seguimiento_tarea_file
  ALTER COLUMN id_stf SET DEFAULT nextval('public.seguimiento_tarea_file_id_stf_seq'::text);

  
CREATE SEQUENCE public.tipo_reporte_id_tr_seq
MAXVALUE 2147483647;

ALTER TABLE public.tipo_reporte
  ALTER COLUMN id_tr TYPE INTEGER;

ALTER TABLE public.tipo_reporte
  ALTER COLUMN id_tr SET DEFAULT nextval('public.tipo_reporte_id_tr_seq'::text);  
  
  
CREATE SEQUENCE public.tipo_amoblamiento_id_ta_seq
  INCREMENT 1 MINVALUE 1
  MAXVALUE 9999999999999 START 1;
  

ALTER SEQUENCE public.tipo_amoblamiento_id_ta_seq
  INCREMENT 1 MINVALUE 1
  MAXVALUE 2147483647 START 1
  RESTART 69 CACHE 1
  NO CYCLE;
  
  
  
  
 