<form id="form_panorama_table" name="form_panorama_table">
  <br>
  <div class="row">
    <div class="col-12">
     <h2>ALCALD&Iacute;A DE SANTIAGO DE CALI</h2>    
   </div>
  </div>
  <br>
  <div class="row">
    <div class="col-12">     
     <label>Unidad Administrativa Especial de Gesti&oacute;n de Bienes y Servicios</label> 
   </div>
  </div>
  <div class="row">
    <div class="col-12">     
     <label>GESTI&Oacute;N DE PANORAMA DE RIESGO.</label>
   </div>
  </div>
  <br>
  <div class="row">
      <div class="col-sm-6">     
       <label>Fecha inicial</label>
       <input type="text" name="fecha_inicial" id="fecha_inicial" class="form-control campo-vd">
     </div>
     <div class="col-sm-6">     
       <label>Fecha final</label>
       <input type="text" name="fecha_final" id="fecha_final" class="form-control campo-vd">
     </div>
  </div> 
  <br> 
  <div class="row">
    <div class="col-12">     
     <input type="button" name="consultar_panorama" id="consultar_panorama" class="btn btn-primary btn-sm" value="Consultar">
   </div>
  </div>  
  <br>
  <div id="contenedor_table_panorama">
    <?php
      echo $tablaPanorama;
    ?>
  </div>
</form>