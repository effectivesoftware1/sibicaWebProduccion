<form>
  <div class="row">
    <div class="col-sm-6">
       <select id="lista_tabla" name="lista_tabla" multiple title="Seleccione" class="form-control selectpicker" data-style="btn-sm" data-live-search-style="startsWith">
       	 <?php
      		echo $optionTabla;
    		  ?>
       </select>
    </div>
    <div class="col-sm-6">
       <input type="button" value="Agregar" name="btn_agregarAdd" id="btn_agregarAdd" class="btn btn-primary btn-sm">                     
    </div>  
  </div>
</form>
<br>
<div id="contenedor_table_tabla">
  <?php
    echo $tabla;
  ?>
</div>