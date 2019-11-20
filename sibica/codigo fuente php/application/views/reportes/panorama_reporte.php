<form id="form_panorama_report" name="form_panorama_report">
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
     <label>Reporte de panorama de riesgos entre el 20-09-30 y el 20-10-30</label>
   </div>
  </div>
  <br>
  <div class="row">
    <div class="col-12">     
     <label>Resumen</label>
   </div>
  </div>
  <div id="contenedor_table_panorama_resumen">
    <?php
      echo $tablaPanoramaResumen;
    ?>
  </div>
  <br>
  <br>
  <div class="row">
    <div class="col-12">     
     <label>General</label>
   </div>
  </div>
  <div id="contenedor_table_panorama_general">
    <?php
      echo $tablaPanoramaGeneral;
    ?>
  </div>
</form>
