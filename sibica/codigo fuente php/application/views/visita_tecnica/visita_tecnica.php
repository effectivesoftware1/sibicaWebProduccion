<form id="form_visita_tecnica" name="form_visita_tecnica" enctype="multipart/form-data">
  <div class="row">
    <div class="col-12">
     <h2>ALCALD&Iacute;A DE SANTIAGO DE CALI</h2>    
   </div>
  </div>
  <div class="row">
    <div class="col-12">     
     <label>Unidad Administrativa Especial de Gesti&oacute;n de Bienes y Servicios</label> 
   </div>
  </div>
  <div class="row">
    <div class="col-12">     
     <label id="label_id_visita_tec">Visita t&eacute;cnica  No. <?php echo $codigo_visita_tec;?></label> 
     <input type="hidden" name="id_visita_tec" id="id_visita_tec" value="<?php echo $codigo_visita_tec;?>"> 
   </div>
  </div>
  <div class="row form-group">      
      <div class="col-12">
        <label for="file_visita">Foto del predio</label>
        <input type="file" id="file_visita" name="file_visita" class="file" accept="image/*">   
      </div> 
  </div> 
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="titulo_p">Nombre de la cuenta</label> 
        <input type="text" name="titulo_p" id="titulo_p" class="form-control campo-vd" disabled value="<?php echo $nombre_cuenta;?>">
      </div> 
      <div class="col-sm-6">
        <label for="nom_edificacion">Nombre edificaci&oacute;n</label> 
        <input type="text" id="nom_edificacion" name="nom_edificacion" class="form-control campo-vd" disabled value="<?php echo $nombreEdificacion;?>">
      </div>       
  </div> 
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="localizacion_p">Localizaci&oacute;n</label> 
        <input type="text" name="localizacion_p" id="localizacion_p" class="form-control campo-vd" disabled value="<?php echo $localizacion;?>">
      </div> 
      <div class="col-sm-6">
        <label for="fecha_inspeccion">Fecha de Inspecci&oacute;n</label> 
        <input id="fecha_inspeccion" name="fecha_inspeccion" class="form-control campo-vd" disabled value="<?php echo date('d/m/Y');?>">
      </div>       
  </div>
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="atendido_por_p" class="obligatorio">Atendido por</label> 
        <input type="text" name="atendido_por_p" id="atendido_por_p" maxlength="200" class="form-control campo-vd">
      </div> 
      <div class="col-sm-6">
        <label for="ejecutor">Inspector o ejecutor</label> 
        <input id="ejecutor" name="ejecutor" class="form-control campo-vd" disabled value="<?php echo $this->session->userdata('nombre1').' '.$this->session->userdata('apellido1');?>"> 
      </div>       
  </div>
  <div class="row">
      <div class="col-sm-6">
        <label for="calidad_inmueble" class="obligatorio">Calidad del inmueble</label>
        <select id="calidad_inmueble" name="calidad_inmueble" class="form-control lista-vd"><?php echo $optCalidadInmueble?></select> 
      </div> 
      <div class="col-sm-6">
        <label for="objetivo_visita" class="obligatorio">Objetivo visita</label> 
        <textarea id="objetivo_visita" name="objetivo_visita" class="form-control"></textarea>
      </div>       
  </div>
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="fecha_ini_vt" class="obligatorio">Fecha inicio</label> 
         <input type="text" name="fecha_ini_vt" id="fecha_ini_vt"class="form-control campo-vd" readonly>
      </div>
      <div class="col-sm-6">
        <label for="tipo_visita">Tipo de visita</label>
        <select id="tipo_visita" name="tipo_visita" class="form-control lista-vd"><?php echo $optTipoVisita?></select>
      </div>      
  </div> 
  <div class="row form-group" id="div_fecha_fin_vt" style="display: none;">
      <div class="col-6">
        <label for="fecha_fin_vt" class="obligatorio">Fecha fin</label> 
         <input type="text" name="fecha_fin_vt" id="fecha_fin_vt"class="form-control campo-vd" readonly>
      </div>           
  </div> 
  <div class="row form-group" id="div_contrato" style="display: none;">
      <div class="col-sm-6">
        <label for="suscriptor" class="obligatorio">Suscriptor</label> 
        <input type="text" name="suscriptor" id="suscriptor" maxlength="100" class="form-control campo-vd">
      </div> 
      <div class="col-sm-6">
        <label for="medidor" class="obligatorio">Medidor</label> 
        <input id="medidor" name="medidor" maxlength="100" class="form-control campo-vd"> 
      </div>       
  </div> 
  <br>
  <div style="display: none;" id="div_contratos">
    <div class="row">
      <div class="col-12" style="text-align: center;">
         <h5> LISTA DE CONTRATOS</h5>
     </div>  
    </div>
    <br>
    <div class="row">
      <div class="col-12" id="contenedor_table_contratos">
        
     </div>  
    </div>      
  </div>
  <div class="row">
    <div class="col-12" style="text-align: center;"> 
      <h5>LISTA DE OBSERVACIONES DE VISITA T&Eacute;CNICA</h5>
    </div>
  </div>
  <div id="contenedor_table_vt">
    <!--<?php
      echo $tablaObsVt;
    ?>-->
  </div>
</form>
<style type="text/css">
  #form_visita_tecnica .file-preview {   
    width: 40% !important;
  }
</style>