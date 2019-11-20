<form class="container frm-tarea-panorama form_sibica" id="frm_tarea_panorama" name="frm_tarea_panorama">
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
        <div class="col-4"> <label>Panorama de Riesgo No. </label> </div>
        <div class="col-8"> <label><b><?php echo $codPanorama_tr;?></b></label> </div>
    </div>
    <div class="row">
        <div class="col-4"> <label>Tarea No. </label> </div>
        <div class="col-8"> <label><b><?php echo $codTarea_tr;?></b></label> </div>
    </div>
	<div class="row">
        <div class="col-4"> <label class="obligatorio">Nombre de la tarea: </label></div>
        <div class="col-8">
            <input type="text" id="titulo_tr" name="titulo_tr" class="form-control" value="<?php echo $titulo_tr; ?>" <?php echo $attrDisabled; ?>>
        </div>        
    </div>
    <div class="row">
        <div class="col-sm-4 "> <label class="obligatorio">Tipo de riesgo: </label></div>
        <div class="col-sm-6">
            <select id="tipoRiesgo_tr" name="tipoRiesgo_tr" class="form-control" <?php echo $attrDisabled; ?>> <?php echo $tipoRiesgo_tr; ?> </select>
        </div>
        <div class="col-sm-2">
            <img id="add_img_tr" name="add_img_tr" src="<?php echo base_url()?>asset/public/img/add.png" class="img-fluid rounded" style="width: 30px;cursor: pointer;" title="Agregar tipo de riesgo">
        </div>        
    </div>
    <div class="row">
        <div class="col-4"> <label class="obligatorio">Ejecuci&oacute;n a: </label></div>
        <div class="col-8">
            <select id="tipoEjecucion_tr" name="tipoEjecucion_tr" class="form-control" <?php echo $attrDisabled; ?>> <?php echo $tipoEjecucion_tr; ?> </select>
        </div>        
    </div>
    <div class="row">
        <div class="col-4"> <label class="obligatorio">Fecha de cumplimiento: </label></div>
        <div class="col-8">
            <input type="text" id="fechaVence_tr" name="fechaVence_tr" class="form-control" value="<?php echo $fechaVence_tr; ?>" <?php echo $attrDisabled; ?>>
        </div>        
    </div>
    <div class="row">
        <div class="col-4"> <label class="obligatorio">Estado: </label></div>
        <div class="col-8">
            <select id="estado_tr" name="estado_tr" class="form-control" disabled> <?php echo $estado_tr; ?> </select>
        </div>        
    </div>
    <div class="row">
        <div class="col-12 form-group">
        <label>Foto situaci&oacute;n actual: </label>
            <input type="file" id="foto_tr" name="foto_tr" class="form-control" value="<?php echo $foto_tr; ?>" <?php echo $attrDisabled; ?>>
        </div>        
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label class="obligatorio">Descripci&oacute;n situaci&oacute;n actual: </label>
            <textarea id="observacion_tr" name="observacion_tr" class="form-control" <?php echo $attrDisabled; ?>><?php echo $observacion_tr; ?></textarea>
        </div>        
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label>Oportunidad de mejora: </label>
            <textarea id="mejora_tr" name="mejora_tr" class="form-control" <?php echo $attrDisabled; ?>><?php echo $mejora_tr; ?></textarea>
        </div>        
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <table>
                <thead><tr>
                    <th>Probabilidad</th>
                    <th>Severidad</th>
                    <th>Exposici&oacute;n</th>
                    <th>Protecci&oacute;n</th>
                    <th>Puntaje</th>
                </tr></thead>
                <tbody><tr>
                    <td><input type="text" id="probabilidad_tr" name="probabilidad_tr" class="form-control" value="<?php echo $probabilidad_tr; ?>" <?php echo $attrDisabled; ?> max-length="2" onkeyup="validarMonto(this, 0, 10);" onBlur="fnCalcPuntaje();" onkeypress="return validar_solonumeros(event)"></td>
                    <td><input type="text" id="severidad_tr" name="severidad_tr" class="form-control" value="<?php echo $severidad_tr; ?>" <?php echo $attrDisabled; ?> max-length="2" onkeyup="validarMonto(this, 0, 10);" onBlur="fnCalcPuntaje();" onkeypress="return validar_solonumeros(event)"></td>
                    <td><input type="text" id="exposicion_tr" name="exposicion_tr" class="form-control" value="<?php echo $exposicion_tr; ?>" <?php echo $attrDisabled; ?> max-length="2" onkeyup="validarMonto(this, 0, 10);" onBlur="fnCalcPuntaje();" onkeypress="return validar_solonumeros(event)"></td>
                    <td><input type="text" id="proteccion_tr" name="proteccion_tr" class="form-control" value="<?php echo $proteccion_tr; ?>" <?php echo $attrDisabled; ?> max-length="2" onkeyup="validarMonto(this, 1, 10);" onBlur="fnCalcPuntaje();" onkeypress="return validar_solonumeros(event)"></td>
                    <td><input type="text" id="puntaje_tr" name="puntaje_tr" class="form-control" value="<?php echo $puntaje_tr; ?>" disabled data-riesgo="<?php echo $codRiesgo_tr;?>"></td>
                </tr></tbody>
            </table>
        </div>        
    </div>
    <div class="row">
        <div class="col-4"> <label>Riesgo. </label></div>
        <div class="col-8"> <label id="lbRiesgo_tr"><div style="padding:2px 20px;background:<?php echo $colorPuntage_tr; ?>;"><b><?php echo $riesgo_tr;?></b></div></label> </div>        
    </div>
</form>
<br>
<div id="divTablaSeguimiento_tr">
    <?php echo $tablaSeguimiento_tr;?>
</div>
