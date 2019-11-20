<form id="form_rol" name="form_rol">
  <div class="row">
      <div class="col-sm-6">
        <label for="nom_rol">Nombre</label> 
        <input type="text" name="nom_rol" id="nom_rol" class="form-control campo-vd" maxlength="100">                     
      </div>    
      <div class="col-sm-6">
        <label for="estado_rol">Estado</label>
        <select id="estado_rol" name="estado_rol" class="form-control lista-vd">                 
          <?php echo $optEstado;  ?>
        </select>     
      </div>                 
  </div>
  <div class="row">
      <div class="col-sm-12">
        <label for="des_rol">Descripci&oacute;n</label> 
        <textarea id="des_rol" name="des_rol" class="form-control" maxlength="200"></textarea>
      </div>
  </div>
</form>
<br>
<div id="permisosRolNuevo">
</div>
