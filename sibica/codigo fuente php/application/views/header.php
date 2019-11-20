<!DOCTYPE html>
<html>
<head>
  <?php    
      $nombre = $this->session->userdata('nombre1').' '.$this->session->userdata('apellido1');
      $rol = $this->session->userdata('codigo_rol');
      $classModulosNoAplica_arr = $this->session->userdata('modulos_no_aplica_arr');
      $str_classModulosNoAplica_css = $this->session->userdata('modulos_no_aplica');
  ?>

  <script type="text/javascript">
      g_codigo_rol = <?php echo  json_encode($rol) ?>;
      g_modulos_no_aplica = <?php echo  json_encode($classModulosNoAplica_arr) ?>;
  </script>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sibica</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Resale Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
  <meta name="viewport"  content="initial-scale=1,maximum-scale=1,user-scalable=no" /> 
  
   <!-- Font Awesome 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link href="<?php echo base_url()?>asset/public/images/favicon.png" rel="icon" type="image/png"/>  
-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>vendor/components/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">  

  <!-- Material Design Bootstrap -->  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/mdb.min.css" rel="stylesheet" type="text/css"> 
  <!-- Your custom styles (optional) -->  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/style.css" rel="stylesheet" type="text/css">  
    
  <!--datatables -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">     
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/dataTables.foundation.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/dataTables.semanticui.min.css" rel="stylesheet" type="text/css">  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/colReorder.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/colReorder.dataTables.min.css" rel="stylesheet" type="text/css">     
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/colReorder.foundation.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/colReorder.jqueryui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/colReorder.semanticui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
  
  <!-- tables responsive -->   
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/responsive.dataTables.min.css" rel="stylesheet" type="text/css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/responsive.foundation.min.css" rel="stylesheet" type="text/css"> 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/responsive.jqueryui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/datatable/responsive.semanticui.min.css" rel="stylesheet" type="text/css">
  
  <!-- boostrap select --> 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>vendor/snapappointments/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">  
 
  <!-- date picker -->
  <link href="<?php echo base_url()?>asset/public/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
   
  <!-- alertify -->
  <link href="<?php echo base_url()?>asset/public/css/alertify/alertify.min.css" rel="stylesheet" type="text/css"/>
   
  <link href="<?php echo base_url()?>asset/public/user/css/styles_general.css" rel="stylesheet" type="text/css"/>
  <link  rel="stylesheet"   href="https://js.arcgis.com/4.12/esri/themes/light/main.css" />

  <!-- incons awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css" rel="stylesheet" type="text/css"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/fontawesome.css" rel="stylesheet" type="text/css"/>
   
  <!-- input file --> 
  <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/fileinput.css" rel="stylesheet" type="text/css"> --> 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/file-boostrap-2/fileinput.css" rel="stylesheet" type="text/css">   
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>asset/public/css/file-boostrap-2/themes/explorer-fas/theme.css" rel="stylesheet" type="text/css">   
   
  <!-- se agregan clases para no visualizar en el menu los modulos a los que el usuario no tiene permisos -->
  <style> <?php echo $str_classModulosNoAplica_css; ?> </style>	

