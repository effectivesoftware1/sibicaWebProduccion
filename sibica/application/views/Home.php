<?php
   $this->load->view('header');   
?>
<script type="text/javascript">

    var g_rol_table_view = <?php echo json_encode($rolTableView); ?>;
    var g_rol_view = <?php echo json_encode($rolView); ?>;
    var g_modulo_table_view = <?php echo json_encode($moduloTableView); ?>;
    var g_modulo_view = <?php echo json_encode($moduloView); ?>;
    var g_registro_view = <?php echo json_encode($RegistroView); ?>;
    var g_usuario_table_view = <?php echo json_encode($usuarioTableView); ?>;
    var g_inicioSesion_view = <?php echo json_encode($iniciarSessionView); ?>;    
    var g_tablas_view = <?php echo json_encode($TableView); ?>;
    var g_regTablas = <?php echo json_encode($regTablas); ?>;
    var g_campos_view = <?php echo json_encode($campoView); ?>;    
    var global_tiempoMaxInact = 5;   
    var aux_glob_cod_usuario = "<?php echo  $this->session->userdata('codigo_usuario'); ?>";
    localStorage.setItem('codigo_usuario', aux_glob_cod_usuario);
    var g_ta_table_view = <?php echo json_encode($taTableView); ?>;
    var g_ta_view = <?php echo json_encode($taView); ?>;  
    
</script>
<div class="main">
	<div class="">
    	<div id="mapContainer" class="row">
    		<div class="col-12">
    			<div class="content-mapa">
                    <iframe src="http://aquila.alcaldia.gov.co/arcgis/apps/webappviewer/index.html?id=2a22d33bda2f422bb4b6a489c46010ab" frameborder="0" class="w-100 h-100">
                    </iframe>
                </div>
    		</div>
    	</div>
   </div>
 </div>
<?php
    $this->load->view('footer');
?>
<script src="<?php echo site_url() ?>asset/public/user/js/home.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/rol.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/modulo.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/login.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/tabla.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/campo.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/tipo_amoblamiento.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/reporte_irregular.js"></script>
<script src="<?php echo site_url() ?>asset/public/user/js/panorama_riesgos.js"></script>

