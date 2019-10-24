    <?php 

  defined('BASEPATH') OR exit('No direct script access allowed');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
   
  require FCPATH.'application/html2pdf/vendor/autoload.php'; 

  require 'vendor/autoload.php';

  use Spipu\Html2Pdf\Html2Pdf;
  use Spipu\Html2Pdf\Exception\Html2PdfException;
  use Spipu\Html2Pdf\Exception\ExceptionFormatter; 

  class Utilidades_model extends CI_Model{
    
     public function __construct() {
        parent::__construct();
        //$this->load->model('Inicio_model');
     }
    
     public function encrypt($str, $key){
           $block = mcrypt_get_block_size('rijndael_128', 'ecb');
           $pad = $block - (strlen($str) % $block);
           $str .= str_repeat(chr($pad), $pad);
           return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
     }

      public function decrypt($str, $key){ 
           $str = base64_decode($str);
           $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB);
           $block = mcrypt_get_block_size('rijndael_128', 'ecb');
           $pad = ord($str[($len = strlen($str)) - 1]);
           $len = strlen($str);
           $pad = ord($str[$len-1]);
           return substr($str, 0, strlen($str) - $pad);
      }
   
    
    public function createTable($idTable, $columnTable, $aux_data){
        $vTable = '<table width="100%" class="table table-striped table-bordered display cell-border" id="'.$idTable.'" cellspacing="0">';
        $vThead = '<thead><tr>';
        $vTbody = '<tbody>';

        for($z=0; $z<count($columnTable); $z++){
            $atributos_head = isset($columnTable[$z]['attribs_head']) ? $columnTable[$z]['attribs_head'] : '';
            $vThead .= '<th '.$atributos_head.'>'.$columnTable[$z]['label'].'</th>';
        }

        $vThead .= '</tr></thead>';

        $aux_contador = 1; 

        $data = is_null($aux_data) ? [] :  $aux_data; 
  
        for($y=0; $y<count($data); $y++){
            $vTbody .= '<tr>';            

            for($x=0; $x<count($columnTable); $x++){
                $labelTd = '';                
                $atributos = isset($columnTable[$x]['attribs']) ? $columnTable[$x]['attribs'] : '';                
                if(gettype($data[$y]) == 'array'){
                    //$vTbody .= '<td tabindex="'.$aux_contador.'" '.$atributos.'>'.$data[$y][$columnTable[$x]['column']].'</td>';
                    $labelTd = $data[$y][$columnTable[$x]['column']];
                }else{
                    //$vTbody .= '<td tabindex="'.$aux_contador.'" '.$atributos.'>'.$data[$y]->$columnTable[$x]['column'].'</td>';
                    $auxData = (array) $data[$y];
                    $labelTd = $auxData[$columnTable[$x]['column']];
                }

                if(isset($columnTable[$x]['format'])){
                    $formatCampTd = $this->formatCampTable($columnTable[$x]['format'], $labelTd);
                    $labelTd = $formatCampTd['label'];
                    $atributos .= $formatCampTd['attr'];
                }


                $vTbody .= '<td tabindex="'.$aux_contador.'" '.$atributos.'>'.$labelTd.'</td>';
                $aux_contador = $aux_contador+1;                
            }
            $vTbody .= '</tr>';
        }

         
        $vTbody .= '</tbody>';
        

        $vTable .= $vThead;
        $vTable .= $vTbody;
        $vTable .= '</table>';

        return $vTable;

    }
      
    //Funcion para declarar las cabeceras(COLUMNAS) de una tabla
    public function columnCbz($cbz){
        $cabecera = array(
                        'tipoPersona' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),                                    
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'parametros' => array(
                                    array('column'=>'pk_id', 'label'=>'C&oacute;digo'),
                                    array('column'=>'vch_nombre', 'label'=>'Parametro'),
                                    array('column'=>'vch_descripcion', 'label'=>'Descripci&oacute;n'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')                                 
                                ),
                        'rol' => array(                                   
                                    array('column'=>'nombre_rol', 'label'=>'Nombre'), 
                                    array('column'=>'descripcion_rol', 'label'=>'Descripci&oacute;n'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="roles-key-css_2"', 'attribs_head'=>'class="roles-key-css_2 center_th"'),
                                    array('column'=>'permisos', 'label'=>'Permisos', 'attribs'=>'class="class_permisos roles-key-css_2"', 'attribs_head'=>'class="class_permisos center_th roles-key-css_2"')
                                ),
                        'tipoArchivo' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'tipoFactura' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'estados' => array(
                                    array('column'=>'pk_id', 'label'=>'C&oacute;digo'),
                                    array('column'=>'vch_nombre', 'label'=>'Nombre'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')
                                ),
                        'tipo_nivel' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                         'tipoIdentificacion' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                         'mesa' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'pagina' => array(
                                    //array('column'=>'codigo', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre', 'label'=>'Nombre p&aacute;gina'),
                                    array('column'=>'href', 'label'=>'Enlace'),
                                    array('column'=>'orden', 'label'=>'Orden'),
                                    array('column'=>'nivel_nombre', 'label'=>'Nivel'),
                                    array('column'=>'padre_nombre', 'label'=>'P&aacute;gina padre'),
                                    array('column'=>'icono_nombre', 'label'=>'Icono'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"'),
                                    array('column'=>'permisos', 'label'=>'Permisos')
                                ),
                        'icono' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'descripcion', 'label'=>'Descripci&oacute;n'),
                                    array('column'=>'icono_menu', 'label'=>'Icono'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),                        
                        'reporte' => array(
                                    array('column'=>'identificacion', 'label'=>'Identificaci&oacute;n paciente'),
                                    array('column'=>'paciente', 'label'=>'Nombre paciente'),
                                    array('column'=>'empresa', 'label'=>'Empresa'),
                                    array('column'=>'dirEmpresa', 'label'=>'Direcci&oacute;n empresa'),
                                    array('column'=>'telefonoEmpresa', 'label'=>'Tel&eacute;fono empresa'),
                                    array('column'=>'emailEmpresa', 'label'=>'Email empresa'),
                                    array('column'=>'examen', 'label'=>'Tipo de ex&aacute;men'),
                                    array('column'=>'fechaVencimiento', 'label'=>'Fecha vencimiento')
                                ),
                        'empresa' => array(
                                    array('column'=>'nit', 'label'=>'Nit'),
                                    array('column'=>'nombre_empresa', 'label'=>'Empresa'),
                                    array('column'=>'slogan_empresa', 'label'=>'Slogan'),
                                    array('column'=>'email_empresa', 'label'=>'Email'),
                                    array('column'=>'telefonos', 'label'=>'Tel&eacute;fono(s)'),
                                    array('column'=>'celulares', 'label'=>'Celular(s)'),
                                    array('column'=>'direccion_empresa', 'label'=>'Direcci&oacute;n'),
                                    array('column'=>'ruta_logo_empresa', 'label'=>'Logo'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')
                                ),
                        'proveedor' => array(
                                    array('column'=>'nom_tipo_identificacion', 'label'=>'Tipo identificaci&oacute;n'),
                                    array('column'=>'identificacion', 'label'=>'Identificaci&oacute;n'),
                                    array('column'=>'nombre', 'label'=>'Nombre'),                                    
                                    array('column'=>'email', 'label'=>'Email'),
                                    array('column'=>'telefono', 'label'=>'Tel&eacute;fono'),
                                    array('column'=>'celular', 'label'=>'Celular'),
                                    array('column'=>'direccion', 'label'=>'Direcci&oacute;n'),                                   
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')
                                ),
                        'cliente' => array(
                                    array('column'=>'nom_tipo_identificacion', 'label'=>'Tipo identificaci&oacute;n'),
                                    array('column'=>'identificacion', 'label'=>'Identificaci&oacute;n'),
                                    array('column'=>'nombre', 'label'=>'Nombre'),                                    
                                    array('column'=>'email', 'label'=>'Email'),
                                    array('column'=>'telefono', 'label'=>'Tel&eacute;fono'),
                                    array('column'=>'celular', 'label'=>'Celular'),
                                    array('column'=>'direccion', 'label'=>'Direcci&oacute;n'),                                    
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')
                                ),
                        'usuario' => array(                                    
                                    //array('column'=>'identificacion_user', 'label'=>'Identificaci&oacute;n'),
                                    array('column'=>'nombre_usuario', 'label'=>'Nombre'),
                                    array('column'=>'correo_user', 'label'=>'Correo'),                                   
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),                                   
                                    array('column'=>'nombre_dependencia', 'label'=>'Dependencia'), 
                                    array('column'=>'nombre_rol', 'label'=>'Rol'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="usuarios-key-css_2"', 'attribs_head'=>'class="usuarios-key-css_2"')                                    
                                ),
                        'documento' => array(
                                    array('column'=>'identificacion', 'label'=>'Identificaci&oacute;n'),
                                    array('column'=>'nombre', 'label'=>'Nombre'),   
                                    array('column'=>'nombre_tipo', 'label'=>'Documento'), 
                                    array('column'=>'tipo_propietario', 'label'=>'Visualizar', 'attribs'=>'class="class_visualizar"', 'attribs_head'=>'class="class_visualizar"'),                                                                   
                                    array('column'=>'ruta_documento', 'label'=>'Descargar', 'attribs'=>'class="class_download"', 'attribs_head'=>'class="class_download"'),       
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')                                    
                                ),
                        'bitacora' => array(
                                    array('column'=>'tabla', 'label'=>'Tabla'),
                                    array('column'=>'operación', 'label'=>'Operaci&oacute;n'),   
                                    array('column'=>'dato_anterior', 'label'=>'Dato anterior'), 
                                    array('column'=>'dato_nuevo', 'label'=>'Dato nuevo'),                                                                   
                                    array('column'=>'fecha', 'label'=>'Fecha'),       
                                    array('column'=>'usuario', 'label'=>'Usuario'),
                                    array('column'=>'campo', 'label'=>'Campo'),
                                    array('column'=>'ip', 'label'=>'IP'),
                                    array('column'=>'navegador', 'label'=>'Navegador')                                                                        
                                ),
                        'tipoPermiso' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'clase', 'label'=>'Clase'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'incidencia' => array(
                                    array('column'=>'codigo_incidencia', 'label'=>'C&oacute;digo'),
                                    array('column'=>'descripcion', 'label'=>'Descripci&oacute;n'),
                                    array('column'=>'fecha', 'label'=>'Fecha'),
                                    array('column'=>'nit_empresa', 'label'=>'Nit'),                                    
                                    array('column'=>'editar', 'label'=>'Resolver', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')                                        
                                ),
                        'tipoPropietario' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'tipoPago' =>array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'ubicacion_imagen' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'tipo_proveedor' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'logUsuarios' => array(
                                    array('column'=>'usuario', 'label'=>'Usuario'),
                                    array('column'=>'fecha', 'label'=>'Fecha'),
                                    array('column'=>'ip', 'label'=>'IP'),
                                    array('column'=>'navegador', 'label'=>'Navegador')                                   
                                ),
                        'tipoDocumento' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'tipo_nombre', 'label'=>'Propietario'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),                                    
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'tipoEmpresa' => array(
                                    array('column'=>'codigo_parametro', 'label'=>'C&oacute;digo'),
                                    array('column'=>'nombre_parametro', 'label'=>'Nombre'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                                    array('column'=>'eliminar', 'label'=>'Inactivar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    
                                ),
                        'imagen' => array(
                                    array('column'=>'des_ubicacion', 'label'=>'Ubicaci&oacute;n'), 
                                    array('column'=>'ruta_foto', 'label'=>'Imagen'),                                   
                                    array('column'=>'ruta_documento', 'label'=>'Descargar', 'attribs'=>'class="class_download"', 'attribs_head'=>'class="class_download"'), 
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),                                    
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')    

                                ),
                        'producto' => array(
                                    array('column'=>'pk_id', 'label'=>'C&oacute;digo','attribs'=>'onclick="updateColumnGlobal(this)"'),
                                    array('column'=>'vch_porcentaje', 'label'=>'Incremento(%)','attribs'=>'onfocus="fnSetInputTd(this);" datae-maxlength="2" datae-onkeypress="return validar_solonumeros(event)" datae-class="setdata"'),
                                    array('column'=>'vch_descripcion', 'label'=>'Descripci&oacute;n','attribs'=>'onfocus="fnSetInputTd(this);" datae-maxlength="200" datae-class="setdata"'), 
                                    array('column'=>'dec_precio_compra', 'label'=>'Precio compra','attribs'=>'onfocus="fnSetInputTd(this);" datae-onkeypress="return validar_solonumeros(event)" datae-onkeyup="validFieldMiles(this);"  datae-onpaste="notCopyPaste(this)" datae-class="setdata"'),  
                                    array('column'=>'dec_precio_venta', 'label'=>'Precio venta','attribs'=>'onfocus="fnSetInputTd(this);" datae-onkeypress="return validar_solonumeros(event)" datae-onkeyup="validFieldMiles(this);"  datae-onpaste="notCopyPaste(this)" datae-class="setdata"'),                                    
                                    array('column'=>'int_cantidad', 'label'=>'Cantidad','attribs'=>'onfocus="fnSetInputTd(this);" datae-onkeypress="return validar_solonumeros(event)" datae-onkeyup="validFieldMiles(this);"  datae-onpaste="notCopyPaste(this)" datae-class="setdata"'), 
                                    array('column'=>'int_stock', 'label'=>'Stock','attribs'=>'onfocus="fnSetInputTd(this);" datae-onkeypress="return validar_solonumeros(event)" datae-onkeyup="validFieldMiles(this);"  datae-onpaste="notCopyPaste(this)" datae-class="setdata"'),
                                    array('column'=>'vch_cod_lector_barras', 'label'=>'C&oacute;digo barras','attribs'=>'onfocus="fnSetInputTd(this);" datae-maxlength="50" datae-class="setdata"'), 
                                    array('column'=>'fk_tipo_medida', 'label'=>'C&oacute;digo tipo medida'),
                                    array('column'=>'fk_categoria', 'label'=>'C&oacute;digo categor&iacute;a'),
                                    array('column'=>'fk_marca', 'label'=>'C&oacute;digo marca'),
                                    array('column'=>'fk_impuesto', 'label'=>'C&oacute;digo impuesto'),
                                    array('column'=>'bool_inventariable', 'label'=>'Inventariable'),
                                    array('column'=>'editar', 'label'=>'Editar','attribs'=>'class="class_delete" onkeydown="showForm(event,this)"', 'attribs_head'=>'class="class_delete center_th"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_edit" onkeydown="showForm(event,this)"', 'attribs_head'=>'class="class_edit center_th"')                                    
                                ),
                        'producto_descuento' => array(
                                    array('column'=>'id', 'label'=>'Productos'),
                                    array('column'=>'nombre_tipo_descuento', 'label'=>'Tipo descuento'),
                                    array('column'=>'descuento', 'label'=>'Valor descuento'),
                                    //array('column'=>'des', 'label'=>'Descripci&oacute;n'),                                                                     
                                    array('column'=>'nombre_periodo', 'label'=>'Tipo periodo'),  
                                    array('column'=>'codigo_periodo', 'label'=>'Periodo'),                                    
                                    array('column'=>'hora_ini', 'label'=>'Hora inicial'), 
                                    array('column'=>'hora_fin', 'label'=>'Hora final'),
                                    array('column'=>'nombre_forma', 'label'=>'Tipo forma descuento'),
                                    //array('column'=>'des_estado', 'label'=>'Estado'), 
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_delete" onkeydown="showForm(event,this)"', 'attribs_head'=>'class="class_delete center_th"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_edit" onkeydown="showForm(event,this)"', 'attribs_head'=>'class="class_edit center_th"')                                    
                        ),
                        'promociones' => array(
                            array('column'=>'codigo', 'label'=>'C&oacute;digo'), 
                            array('column'=>'nombre', 'label'=>'Nombre'),                                   
                            array('column'=>'formula', 'label'=>'Formula'), 
                            array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),                                    
                            array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')
                        ),
                        'mensajes' => array(
                                    array('column'=>'mensaje', 'label'=>'Mensaje'), 
                                    array('column'=>'nombre_tipo_anuncio', 'label'=>'Tipa anuncio'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"')
                                   ),
                        'pdf_pedido' => array(
                                    array('column'=>'codigo', 'label'=>'C&oacute;digo'), 
                                    array('column'=>'nombre', 'label'=>'Nombre'),
                                    array('column'=>'valor', 'label'=>'Valor'),
                                    array('column'=>'cantidad', 'label'=>'Cantidad'),                                    
                                    array('column'=>'subtotal', 'label'=>'Subtotal'),
                                    array('column'=>'impuesto', 'label'=>'Impuesto'),
                                    array('column'=>'descuento', 'label'=>'Descuento'),
                                    array('column'=>'promo_descuento', 'label'=>'Descuento promoci&oacute;n'),
                                    array('column'=>'total', 'label'=>'Total')
                        ),
                        'reglasPuntos'  => array(
                            array('column'=>'codigo', 'label'=>'C&oacute;digo'), 
                            array('column'=>'nombre', 'label'=>'Nombre'), 
                            array('column'=>'opredor_des', 'label'=>'Operador'), 
                            array('column'=>'puntos', 'label'=>'N&uacute;mero de puntos'),
                            array('column'=>'periodo_des', 'label'=>'Tipo periodo'), 
                            array('column'=>'hora_inicio', 'label'=>'Hora inicio'),
                            array('column'=>'hora_fin', 'label'=>'Hora fin'), 
                            array('column'=>'estado_des', 'label'=>'Estado'),
                            array('column'=>'dias_aplica_des', 'label'=>'Dias aplica'),
                            array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),                                    
                            array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')
                        ),
                        'promoProducto' => array(
                            array('column'=>'codigo_producto', 'label'=>'C&oacute;digo'), 
                            array('column'=>'nombre_producto', 'label'=>'Nombre producto'),
                            array('column'=>'periodo', 'label'=>'D&iacute;a'),
                            array('column'=>'descuento', 'label'=>'Descuento'),
                            array('column'=>'hora_inicial', 'label'=>'Hora inicial'),
                            array('column'=>'hora_final', 'label'=>'Hora final'),
                            array('column'=>'precio_anterior', 'label'=>'Precio normal'),
                            array('column'=>'precio_actual', 'label'=>'Precio con descuento','attribs'=>'style="color:red"')

                        ),
                        'alertStock' => array(
                            array('column'=>'codigo', 'label'=>'C&oacute;digo'), 
                            array('column'=>'nombre', 'label'=>'Nombre producto'),
                            array('column'=>'cantidad', 'label'=>'Cantidad'), 
                            array('column'=>'stock', 'label'=>'Stock')
                        ),
                        'producto_descuento' => array(
                            array('column'=>'id', 'label'=>'Productos'),
                            array('column'=>'nombre_tipo_descuento', 'label'=>'Tipo descuento'),
                            array('column'=>'descuento', 'label'=>'Valor descuento'),
                            //array('column'=>'des', 'label'=>'Descripci&oacute;n'),                                                                     
                            array('column'=>'nombre_periodo', 'label'=>'Tipo periodo'),  
                            array('column'=>'codigo_periodo', 'label'=>'Periodo'),                                    
                            array('column'=>'hora_ini', 'label'=>'Hora inicial'), 
                            array('column'=>'hora_fin', 'label'=>'Hora final'),
                            array('column'=>'nombre_forma', 'label'=>'Tipo forma descuento'),
                            //array('column'=>'des_estado', 'label'=>'Estado'), 
                            array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_delete" onkeydown="showForm(event,this)"', 'attribs_head'=>'class="class_delete center_th"'),
                            array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_edit" onkeydown="showForm(event,this)"', 'attribs_head'=>'class="class_edit center_th"')                                    
                        ),
                        'promociones' => array(
                            array('column'=>'codigo', 'label'=>'C&oacute;digo'), 
                            array('column'=>'nombre', 'label'=>'Nombre'),                                   
                            array('column'=>'formula', 'label'=>'Formula'),
                            array('column'=>'tipo_promo_des', 'label'=>'Tipo promoci&oacute;n'),
                            array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),                                    
                            array('column'=>'programaciones', 'label'=>'Programaciones', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit"'),
                            array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete"')
                        ),
                        'factura_entrada' => array(
                                    array('column'=>'codigo_factura', 'label'=>'Factura'),
                                    array('column'=>'fecha_creacion', 'label'=>'Fecha'),
                                    array('column'=>'identificacion_prestador', 'label'=>'Identificaci&oacute;n proveedor'),
                                    array('column'=>'nombre', 'label'=>'Nombre proveedor'),                                                                                                        
                                    //array('column'=>'observacion', 'label'=>'observaci&oacute;n'),  
                                    array('column'=>'nombre_tipo_pago', 'label'=>'Tipo pago'),                                    
                                    array('column'=>'nombre_estado', 'label'=>'Estado pago'), 
                                    array('column'=>'ruta', 'label'=>'Factura', 'attribs'=>'class="class_visualizar"', 'attribs_head'=>'class="class_visualizar center_th"'), 
                                    array('column'=>'abono', 'label'=>'Abonar', 'attribs'=>'class="class_save"', 'attribs_head'=>'class="class_save center_th"'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"'),
                                    array('column'=>'descargarPdf', 'label'=>'Pdf', 'attribs'=>'class="class_download"', 'attribs_head'=>'class="class_download center_th"')

                                                                        
                        ),
                        'factura_salida' => array(
                                    array('column'=>'codigo_factura', 'label'=>'Factura'),
                                    array('column'=>'fecha_creacion', 'label'=>'Fecha'),
                                    array('column'=>'nombre_cliente', 'label'=>'Cliente'),                                    
                                    array('column'=>'ruta', 'label'=>'Recibo','attribs'=>'class="class_visualizar"', 'attribs_head'=>'class="class_visualizar center_th"'), 
                                    array('column'=>'descargarPdf', 'label'=>'Pdf factura', 'attribs'=>'class="class_download"', 'attribs_head'=>'class="class_download center_th"'),                                    
                        ),
                        'factura_salida_pago' => array(
                                    array('column'=>'codigo_factura', 'label'=>'Factura'),
                                    array('column'=>'fecha_creacion', 'label'=>'Fecha'),
                                    array('column'=>'nombre_cliente', 'label'=>'Cliente'),                                                                      
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"'),
                                    array('column'=>'descargarPdf', 'label'=>'Pdf', 'attribs'=>'class="class_download"', 'attribs_head'=>'class="class_download center_th"')
                                    
                        ),
                        'programacion_promo' => array(
                            array('column'=>'codigo', 'label'=>'C&oacute;digo'),
                            array('column'=>'nombre', 'label'=>'Nombre programaci&oacute;gn'),
                            array('column'=>'periodo_txt', 'label'=>'Periodo'),
                            array('column'=>'aplica_txt', 'label'=>'Dia aplica'),
                            array('column'=>'hora_inicio', 'label'=>'Hora inicio'),
                            array('column'=>'hora_fin', 'label'=>'Hora fin'),
                            array('column'=>'estado_txt', 'label'=>'Estado'),                           
                            array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"'),
                            array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                        ),
                        'inventario' => array(
                            array('column'=>'codigo', 'label'=>'C&oacute;digo'),  
                            array('column'=>'nombre', 'label'=>'Nombre'), 
                            array('column'=>'descripcion', 'label'=>'Descripci&oacute;n'),
                            array('column'=>'cantidad', 'label'=>'Cantidad'),
                            array('column'=>'precio', 'label'=>'Precio'),
                            array('column'=>'marca', 'label'=>'Marca'),
                            array('column'=>'categoria', 'label'=>'Categoria')
                        ),
                        'closter' => array(
                            array('column'=>'closter', 'label'=>'Closter'),  
                            array('column'=>'producto', 'label'=>'Producto'), 
                            array('column'=>'porcentaje', 'label'=>'Porcentaje'),
                            array('column'=>'valor', 'label'=>'Valor'),
                            array('column'=>'cliente', 'label'=>'Cliente'),
                            array('column'=>'precio_producto', 'label'=>'Precio producto')                            
                        ),
                        'modulo' => array(                                   
                                    array('column'=>'nombre_mod', 'label'=>'Nombre'), 
                                    array('column'=>'descripcion_mod', 'label'=>'Descripci&oacute;n'),                                    
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"'),
                                    array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                                ),
                        'tabla' => array(                                   
                                    array('column'=>'tablename', 'label'=>'Nombre')                                    
                                    //array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                                ),
                        'campo' => array(                                   
                                    array('column'=>'nombre_tbl', 'label'=>'Tabla'),
                                    array('column'=>'nombre_campo', 'label'=>'Campo')                                      
                                    //array('column'=>'eliminar', 'label'=>'Eliminar', 'attribs'=>'class="class_delete"', 'attribs_head'=>'class="class_delete center_th"')
                        ),
                        'rol_permisos' => array(
                            array('column'=>'nom_modulo', 'label'=>'Modulo'), 
                            array('column'=>'ch_insertar', 'label'=>'Insertar', 'attribs'=>'class="center_th"'),
                            array('column'=>'ch_editar', 'label'=>'Editar', 'attribs'=>'class="center_th"'),
                            array('column'=>'ch_consultar', 'label'=>'Consultar', 'attribs'=>'class="center_th"'),
                            array('column'=>'ch_eliminar', 'label'=>'Eliminar', 'attribs'=>'class="center_th"'),
                            array('column'=>'bt_campos', 'label'=>'Campos', 'attribs'=>'class="center_th"')
                        ),
                        'tipo_amoblamiento' => array(                                   
                                    array('column'=>'nombre_ta', 'label'=>'Nombre'), 
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="tipo-amobl-key-css_2"', 'attribs_head'=>'class="tipo-amobl-key-css_2 center_th"')
                                ),
                        'panorama' => array(                                   
                                    array('column'=>'id_panorama', 'label'=>'Panorama'), 
                                    array('column'=>'nom_edificacion', 'label'=>'Edificaci&oacute;n'),
                                    array('column'=>'fecha_creacion', 'label'=>'F.Inspecci&oacute;n'),
                                    array('column'=>'nombre_estado', 'label'=>'Estado'),
                                    array('column'=>'inspector', 'label'=>'Inspector'),
                                    array('column'=>'usuario_responsable', 'label'=>'Responsable'),
                                    array('column'=>'editar', 'label'=>'Acciones', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        ),
                        'tarea_panorama' => array( 
                                    array('column'=>'nombreTipoRiesgo', 'label'=>'Tipo riesgo'),
                                    array('column'=>'titulo', 'label'=>'Nombre'), 
                                    array('column'=>'nombreTipoEjecucion', 'label'=>'Plazo'),
                                    array('column'=>'fechaVence', 'label'=>'Vence'),
                                    array('column'=>'nombreEstado', 'label'=>'Estado'),
                                    array('column'=>'puntaje', 'label'=>'Puntaje'),         
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')
                        ),
                        'seguimiento_tarea' => array(                                   
                                    array('column'=>'codSeguimiento', 'label'=>'No. seguimiento'),
                                    array('column'=>'tituloTarea', 'label'=>'Nombre tarea'), 
                                    array('column'=>'nombreEstado', 'label'=>'Estado'),
                                    array('column'=>'observacion', 'label'=>'Descripci&oacute;n'),
                                    array('column'=>'editar', 'label'=>'Editar', 'attribs'=>'class="class_edit"', 'attribs_head'=>'class="class_edit center_th"')

                        )                        
                    );
        

        return $cabecera[$cbz];
    }

   /*funcion para enviar correos 1*/

    public function enviarEmail($de,$para,$asunto,$mensaje){
        //configuracion para gmail
          $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ever.hidalgo22@gmail.com',
            'smtp_pass' => 'gomez34671503',
            'smtp_crypto' => 'ssl',
            'mailtype' => 'html',
            'smtp_timeout' => '4',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE // cambio ever 18-07-2018
          ); 

          //cargamos la configuración para enviar con gmail
          $this->email->initialize($configGmail);

          $this->email->from($de);
          $this->email->to($para);          
          $this->email->subject($asunto);
          $this->email->message("<h2>Reporte de insidencias</h2><hr><br>".$mensaje);
          $envio = $this->email->send();         

          return $envio;


     }

     /*funcion para enviar correos 2*/

   public function enviarEmail2($from,$to,$asunto,$mensaje,$name,$pdf,$name_file){

          //set_time_limit(120);
          $aux_host = $this->getParametro(36)->result;
          $aux_username = $this->getParametro(37)->result;
          $aux_pass = $this->getParametro(38)->result;          
                    
          $mail = new PHPMailer();            

          //$mail->SMTPDebug  = 2; 
          $mail->IsSMTP(); 
          $mail->Timeout =   120;         
          $mail->Host = $aux_host;
          $mail->SMTPAuth = true;
          $mail->Username = $aux_username;  // Correo Electrónico
          $mail->Password = $aux_pass; // Contraseña
          $mail->SMTPSecure = 'tls';          
          $mail->Port = 587;           
          
          //configurar email 
          $mail->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );        
          $mail->SetFrom($from, $name);
          $mail->AddAddress($to);
          $mail->isHTML(true); 
          $mail->Subject  =  $asunto;
          $mail->CharSet = 'UTF-8';
          $mail->Body = $mensaje; //"Nombre: $name \n<br />".  
           if($pdf != ""){            
              $mail->addStringAttachment($pdf,$name_file);
           }      
          //$mail->WordWrap = 50; 

          if ($mail->Send()){
            $result = "OK";
          }else{
            $result = "NO";
          }

          $mail->SmtpClose();         

         return $result;


   }  
     /*funcion para subir archivos*/
     public function UploadFile($path,$nameImg, $typeFiles){ 
        $retorno="";        
        $config['upload_path'] = $path;                    
        $config['allowed_types'] = $typeFiles;
        $config['encrypt_name'] = false;
        $config['file_name'] = rand(10,100000) .'_'. $_FILES[$nameImg]["name"];       
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($nameImg)){
            $error = $this->upload->display_errors();
            $retorno=$error;           
            return false;
        }
        else{
            $file_data = $this->upload->data();
            return $file_data['file_name'];
        }
      }    

   /*esta funcion envia en el parametro where la condicion que quiero que se cumpla*/

    public function generarComboWhere($id, $tabla, $campo1, $campo2, $order, $seleccione, $where, $firtsMayus, $objAttr) {
        /*
            Descripción de parametros.
            -----------------------------------------------------------------------------------------------------------
            id : Identificador del selector
            tabla : Tabla de la db donde se consultan los datos
            campo1 : campo identificador (PK_ID), este es el value de la opcion en el selector
            campo2 : campo texto visual (DESCRIPCION), este es el html de la opcion en el selector
            order : campo por el que se va ha ordenar (1=PK_ID, 2=DESCRIPCION)
            seleccione : campo adicional a los items de la lista (''=null, ' '=item vacio, 'Selecione...'= item texto)
            where : condicion sql para filtrar registros consultados
            firtsMayus : formatea texto a, preimera letra en mayusculas y el resto en minusculas (true/false)
            objAttr : objecto con atribitos a añadir a la etiqueta select ("attributo"=>"valor_atributo")
        */

        $atributos = '';
        $seleccionar = '';
        foreach ($objAttr as $atributo => $value) {
            if($atributo != '_SELECCIONAR_'){
                $atributos .= $atributo.'="'.$value.'" ';
            }else{
                $seleccionar = $value;
            }
            
        }
        
        $valorIni = $seleccione;
        $selInicio = '<select name="'.$id.'" id="'.$id.'" '.$atributos.'>';
        $selFin = "</select>";
        $cadena = "";
        
        if($valorIni != ''){
            $cadena = $cadena . '<option value ="-1" selected>' . $valorIni . '</option>';
        }                

        try {
            $aux_array_coleccion = array('campo1' => $campo1,
                                         'campo2' => $campo2,
                                         'tabla'  => $tabla,
                                          'where'  => $where);

            $cadenaQuery = "SELECT DISTINCT codigo, nombre FROM public.fn_get_coleccion_where(?,?,?,?)";            
            
            $cadenaQuery = $cadenaQuery ." ORDER BY ".$order;

            $data=$this->db->query($cadenaQuery,$aux_array_coleccion);

            if ($data->num_rows() > 0) {
              
                foreach ($data->result() as  $fila) {
                    $selected = $seleccionar == $fila->codigo ? 'selected' : '';

                    if($firtsMayus){
                        $cadena = $cadena . '<option value="' . $fila->codigo .'" '.$selected.' >' .mb_convert_case($fila->nombre, MB_CASE_TITLE, 'UTF-8').'</option>';
                    }else{
                        $cadena = $cadena . '<option value="' . $fila->codigo .'" '.$selected.' >' . $fila->nombre .'</option>'; 
                    }
                }                
              
            }

            if($id != ''){
                    $cadena = $selInicio . $cadena . $selFin;
            }

            return $cadena;

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }   

    public function UploadImage($path,$nameImg, $typeFiles){

        $retorno="";        
        $config['upload_path'] = $path;                    
        $config['allowed_types'] = $typeFiles;
        $config['encrypt_name'] = false; 
        $config['max_size'] = '10240000000';
        $config['file_name'] = rand(10,100000).'_'.$this->limpiarCaracteresEspeciales($_FILES[$nameImg]["name"]);   
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($nameImg)){
            $error = $this->upload->display_errors();
            $retorno=$error;                     
            return false;
        }
        else{
            $file_data = $this->upload->data();
            return $file_data['file_name'];
        }
      }     

    /*Obtener ip*/
    public function getRealIpAddr() {
        
          if (isset($_SERVER["HTTP_CLIENT_IP"]))
            {
                return $_SERVER["HTTP_CLIENT_IP"];
            }
            elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
            {
                return $_SERVER["HTTP_X_FORWARDED"];
            }
            elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_FORWARDED"]))
            {
                return $_SERVER["HTTP_FORWARDED"];
            }
            else
            {
                return $_SERVER["REMOTE_ADDR"];
            }
    }


    
    public function getBrowser($user_agent){

        if(strpos($user_agent, 'MSIE') !== FALSE)
           return 'Internet explorer';
         elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
           return 'Microsoft Edge';
         elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
            return 'Internet explorer';
         elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
           return "Opera Mini";
         elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
           return "Opera";
         elseif(strpos($user_agent, 'Firefox') !== FALSE)
           return 'Mozilla Firefox';
         elseif(strpos($user_agent, 'Chrome') !== FALSE)
           return 'Google Chrome';
         elseif(strpos($user_agent, 'Safari') !== FALSE)
           return "Safari";
         else
           return 'No hemos podido detectar su navegador';


     }

     public function getDataSesion(){

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $user = $this->session->userdata('login_usuario');
        if(!$user){
            $user = 'sistema';
        }
        $browser = $this->Utilidades_model->getBrowser($user_agent);
        $ip = $this->Utilidades_model->getRealIpAddr();
        $result = array(
                        "user" => $user,
                        "browser" => $browser,
                        "ip" => $ip
                    );

        $retorno = $result['user'].'='.$result['ip'].'='.$result['browser'];

        return $retorno;

    } 

    /*funcion para darle formato de miles a un valor numerico*/

    function formatMiles($valor){
        $valCampo = str_replace('.','',$valor);
        $cadenaMiles = '';
        $contarMiles = 0;
        for($v=strlen($valCampo); $v>0; $v--){
            //console.log('VAR_V ->',v, ' = ',valCampo[v-1]);
            
            if($contarMiles % 3 == 0){
              $cadenaMiles = $valCampo[$v-1] . '.' .$cadenaMiles;
            }else{
              $cadenaMiles = $valCampo[$v-1] .''. $cadenaMiles;
            }
            $contarMiles++;
        }
        
        return substr($cadenaMiles, 0, strlen($cadenaMiles)-1);
    } 

      

    public function replaceCharSpec($str){ 

        $resReplace = str_replace('á','a',$str);
        $resReplace = str_replace('é','e',$resReplace);
        $resReplace = str_replace('í','i',$resReplace);
        $resReplace = str_replace('ó','o',$resReplace);
        $resReplace = str_replace('ú','u',$resReplace);
        $resReplace = str_replace('ñ','n',$resReplace);
        $resReplace = str_replace('Á','A',$resReplace);
        $resReplace = str_replace('É','E',$resReplace);
        $resReplace = str_replace('Í','I',$resReplace);
        $resReplace = str_replace('Ó','O',$resReplace);
        $resReplace = str_replace('Ú','U',$resReplace);
        $resReplace = str_replace('Ñ','N',$resReplace);
        $resReplace = str_replace('/','_',$resReplace);
        $resReplace = strtoupper($resReplace);
      
        return $resReplace;
    } 

   /*funcion para limpiar todos los caracterres especiales de una cadena*/
   public function limpiarCaracteresEspeciales($string ){
     $string = htmlentities($string);
     $string = preg_replace('/\&(.)[^;]*;/', '\1', $string);
     return $string;
   }    

   public function validaSession() {
        $codUser = $this->session->userdata('codigoUsuario');
        if(!$codUser){
            $this->llenarSesionInvitado();
            redirect('Home');
        }
   }

    public function getKeyIp(){
        $ipAddr = $_SERVER['REMOTE_ADDR'];
        $mes = date("m");
        $dia = date("d");
        $ipNum = str_replace(":","",str_replace(".", "", $ipAddr));
        $keyIp =  '-8'. $ipNum . $mes . $dia;
        $ressKey = intval($keyIp);
        //var_dump($ressKey);
        return  $ressKey;
    }

    public function encryptArgon2($cadena){
       $cadena_encrypt = password_hash($cadena, PASSWORD_ARGON2I);

       return $cadena_encrypt;
   }


   function getDateTime($date, $format){
        $datoFecha = '';

        if($date == '-1' || $date == ''){
            $datoFecha = date($format, time());
        }else{
            $datoFecha = date($format, $date);
        }
        
        return $datoFecha;
    }

    function llenarSesionInvitado(){
        $rolInvitado = 0;
        $result = $this->getDataPermisoRol($rolInvitado);
        $modulosNoAplica = json_decode($result->modulos_no_aplica, true);
        $datosUsuario= array(/*'codigoUsuario' => $result->id_user_pk,                                
                            'identificacion' => $result->identificacion_user,
                            'nombre1' => mb_convert_case($result->primer_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                            'nombre2' => mb_convert_case($result->segundo_nombre_user, MB_CASE_TITLE, "UTF-8"),                                
                            'apellido1' => mb_convert_case($result->primer_apellido_user, MB_CASE_TITLE, "UTF-8"),
                            'apellido2' => mb_convert_case($result->segundo_apellido_user, MB_CASE_TITLE, "UTF-8"),                               
                            'email' => $result->correo_user,                               
                            'codigo_rol' => $rolInvitado,*/
                            'modulos_no_aplica_arr' => $modulosNoAplica,
                            'modulos_no_aplica' => $this->getCalssPageNot($modulosNoAplica)
                            );
        
        $this->session->set_userdata($datosUsuario);

    }

    public function getDataPermisoRol($rol){
        $query = "SELECT
                    fn_get_css_no_permisos(".$rol.") AS modulos_no_aplica
                  ";

        $result = $this->db->query($query); 
        $datos = array();     

        if ($result->num_rows() > 0) {
             $datos = $result->row(); 
        }

        return  $datos;
    }


    public function getCalssPageNot($modulos){
        $str_class = '';
        $obj_modulos = $modulos;
  
        for($p=0; $p<count($obj_modulos); $p++){
            $str_class .= '.'.$obj_modulos[$p].'{ display:none !important; } ';
        }

        return $str_class;
    }

   
     
 }

 ?>
   

     
