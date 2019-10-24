<form id="form_ta" name="form_ta" enctype="multipart/form-data">
  <div class="row">
      <div class="col-sm-6">
        <label for="nom_ta">Nombre</label> 
        <input type="text" name="nom_ta" id="nom_ta" class="form-control campo-vd" maxlength="100">                     
      </div>    
      <div class="col-sm-6">
        <label for="estado_ta">Estado</label>
        <select id="estado_ta" name="estado_ta" class="form-control lista-vd">                 
          <?php echo $optEstado;  ?>
        </select>     
      </div>        
  </div>
  <div class="row">
    <div class="col-12">
      <label for="file_ta">File</label>
      <input type="file" id="file_ta" name="file_ta" class="file" accept="image/*">    
    </div>
  </div>  
</form>
