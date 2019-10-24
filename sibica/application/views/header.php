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
<body>
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color menu-var-sibica">
  <div class="collapse navbar-collapse menu-var-content-sibica" id="navbarSupportedContent-333" style="display:none !important;">
    <ul class="navbar-nav ml-auto nav-flex-icons">
        <li class="nav-item navbar-nav menu-circle-collase" id="li_contend_admin" style="display: none;">
          <a id="btn_abrirCerrar" href="#" style="margin-right: 3px;" data-toggle="collapse" data-target="#collapse-modAdmin" aria-expanded="false" aria-controls="collapse-modAdmin" title="Admin" class="collapsed circle-menu">
            <!--<span class="fa angle-double-left"></span>-->
            <span class="fa fa-cog"></span>
            <span class="text">Administrar</span>
          </a>
          <div id="menu_admin" class="navbar-nav ml-auto nav-flex-icons oculta_elemnt" style="margin-right: 3px;">
            <a id="modUsuarios" href="#" onclick="usuarios();" data-toggle="collapse" data-target="#collapse-modUsuarios" aria-expanded="false" aria-controls="collapse-modUsuarios" title="Usuarios" class="collapsed circle-menu usuarios-key-css">
              <span class="fa fa-user"></span>
              <span class="text">Usuarios</span>
            </a>
            <a id="modRoles" href="#" onclick="roles();" data-toggle="collapse" data-target="#collapse-modRoles" aria-expanded="false" aria-controls="collapse-modRoles" title="Roles" class="collapsed circle-menu roles-key-css">
              <span class="fa fa-id-card"></span>
              <span class="text">Roles</span>
            </a>
            <a id="modTipoAmobla" href="#" onclick="verTipoAmoblamiento();" data-toggle="collapse" data-target="#collapse-modCampos" aria-expanded="false" aria-controls="collapse-modCampos" title="Tipo amoblamiento" class="collapsed circle-menu tipo-amobl-key-css">
              <span class="fa fa-window-restore"></span>
              <span class="text">Tipo amoblamiento</span>
            </a>
            <a id="modpanorama" href="#" onclick="gestionarPanorama();" data-toggle="collapse" data-target="#collapse-modPanorama" aria-expanded="false" aria-controls="collapse-modPanorama" title="Gestion panoramas de riesgo" class="collapsed circle-menu panorama-key-css">
              <span class="fa fa-window-restore"></span>
              <span class="text">Gestio&oacute; de panoramas de riesgo</span>
            </a>
            <a id="modmanual" href="#" onclick="descargarManual();" data-toggle="collapse" data-target="#collapse-modPanorama" aria-expanded="false" aria-controls="collapse-modPanorama" title="Gestion panoramas de riesgo" class="collapsed circle-menu doc-manual-key-css">
              <span class="fa fa-download"></span>
              <span class="text">Descargar Manual</span>
            </a>
            <!--<a id="modTablas" href="#" onclick="tablas();" data-toggle="collapse" data-target="#collapse-modTablas" aria-expanded="false" aria-controls="collapse-modTablas" title="Tablas" class="collapsed circle-menu tablas-key-css">
              <span class="fa fa-sign-in"></span>
              <span class="text">Tablas</span>
            </a>
            <a id="modCampos" href="#" onclick="campo();" data-toggle="collapse" data-target="#collapse-modCampos" aria-expanded="false" aria-controls="collapse-modCampos" title="Campos" class="collapsed circle-menu campos-key-css">
              <span class="fa fa-sign-in"></span>
              <span class="text">Campos</span>
            </a>-->            
          </div>
        </li>
        <li class="nav-item dropdown" id="li_user_logueado" style="display: none;">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"> <?php echo $nombre; ?></i>
          </a>        
          <div class="dropdown-menu dropdown-menu-right dropdown-default"
            aria-labelledby="navbarDropdownMenuLink-333">
            <a class="dropdown-item" href="<?php echo base_url('Login/logout')?>"><i class="fas fa-power-off"></i> Cerrar sesi&oacute;n</a>          
          </div>
        </li>     
        <li class="nav-item" id="li_user_no_logueado">
          <a onclick="inicioSession();" class="nav-link" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"> Iniciar sesi&oacute;n</i>
          </a>
        </li>
    </ul>
  </div>
</nav>
<!--/.Navbar -->

 
  
  
