
<form class="container frm-reporte-irregular" id="reporte_irregular" name="reporte_irregular" enctype="multipart/form-data">
    <div class="row">
        <div class="col-6 form-group">
            <label>Tipo reporte</label>
            <select id="listaTipoReporte" name="listaTipoReporte" class="form-control" <?php echo $attrDisabled; ?>><?php echo $opTipoReporte; ?></select>
        </div>
        <div class="col-6 form-group">
            <label>Direcci&oacute;n</label>
            <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $direccion; ?>" <?php echo $attrDisabled; ?>>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label>N&uacute;mero predial</label>
            <input type="text" id="predial" name="predial" class="form-control" value="<?php echo $predial; ?>" <?php echo $attrDisabled; ?>> 
        </div>
        <div class="col-6 form-group">
            <label>Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>" <?php echo $attrDisabled; ?>>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label>C&eacute;dula</label>
            <input type="text" id="cedual" name="cedual" class="form-control" value="<?php echo $cedula; ?>" <?php echo $attrDisabled; ?>>
        </div>
        <div class="col-6 form-group">
            <label class="obligatorio">Correo</label>
            <input type="text" id="correo" name="correo" class="form-control" value="<?php $correo; ?>" <?php echo $attrDisabled; ?>>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label>T&eacute;lefono</label>
            <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>" <?php echo $attrDisabled; ?>>
        </div>
        <div class="col-6 form-group">
            <label>Imagen</label>
            <input type="file" id="adjunto" name="adjunto" class="form-control" value="<?php echo $telefono; ?>" <?php echo "" ?>>
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label>Observaci&oacute;n</label>
            <textarea id="observacion" name="observacion" class="form-control" <?php echo $attrDisabled; ?>><?php echo $observacion; ?></textarea>
        </div>
    </div>    
</form>