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
    var global_tiempoMaxInact = <?php echo intval($numeroSesion); ?>;
    var aux_glob_cod_usuario = "<?php echo  $this->session->userdata('codigo_usuario'); ?>";
    localStorage.setItem('codigo_usuario', aux_glob_cod_usuario);
    var g_ta_table_view = <?php echo json_encode($taTableView); ?>;
    var g_ta_view = <?php echo json_encode($taView); ?>;
    var g_inicioSession = <?php echo json_encode($inicioSession); ?>;
    var g_urlMapa = <?php echo json_encode($urlMapa); ?>;  
      
</script>

<div class="main">
	<div class="">
    	<div id="mapContainer" class="row">
    		<div class="col-12">
    			<div class="content-mapa">
                    <iframe src="<?php echo $urlMapa; ?>" frameborder="0" class="w-100 h-100">
                    </iframe>
                </div>
    		</div>
    	</div>
   </div>
   <form action="visita_tecnica/createFormatoVisitasPdf" id="form_excel" method="POST">
        <input type="hidden" name="codigo_visita_pdf" id="codigo_visita_pdf">
     </form>
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
<script src="<?php echo site_url() ?>asset/public/user/js/visita_tecnica.js"></script>
