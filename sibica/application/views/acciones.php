<?php
   $this->load->view('header');   
?>
<script type="text/javascript">
    const global_tiempoMaxInact = 5;   
    const g_tipo_accion = "<?php echo $accion; ?>";  
    const g_cod_predio = "<?php echo $predio; ?>";
    const g_cod_predio_const = "<?php echo $predio_const; ?>";
    const g_url_doc = "<?php echo $url_doc; ?>";
    var g_inicioSesion_view = <?php echo json_encode($iniciarSessionView); ?>;

</script>

<div class="main">

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

<script type="text/javascript">
	llamarAccionPoligono(g_tipo_accion, g_cod_predio, g_cod_predio_const, g_url_doc);
</script>