</head>
<body class="quit-scroll">
<!--INICIO SESSION -->
<div id="menu_inicio_sesion" class="inicio-session">
      <li class="nav-item dropdown" id="li_user_logueado" style="display:none;">
        <span class="text mouse-vinculo" title="Descargar app SIBICA Google Store" onclick="descargarAppMobile(1);"><img src="./asset/public/img/googlestore.png" class="img-dowload"></span>
        <span class="text mouse-vinculo" title="Descargar app SIBICA Apple Store" onclick="descargarAppMobile(2);"><img src="./asset/public/img/applestore.png" class="img-dowload"></span>
        <span class="text mouse-vinculo" title="Reportar irregularidad" onclick="reportarIrregular(-1);"><img src="./asset/public/img/seguridad.png" class="img-dowload"></span>
        <!--<span class="text mouse-vinculo" title="Descargar app SIBICA Google Store" onclick="descargarAppMobile(1);"><i class="fa fa-google fa-1x"></i></span>
        <span class="text mouse-vinculo" title="Descargar app SIBICA Apple Store" onclick="descargarAppMobile(2);"><i class="fa fa-apple fa-1x"></i></span>-->
        <a class="dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"><span> <?php echo $nombre; ?> </span></i>
        </a>        
        <div class="dropdown-menu dropdown-menu-right dropdown-default"
          aria-labelledby="navbarDropdownMenuLink-333">
          <a class="dropdown-item" href="<?php echo base_url('Login/logout')?>"><i class="fas fa-power-off"></i> Cerrar sesi&oacute;n</a>          
        </div>
      </li>     
      <li class="nav-item" id="li_user_no_logueado" style="display:none;">
        <span class="text mouse-vinculo" title="Descargar app SIBICA Google Store" onclick="descargarAppMobile(1);"><img src="./asset/public/img/googlestore.png" class="img-dowload"></span>
        <span class="text mouse-vinculo" title="Descargar app SIBICA Apple Store" onclick="descargarAppMobile(2);"><img src="./asset/public/img/applestore.png" class="img-dowload"></span>
        <span class="text mouse-vinculo" title="Reportar irregularidad" onclick="reportarIrregular(-1);"><img src="./asset/public/img/seguridad.png" class="img-dowload"></span>
        <span class="text mouse-vinculo" title="Descargar Manual" onclick="descargarManual(false);"><img src="./asset/public/img/pdf.png" class="img-dowload"></span>
        <span class="text inicio_sesin_mobile" title="Inicio session" onclick="inicioSession();" style="display:none;"><img src="./asset/public/img/inicio_sesion.png" class="img-dowload"></span>
        <!--<span class="text mouse-vinculo" title="Descargar app SIBICA Google Store" onclick="descargarAppMobile(1);"><i class="fa fa-google fa-1x"></i></span>
        <span class="text mouse-vinculo" title="Descargar app SIBICA Apple Store" onclick="descargarAppMobile(2);"><i class="fa fa-apple fa-1x"></i></span>
        <span class="text mouse-vinculo" title="Descargar Manual" onclick="descargarManual(false);"><i class="fas fa-file-pdf fa-1x"></i></span>-->       
      </li>
