<form class="container frm-observacion-visita-persona form_sibica" id="frm_observacion_visita_persona" name="frm_observacion_visita_persona">
    <div class="row">
        <div class="col-6 form-group">
            <label class="obligatorio">N&uacute;mero de documento: </label>
            <div><input type="text" id="documento_ovp" name="documento_ovp" class="form-control" maxlength="12" value="" <?php echo $attrDisabled; ?>></div>
        </div>
        <div class="col-6 form-group">
            <label class="obligatorio">Nombre: </label>
            <div><input type="text" id="nombre_ovp" name="nombre_ovp" class="form-control" maxlength="100" value="" <?php echo $attrDisabled; ?>></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label class="obligatorio">Cargo: </label>
            <div><input type="text" id="cargo_ovp" name="cargo_ovp" class="form-control" maxlength="100" value="" <?php echo $attrDisabled; ?>></div>
        </div>
        <div class="col-6 form-group">
            <label class="obligatorio">Correo: </label>
            <div><input type="text" id="correo_ovp" name="correo_ovp" class="form-control" maxlength="100" value="" <?php echo $attrDisabled; ?>></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label id="msj_ovp"></label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10">
            <label class="obligatorio">Firmar contrato</label>           
            <div id="signature"></div>          
        </div>        
    </div> 
     <div class="row">
        <div class="col-6">           
            <input type="button" name="clearsignature" id="clearsignature" value="Limpiar firma" class="btn btn-primary btn-sm">         
        </div>        
    </div>    
</form>

