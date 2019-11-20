<form id="form_panorama" name="form_panorama" enctype="multipart/form-data">
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
     <label id="label_panorama_riesgos">Panorama de Riesgo  No. <?php echo $codigo_predio;?></label> 
     <input type="hidden" name="id_panorama_riesgos" id="id_panorama_riesgos" value="<?php echo $codigo_predio;?>"> 
   </div>
  </div>
  <div class="row form-group">      
      <div class="col-12">
        <label for="file_panorama">Cargar foto</label>
        <input type="file" id="file_panorama" name="file_panorama" class="file" accept="image/*">   
      </div> 
  </div> 
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="titulo_p">Nombre de la cuenta</label> 
        <input type="text" name="titulo_p" id="titulo_p" class="form-control campo-vd" readonly value="<?php echo $nombre_cuenta;?>">
      </div> 
      <div class="col-sm-6">
        <label for="nom_edificacion">Nombre edificaci&oacute;n</label> 
        <input type="text" id="nom_edificacion" name="nom_edificacion" class="form-control campo-vd" readonly value="<?php echo $nombreEdificacion;?>">
      </div>       
  </div> 
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="localizacion_p">Localizaci&oacute;n</label> 
        <input type="text" name="localizacion_p" id="localizacion_p" class="form-control campo-vd" readonly value="<?php echo $localizacion;?>">
      </div> 
      <div class="col-sm-6">
        <label for="fecha_inspeccion">Fecha de Inspecci&oacute;n</label> 
        <input id="fecha_inspeccion" name="fecha_inspeccion" class="form-control campo-vd" disabled value="<?php echo date('d/m/Y');?>">
      </div>       
  </div>
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="atendido_por_p" class="obligatorio">Atendido por</label> 
        <input type="text" name="p_atendido_por" id="atendido_por_p" maxlength="200" class="form-control campo-vd">
      </div> 
      <div class="col-sm-6">
        <label for="ejecutor">Inspector o ejecutor</label> 
        <input id="ejecutor" name="ejecutor" class="form-control campo-vd" disabled value="<?php echo $this->session->userdata('nombre1').' '.$this->session->userdata('apellido1');?>"> 
      </div>       
  </div>
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="responsable_p" class="obligatorio">Responsable</label> 
        <input type="text" name="responsable_p" id="responsable_p" maxlength="200" class="form-control campo-vd">
      </div> 
      <div class="col-sm-6">
        <label for="email_responsable" class="obligatorio">Email</label> 
        <input type="text" name="email_responsable" id="email_responsable" maxlength="200" class="form-control campo-vd">
      </div>       
  </div>
  <div class="row form-group">
      <div class="col-sm-6">
        <label for="descripcion_panorama" class="obligatorio">Descripci&oacute;n</label> 
        <textarea id="descripcion_panorama" name="descripcion_panorama" class="form-control"></textarea>
      </div>
      <div class="col-sm-6">
        <label for="estado_panorama">Estado</label> 
        <input type="text" data-estado = "<?php echo $codigo_estado;?>" name="estado_panorama" readonly id="estado_panorama" class="form-control campo-vd" value="<?php echo $nombre_estado;?>">
      </div>      
  </div>  
  <br>
  <div class="row">
    <div class="col-12" style="text-align: center;"> 
      <h5>LISTA DE TAREAS DE ESTE PANORAMA</h5>
    </div>
  </div>
  <div id="contenedor_table_tarea">
    <?php
      echo $tablaTarea;
    ?>
  </div>
</form>
<style type="text/css">
  #form_panorama .file-preview {   
    width: 40% !important;
  }
</style>