</div>
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-dark default-color menu-var-sibica">
  <span class="fas fa-caret-left icon-ws-menu" id="icon_menu"></span>
  <!--ininio ul-->
  <div class="navbar-collapse menu-var-content-sibica" id="navbarSupportedContent-333" style="display:none !important;">
    <div class="sidebar-nav ml-auto nav-flex-icons">
      <li class="nav-item navbar-nav"><a href="http://172.18.1.147/sibica/"><div><img src="./asset/public/img/logo_sibica.png" class="logo-menu"></div></a>  </li><br>
      <li class="nav-item navbar-nav menu-circle-collase width_px_50 class-column" id="li_contend_admin" style="display:none;">
          <!--<a id="btn_abrirCerrar" href="#" style="margin-left: 5px;" data-toggle="collapse" data-target="#collapse-modAdmin" aria-expanded="false" aria-controls="collapse-modAdmin" title="Admin" class="collapsed circle-menu">
            <span class="fa fa-cog"></span>
            <span class="text">Administrar</span>
          </a>-->
          <div id="menu_admin" class="navbar-nav ml-auto nav-flex-icons class-column" style="margin-right: 3px;">
            <a id="modUsuarios" href="#" onclick="usuarios();" data-toggle="collapse" data-target="#collapse-modUsuarios" aria-expanded="false" aria-controls="collapse-modUsuarios" title="Usuarios" class="collapsed circle-menu usuarios-key-css">
              <!--<span class="fa fa-user"></span>
              <span class="text">Usuarios</span>-->
              <img src="./asset/public/img/menu/usuario.png" toltip="Usuarios" class='img-menu'>
            </a>
            <a id="modRoles" href="#" onclick="roles();" data-toggle="collapse" data-target="#collapse-modRoles" aria-expanded="false" aria-controls="collapse-modRoles" title="Roles" class="collapsed circle-menu roles-key-css">
              <!--<span class="fa fa-id-card"></span>
              <span class="text">Roles</span>-->
              <img src="./asset/public/img/menu/roles.ico" toltip="Roles" class='img-menu'>
            </a>
            <a id="modTipoAmobla" href="#" onclick="verTipoAmoblamiento();" data-toggle="collapse" data-target="#collapse-modCampos" aria-expanded="false" aria-controls="collapse-modCampos" title="Tipo amoblamiento" class="collapsed circle-menu tipo-amobl-key-css">
              <!--<span class="fa fa-window-restore"></span>
              <span class="text">Tipo amoblamiento</span>-->
              <img src="./asset/public/img/menu/tipo_amoblamiento.png" toltip="Tipo amoblamiento" class='img-menu'>
            </a>
            <a id="modpanorama" href="#" onclick="gestionarPanorama();" data-toggle="collapse" data-target="#collapse-modPanorama" aria-expanded="false" aria-controls="collapse-modPanorama" title="Gesti&oacute;n panoramas de riesgo" class="collapsed circle-menu panorama-key-css">
              <!--<span class="fa fa-bacon"></span>
              <span class="text">Gesti&oacute;n de panoramas de riesgo</span>-->
              <img src="./asset/public/img/menu/panorama.png" toltip="Gesti&oacute;n de panoramas de riesgo" class='img-menu'>
            </a>
             <a id="modpanorama" href="#" onclick="gestionarVisitas();" data-toggle="collapse" data-target="#collapse-modPanorama" aria-expanded="false" aria-controls="collapse-modPanorama" title="Gesti&oacute;n de visitas t&eacute;cnicas" class="collapsed circle-menu panorama-key-css">
              <!--<span class="fab fa-accusoft"></span>
              <span class="text">Gesti&oacute;n de visitas t&eacute;cnicas</span>-->
              <img src="./asset/public/img/menu/visita.png" toltip="Gesti&oacute;n de visitas t&eacute;cnicas" class='img-menu'>
            </a>
            <a id="modmanual" href="#" onclick="descargarManual(true);" data-toggle="collapse" data-target="#collapse-modPanorama" aria-expanded="false" aria-controls="collapse-modPanorama" title="Manual sibica" class="collapsed circle-menu doc-manual-key-css">
              <!--<span class="fas fa-file-pdf fa-1x"></span> 
              <span class="text">Descargar Manual</span>-->
              <img src="./asset/public/img/pdf.png" toltip="UsuarManual usuario" class='img-menu'>
            </a>
            <a id="modReporte" href="#" onclick="getFrmReporteTerreno();" data-toggle="collapse" data-target="#collapse-modPanorama" aria-expanded="false" aria-controls="collapse-modPanorama" title="Reporte terreno" class="collapsed circle-menu doc-manual-key-css">
              <img src="./asset/public/img/menu/reporte.png" toltip="UsuarManual usuario" class='img-menu'>
            </a>
          </div>
        </li><br>
        <!--<li class="nav-item navbar-nav"><a href="http://www.cali.gov.co/" target="_blank"><div><img src="./asset/public/img/cali_progresa.png" class="logo-menu"></div></a>  </li><br>-->
        <li class="nav-item navbar-nav"><a href="http://www.cali.gov.co/" target="_blank"><div><img src="./asset/public/img/alcaldia.png" class="logo-menu"></div></a>  </li><br>
        <!--<li class="nav-item navbar-nav"><a href="https://www.valledelcauca.gov.co/" target="_blank"><div><img src="./asset/public/img/gobernacion.png" class="logo-menu"></div></a>  </li><br>-->
    </div>
    <!--fin ul-->
  </div>
</nav>
<!--/.Navbar -->

 
  
  
