<form class="container frm-seguimiento-tarea form_sibica" id="frm_seguimiento_tarea" name="frm_seguimiento_tarea">
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
        <div class="col-sm-6 col-md-4"> <label>Panorama de Riesgo No. </label> </div>
        <div class="col-sm-6 col-md-8"> <label><b><?php echo $codPanorama_sg;?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4"> <label>Tarea No. </label> </div>
        <div class="col-sm-6 col-md-8"> <label><b><?php echo $codTarea_sg;?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4"> <label>Nombre de la tarea. </label> </div>
        <div class="col-sm-6 col-md-8"> <label><b><?php echo $titulo_sg; ?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4"> <label>Seguimiento No. </label> </div>
        <div class="col-sm-6 col-md-8"> <label><b><?php echo $codSeguimiento_sg;?></b></label> </div>
    </div>
    
	<div class="row">
        <div class="col-sm-6 col-md-4"> <label class="obligatorio">Estado: </label></div>
        <div class="col-sm-6 col-md-8">
            <select id="estado_sg" name="estado_sg" class="form-control" <?php echo $attrDisabled; ?>> <?php echo $estado_sg; ?> </select>
        </div>        
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4"> <label class="obligatorio">Fecha: </label></div>
        <div class="col-sm-6 col-md-8">
            <input type="text" name="fecha_sg" id="fecha_sg" class="form-control">
        </div>        
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label class="obligatorio">Descripci&oacute;n: </label>
            <textarea id="observacion_sg" name="observacion_sg" class="form-control" <?php echo $attrDisabled; ?>><?php echo $observacion_sg; ?></textarea>
        </div>        
    </div>
    <div class="row">
        <div class="col-12 form-group">
        <label>Foto: </label>
            <input type="file" id="foto_sg" name="foto_sg[]" multiple class="file" accept="image/*">
        </div>        
    </div>
</form>
