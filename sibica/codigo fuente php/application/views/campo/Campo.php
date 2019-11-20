<form>
  <div class="row">
    <div class="col-sm-4">
       <label for="lista_tabla" class="obligatorio">Tabla</label>
       <select id="lista_tabla" name="lista_tabla" title="Seleccione" class="form-control selectpicker" data-style="btn-sm">
       	 
       </select>
    </div>
      <div class="col-sm-4">
        <label for="lista_campo" class="obligatorio">Campos</label>
       <select id="lista_campo" name="lista_campo" multiple title="Seleccione" class="form-control selectpicker" data-style="btn-sm" data-live-search-style="startsWith">
       
       </select>
    </div>
    <div class="col-sm-4">
       <input type="button" value="Agregar" name="btn_agregarAdd" id="btn_agregarAdd" class="btn btn-primary btn-sm" style="margin-top: 3.8em;">                     
    </div>  
  </div>
</form>
<br>
<div id="contenedor_table_campo">
  <?php
    echo $tablaCampo;
  ?>
</div>