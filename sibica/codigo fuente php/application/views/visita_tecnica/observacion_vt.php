<form class="container frm-observacion-visita-tecnica form_sibica" id="frm_observacion_visita_tecnica" name="frm_observacion_visita_tecnica">
    <div class="row">
		<div class="col-12 texto_center">
			<h2><b>ALCALD&Iacute;A DE SANTIAGO DE CALI</b></h2>    
		</div>
	</div>
	<div class="row">
		<div class="col-12 texto_center">     
			<label>Unidad Administrativa Especial de Gesti&oacute;n de Bienes y Servicios</label> 
		</div>
	</div><br>
    <div class="row">
        <div class="col-4"> <label>Visita tectica No. </label> </div>
        <div class="col-8"> <label><b><?php echo $codVisita_ovt;?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-4"> <label>Fecha de entrada en vigencia. </label> </div>
        <div class="col-8"> <label><b><?php echo $fechaVisita_ovt;?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-4"> <label>Observaci&oacute;n No. </label> </div>
        <div class="col-8"> <label><b><?php echo $codObservacion_ovt;?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label class="obligatorio">Observaci&oacute;n: </label>
            <textarea id="observacion_ovt" name="observacion_ovt" class="form-control" maxlength="200"  <?php echo $attrDisabled; ?>><?php echo $observacion_ovt; ?></textarea>
        </div>        
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label class="">Documentos adjunto: </label>
            <div><input type="file" id="fileDoc_ovt" name="fileDoc_ovt[]" class="file" multiple accept="*" value="" <?php echo $attrDisabled; ?>></div>
        </div>
        <div class="col-6 form-group">
            <label class="">Imagenes adjunto: </label>
            <div><input type="file" id="fileImg_ovt" name="fileImg_ovt[]" class="file" multiple accept="image/*" value="" <?php echo $attrDisabled; ?>></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <div id="div_tablaObservacionPersona" class=""></div>
        </div>
    </div>
</form>
