<form class="container frm-reporte-terreno" id="reporte_terreno" name="reporte_terreno" enctype="multipart/form-data">
    <div class="row">
        
        <div class="col-sm-6 col-md-3 form-group">
            <label class="">No. predio</label>
            <input type="text" id="txPredio" name="txPredio" class="form-control" value="" maxlength="30" <?php echo $attrDisabled; ?>>
        </div>
        <div class="col-sm-6 col-md-3 form-group">
            <label class="">Area cesion</label>
            <input type="text" id="txAreaCesion" name="txAreaCesion" class="form-control" value="" maxlength="30" <?php echo $attrDisabled; ?>>
        </div>        
        <div class="col-sm-6 col-md-3 form-group">
            <label>Comuna</label>
            <select id="ltComuna" name="ltComuna" class="form-control" <?php echo $attrDisabled; ?>><?php echo $ltComuna; ?></select>
        </div>
        <div class="col-sm-6 col-md-3 form-group">
            <label class="">Barrio</label>
            <select id="ltBarrio" name="ltBarrio" class="form-control" <?php echo $attrDisabled; ?>><?php echo $ltBarrio; ?></select>
        </div>
        <!--<div class="col-3 form-group">
            <label>Usuario</label>
            <select id="ltUser" name="ltUser" class="form-control" <?php echo $attrDisabled; ?>><?php echo $ltUser; ?></select>
        </div>
        <div class="col-3 form-group">
            <label class="">Fecha inicio</label>
            <input type="text" id="txFechaInicio" name="txFechaInicio" class="form-control" value="" <?php echo $attrDisabled; ?>>
        </div>
        <div class="col-3 form-group">
            <label>Fecha fin</label>
            <input type="text" id="txFechaFin" name="txFechaFin" class="form-control" value="" <?php echo $attrDisabled; ?>>
        </div>-->
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-3 form-group">
            <label class="">Tipo bien</label>
            <select id="ltTipoBien" name="ltTipoBien" class="form-control" <?php echo $attrDisabled; ?>><?php echo $ltTipoBien; ?></select>
        </div>
        <div class="col-sm-6 col-md-3 form-group">
            <label>Tipo uso</label>
            <select id="ltTipoUso" name="ltTipoUso" class="form-control" <?php echo $attrDisabled; ?>><?php echo $ltTipoUso; ?></select>
        </div>
        <div class="col-sm-12 col-md-3 form-group">
            <label class="">Calidad bien</label>
            <select id="ltCalidad" name="ltCalidad" class="form-control" <?php echo $attrDisabled; ?>><?php echo $ltCalidad; ?></select>
        </div>   
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <button type="button" id="btConsultarTerreno" name="btConsultarTerreno" class="btn btn-primary" <?php echo $attrDisabled; ?>> Consultar </button>
            <button type="button" id="btLimpiarFiltros" name="btLimpiarFiltros" class="btn btn-primary" <?php echo $attrDisabled; ?>> Limpiar filtros </button>
        </div>
    </div>
    <div id="tablaReporteTerreno" class="table-responsive">
    </div>
</form>