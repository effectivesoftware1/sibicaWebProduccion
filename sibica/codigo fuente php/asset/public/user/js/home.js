var timeOutSesion = 0;//180000; //3 minutos
var userSesion;
$( document ).ready(function() {
    //global_tiempoMaxInact = parseInt(global_tiempoMaxInact);
    var min_x_segundo = 60;
    var mils_x_segundo = 1000;
    var seg_a_minuto_inact = global_tiempoMaxInact*min_x_segundo; 
    var idModal = 'modal_dialog_msjpred';
    var botonModal = [{"id":"cancelar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var msjPredios = 'La informaci&oacute;n aqu&iacute; consignada NO corresponde a la totalidad de predios de propiedad del municipio de Santiago de Cali. Se ir&aacute; actualizando peri&oacute;dicamente en el Geovisor SIBICA, de acuerdo a la verificaci&oacute;n del inventario de Bienes Inmuebles de propiedad del municipio de Santiago de Cali.';
    var vUrl = location.href;

    timeOutSesion = seg_a_minuto_inact*mils_x_segundo;     

    iniciarConteoSesion('inicio');    
    
    $(document).on( 'scroll',function(){
      pararConteoSesion('scroll');
    });
    
    $('body').on( 'keypress',function(){
      pararConteoSesion('keypress');
    });
    
    $('body').on( 'click',function(){
      pararConteoSesion('click');
    });
    
    $('body').on( 'mousemove',function(){
      pararConteoSesion('mousemove');
    });

    document.addEventListener("visibilitychange", function() {
        console.log("control time", document.visibilityState );
        var accion =  document.visibilityState;
        if (accion == "visible") {
          pararConteoSesion('visible');
          var existe_usuario = localStorage.getItem('codigo_usuario');
          if (existe_usuario == "0") {
              window.location.href = 'Login/logout';
          } 
            
        }else{
           pararConteoSesion('stop');
        }        
    });    

    calcSizeScreen(true);
    $( window ).resize(function() {
        var menuVisible = true;//$('#navbarSupportedContent-333:visible').length > 0 ? true : false;
        calcSizeScreen(menuVisible);
    });
    
    $(".menu-var-sibica, .menu-var-content-sibica").hover(function(){
        if($('#icon_menu:visible').length == 0){
            mostratOcultarMenu();
        }
    }, function(){
        if($('#icon_menu:visible').length == 0){
            mostratOcultarMenu();
        }
    });

    $(".menu-var-content-sibica").hover(function(){
        //No hace nada
    }, function(){
        if($('#icon_menu:visible').length == 0){
            mostratOcultarMenu();
        }
    });

    if(vUrl.indexOf('/acciones') == -1){
        if(g_inicioSession == 'S'){
            inicioSession();
        }else{
            crearModal(idModal, 'Apreciado Usuario', msjPredios, botonModal, false, 'modal-lg', '',true, true);
        }        
    }
    
    $('#icon_menu').on('click tap', function(){
        mostratOcultarMenu();
    });
});

  function pararConteoSesion(evento) {
    clearTimeout(userSesion);
    if (evento != 'stop') {
        iniciarConteoSesion(evento);
    } 

  }

  function iniciarConteoSesion(evento){ 
    userSesion = setTimeout(function(){
        console.log("Su session a expirado");      
        localStorage.setItem('codigo_usuario', '0'); 
        window.location.href = 'Login/logout';  
    },timeOutSesion); 
  }

function redHome(){
    location.href = "Home";  
}
function traerPedido(){
  location.href = "Inventario";
}

function actionEventMenu(idComponente, idAfecta){
    console.log('CONTEN:',idComponente);
    $('#'+idComponente).click(function(){
        var _this  = $(this);
        var visibleAfecta = $('#'+idAfecta+'[class*="oculta_elemnt"]').length;
        if(visibleAfecta > 0){            
            $('#li_contend_admin').removeClass('width_px_50');
            $('#'+idAfecta).removeClass('oculta_elemnt');
            $('#'+idAfecta).children('span').removeClass('angle-double-left');
            $('#'+idAfecta).children('span').removeClass('angle-double-right');
            
        }else{
            $('#li_contend_admin').addClass('width_px_50');
            $('#'+idAfecta).addClass('oculta_elemnt');
            $('#'+idAfecta).children('span').removeClass('angle-double-right');
            $('#'+idAfecta).children('span').removeClass('angle-double-left');
        }
    });
}

function calcSizeScreen(visibleMenu){
    $('.content-mapa').attr('style','height:0px;');
    var altoPantalla = $(document).height();
    var altoMenu = 0;//!visibleMenu ? ($('.menu-var-sibica').height() + 2)  : 0;
    var ajusteImg = altoPantalla - altoMenu;// - 120;
    
    $('.content-mapa').attr('style','height:'+ajusteImg+'px;');
}

function mostratOcultarMenu(){
    var menuVisible = $('#navbarSupportedContent-333:visible').length > 0 ? true : false;    
    if(menuVisible > 0){
        $('#navbarSupportedContent-333').attr('style','display: none !important;');
        $('#icon_menu').removeClass('fa-caret-right');
        $('#icon_menu').addClass('fa-caret-left');
    }else{
        $('#navbarSupportedContent-333').attr('style','');
        $('#icon_menu').removeClass('fa-caret-left');
        $('#icon_menu').addClass('fa-caret-right');
    }
    calcSizeScreen(menuVisible);
}

function refrescarGlobales(){
    var p_url = 'Home/getDataGlobal';
    var p_paramadd = {};

    $.ajax({    
        url: p_url,  
        type: "POST",  
        dataType: "json",
        data: p_paramadd,   
        success: function(dato){
            //runLoading(false);
            //g_rol_table_view = dato['rolTableView'];
            //g_rol_view = dato['rolView'];
            //g_modulo_table_view = dato['moduloTableView'];
            //g_modulo_view = dato['moduloView'];
            g_registro_view = dato['RegistroView'];

            g_usuario_table_view = dato['usuarioTableView'];
            //g_inicioSesion_view = dato['iniciarSessionView'];    
            //g_tablas_view = dato['TableView'];
            //g_regTablas = dato['regTablas'];
            //g_campos_view = dato['campoView'];   

            //global_tiempoMaxInact = 5;   
            //aux_glob_cod_usuario = dato['codigo_usuario'];
            //localStorage.setItem('codigo_usuario', aux_glob_cod_usuario);
            //g_ta_table_view = dato['taTableView'];
            //g_ta_view = dato['taView'];                       
        },
        error: function(error) {
            //runLoading(false); 
            console.log("error refresh");                 
        }
   });        
    
}

function traerInfoPredio(codPredio, cod_predio_const){
    var idModal =  'dialog_traerInfoPredio';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm"}];
    var url = "Home/traerInfoPredio";
    var mensaje = "";
    var formData = {};
    formData['codPredio'] = codPredio;
    formData['codPredioConst'] = cod_predio_const;
    callAjaxCallback(url, formData,function(tipo_respuesta, data){
        console.log('traerInfoPredio : ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');
            });
        }else{
            var datosReporte = data["result"] != undefined ? data["result"] : {};
            var frmReporte = data["formulario"] != undefined ? data["formulario"] : '<div id="tabs_info_predio"></div><div id="content_tabs_info_predio"></div>';
            var contadorGrupos = 0;
            llavesInfo = getObjColumnsTable('info_predio_w');
            
            if(Array.isArray(datosReporte)){
                datosReporte = datosReporte.length > 0 ? datosReporte[0] : {};
            }

            datosReporte = Array.isArray(datosReporte) ? datosReporte[0] : datosReporte;
            //var tablaInfo = contstruirTablaInfo(datosReporte, 'info_predio');

            crearModal(idModal, 'Informaci&oacute;n del predio', frmReporte, botonModal, true, 'modal-xl', '',true);
            console.log('datosReporte :',datosReporte);
            for(grupoKey in llavesInfo){
                contadorGrupos++;
                var textoTab = llavesInfo[grupoKey]['texto'];
                var llavesTab = llavesInfo[grupoKey]['datos'];
                var tablaTab = contstruirTablaInfo('tabla_'+grupoKey, llavesTab, datosReporte);
                var vActive = contadorGrupos == 1 ? 'active' : '';
                var vTab = $('<li class="nav-item"> <a class="nav-link tab-info-predio '+vActive+'" href="#'+grupoKey+'" role="tab" data-toggle="tab">'
                            +'<span class="fontmenu-vd">  '+textoTab+'  </span> </a> </li>');
                var vTabContetnt = $('<div class="tab-pane text-center gallery content-info-predio '+vActive+'" id="'+grupoKey+'"> </div>');
                
                vTabContetnt.html(tablaTab);
                $('#tabs_info_predio').append(vTab);
                $('#content_tabs_info_predio').append(vTabContetnt);
                aplicarDatatableInfoPred('tabla_'+grupoKey);
            }
            
            //crearModal(idModal, 'Informaci&oacute;n del predio', tablaInfo, botonModal, true, 'modal-lg', '',true);
            
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
            });

            //Ajustar modal contenedor
            $('#'+idModal+' .modal-content').last().addClass('content_modal');
            $('#'+idModal+' .modal-dialog').last().addClass('dialog_modal');
            $('#'+idModal+' .modal-body').last().addClass('body_modal');
        }
    });
}

function contstruirTablaInfo(idTabla, llavesObj, objData){
    var table = $('<table width="100%" class="table table-striped table-bordered table-hover" id="'+idTabla+'" cellspacing="0"> </table>');
    var thead = $('<thead> </thead>');
    var tbody = $('<tbody> </tbody>');
    var datosObj = objData;
    //var llavesObj = getObjColumnsTable(cbzTabla);
    var arrUndefined = [undefined, 'undefined', null, 'null'];    

    thead.html('<tr><th>Campo</th><th>Valor</th></tr>');
    for(llave in llavesObj){
        var valorCampo =  typeof datosObj[llave] != 'undefined' ? datosObj[llave] : '';

        if(valorCampo != '' && arrUndefined.indexOf(valorCampo) == -1){
            var trBody = $('<tr><td class="llave_info_td">'+llavesObj[llave]+'</td><td class="valor_info_td">'+valorCampo+'</td></tr>');
            tbody.append(trBody);
        }
    }

    table.html(thead);
    table.append(tbody);

    return table;
}

function getObjColumnsTable(idTabla){
    var columnsTable = {
        "info_predio": {
            "id_p":"Registro No.",
            "cedula_ppal_p":"Cedula catastral Principal",
            "id_catastro_p":"ID Catastro",
            "nupre_p":"N&uacute;mero Predial -Nupre",
            "dv_p":"Digito de verificaci&oacute;n",
            "codigonal_p":"C&oacute;digo Nacional",
            "codigounico_p":"C&oacute;digo &uacute;nico",
            "identifica_p":"N&uacute;mero Predial",
            "id_proyecto_p":"Codigo Proyecto Urban&iacute;stico",
            "clase_inmueble_p":"C&oacute;digo Clase de Inmueble",
            "id_cb_fk":"C&oacute;digo Calidad del Bien",
            "id_tb_fk":"C&oacute;digo Tipo de Bien",
            "id_tu_fk":"C&oacute;digo Tipo de Uso",
            "direccion_p":"Direcci&oacute;n Oficial",
            "direccioncatastro_p":"Direcci&oacute;n Catastral",
            "zona_p":"Zona",
            "id_barrio":"C&oacute;digo Barrio",
            "pais_p":"Pais",
            "ciudad_p":"C&oacute;digo Ciudad",
            "lind_norte_p":"Lindero Norte",
            "lind_sur_p":"Lindero Sur",
            "lind_este_p":"Lindero Este",
            "lind_oeste_p":"Lindero Oeste",
            "lind_adic_p":"Linderos adicionales",
            "matricula_ppal_p":"Es Matricula principal?",
            "mat_inmob_p":"Matricula inmobiliaria",
            "id_madq_fk":"C&oacute;digo Modo de Adquisici&oacute;n",
            "nombre_areacedida_p":"Nombre &aacute;rea",
            "nit_cede_fk":"Cedente/Donante/Vendedor",
            "derecho_p":"% de Propiedad",
            "afecta_pot_p":"Afecta POT?",
            "asegurado_p":"Asegurado",
            "suscep_vta_p":"Susceptible de Venta ?",
            "id_depen_fk":"C&oacute;digo Organismo a cargo",
            "nombrecomun_p":"Nombre com&uacute;n",
            "area_cesion_p":"&Aacute;rea de cesi&oacute;n (mts2)",
            "area_actual_p":"&Aacute;rea actual (mts2)",
            "area_sicat_p":"&Aacute;rea Sicat (mts2)",
            "area_terreno_p":"&Aacute;rea de terreno en SAP",
            "fecha_estudio_titulo_p":"Fecha estudio t&iacute;tulos",
            "num_activofijo_p":"N&uacute;mero de activo fijo",
            "codigo_zhg_p":"C&oacute;digo ZHG",
            "cuenta_terreno_p":"C&oacute;digo Cuenta Terreno",
            "propietario_antes_p":"Propietario anterior",
            "actualiza_sap":"Fecha actualizaci&oacute;n en span",
            "impto_predial_p":"Impuesto Predial",
            "id_shp_p":"Geograf&iacute;a",
            "fecha_levantamiento_p":"Fecha levantamiento  Topog.",
            "id_estado_fk":"C&oacute;digo Estado",
            "fecha_creacion_p":"Fecha de registro en SIBICA",
            "fecha_modifica_p":"Fecha modificaci&oacute;n en SIBICA",
            "migracion_siga":"Fecha migraci&oacute;n a SIGA",
            "id_capa":"C&oacute;digo Capa visualizaci&oacute;n",
            "doc_calidad_bien":"Documento Calidad del Bien",
            "fecha_expedicion_cb_p":"Fecha expedici&oacute;n Calidad del Bien",
            "orfeo_cb_p":"N&uacute;mero Orfeo CB",
            "documento_p":"Expediente f&iacute;sico",
            "foto_p":"Foto",
            "ubica_archivo_p":"Ubicaci&oacute;n Expediente",
            "mensaje_p":"Mensaje al ciudadano",
            "key_0":"--------------------- NOMBRES ---------------------",
            "nombre_pro":"Proyecto Urban&iacute;stico",
            "nombre_cb": "Calidad del Bien",
            "nombre_tb": "Tipo de Bien",
            "barrio":"Barrio",
            "nombre_madq":"Modo de Adquisici&oacute;n",
            "nombre_tcro":"Nombre tercero cede",
            "nombre_tcro_p":"Nombre tercero anterior prpietario",
            "clase":"Clase de Inmueble",
            "nombre_tu":"Tipo de Uso",
            "nombre_ciu":"Ciudad",
            "nombre_dep":"Departamento",
            "nombre_depen":"Organismo a cargo",
            "nombre_cuenta":"Nombre cuenta terreno",
            "nombre_estado":"Estado",
            "capa":"Capa visualizaci&oacute;n",
            "key_1":"--------------------- CONSTRUCCION ---------------------",
            "cons_id_const":"Registro",
            "cons_predialterreno_const_fk":"Predial terreno",
            "cons_predial_edificacion_const":"Predial construcci&oacute;n",
            "cons_id_catastro_const":"ID Catastro construcci&oacute;n",
            "cons_activofijo_const":"Activo fijo construcci&oacute;n",
            "cons_codigonal_const":"C&oacute;digo nacional",
            "cons_codigounico_const":"C&oacute;digo &Uacute;nico",
            "cons_direccion_const":"Direcci&oacute;n construcci&oacute;n",
            "cons_nombre_const":"Nombre Construcci&oacute;n",
            "cons_numpisos_const":"N&uacute;mero de pisos",
            "cons_numconstruccion_const":"N&uacute;mero de Construcciones",
            "cons_ano_const":"Año de construcci&oacute;n",
            "cons_sismoresiste_const":"Sismoresistente ?",
            "cons_afecta_pot_const":"Afecta POT ?",
            "cons_area_edifica_const":"&Aacute;rea eidificada (mts2)",
            "cons_area_anexos_const":"&Aacute;rea Anexos",
            "cons_impto_predial_const":"Impuesto Predial",
            "cons_mat_inmob_const":"Matricula Inmobiliaria construcci&oacute;n",
            "cons_cuenta_const":"Cuenta construcci&oacute;n",
            "cons_nombre_cuenta_const":"Nombre cuenta",
            "cons_gid":"Geograf&iacute;a",
            "cons_id_capa_const":"Capa visualizaci&oacute;n construc.",
            "cons_orfeo_cb_const":"Orfeo calidad",
            "cons_fecha_registro_const":"Fecha registro construc.",
            "cons_id_tb_fk":"Tipo de Bien Constr.",
            "cons_id_tu_fk":"Tipo de uso Constr.",
            "cons_id_depen_fk":"Organismo a cargo",
            "cons_derecho_c":"% de propiedad",
            "cons_fecha_modifica_const":"Fecha modificaci&oacute;n construc",
            "key_2":"--------------------- AVALUO ---------------------",
            "aval_id_aval":"Registro",
            "aval_predial_terreno_aval":"Predial terreno",
            "aval_predial_construccion_aval":"Predial construcci&oacute;n",
            "aval_anio":"Año de avaluo",
            "aval_valor_cial_terreno_aval":"Valor comercial terreno",
            "aval_valor_cial_contruccion_aval":"Valor comercial construcci&oacute;n",
            "aval_valor_cial_anexos_aval":"Valor comercial anexos",
            "key_3":"--------------------- CONTRATO ---------------------",
            "cont_id_cont":"Registro",
            "cont_predial_cont_fk":"Predial asociado",
            "cont_numero_cont":"N&uacute;mero de contrato",
            "cont_id_tc_fk":"Tipo de contrato",
            "cont_area_entregada_cont":"&Aacute;rea entregada (mts2)",
            "cont_fecha_ini_cont":"Fecha inicial contrato",
            "cont_fecha_fin_cont":"Fecha final contrato",
            "cont_id_estado_fk":"Estado del contrato",
            "cont_nit_entidad_cont":"Nombre ocupante",
            "cont_idusu_cont_fk":"usuario encargado",
            "cont_lind_norte_cont":"Lindero Norte",
            "cont_lind_sur_cont":"Lindero Sur",
            "cont_lind_este_cont":"Lindero Este",
            "cont_lind_oeste_cont":"Lindero Oeste",
            "cont_lind_adic_cont":"Linderos Adicionales",
            "cont_id_const_fk":"Construcci&oacute;n asociada",
            "cont_cantidad_ocupa_cont":"Cantidad ocupaci&oacute;n",
            "cont_porcentaje_ocupa_cont":"% de Ocupaci&oacute;n",
            "cont_valor_canon_cont":"Valor de Canon",
            "cont_tipo_ocupante_cont":"Tipo de ocupante",
            "key_4":"--------------------- DOCUMENTO ---------------------",
            "docu_id_doc":"Registro",
            "docu_id_tipod_fk":"Tipo Documento",
            "docu_numero_doc":"N&uacute;mero documento",
            "docu_fecha_doc":"Fecha del documento",
            "docu_id_not_fk":"Notar&iacute;a No.",
            "docu_id_oficina_expe":"Oficina de expedici&oacute;n",
            "docu_ciudad_doc":"Ciudad",
            "docu_nombre_tipod":"Tipo Documento",
            "docu_nombre_ciu":"Ciudad",
            "docu_nombre_not":"Notaría No.",
            "docu_nombre_oficina":"Oficina de expedición",
            "key_5":"--------------------- MATRICULA ---------------------",
            "matr_id_mat":"Registro",
            "matr_numero_mat":"N&uacute;mero de matricula",
            "matr_fecha_mat":"Fecha de apertura folio",
            "matr_ciudad_mat":"Ciudad de la Matricula",
            "matr_estado_juridico_mat":"Estado jur&iacute;dico",
            "matr_cantidad_gravamen_mat":"Cantidad de gravament",
            "matr_procontra_mat":"Procesos en Contra?",
            "matr_otroprop_mat":"Otro propietario ?",
            "matr_tipoprop_mat":"Tipo de propietario",
            "key_6":"--------------------- OBSERVACION ---------------------",
            "obse_id_obs":"Registro",
            "obse_predial_obs_fk":"Predial Observaci&oacute;n",
            "obse_fecha_obs":"Fecha de Observaci&oacute;n",
            "obse_observacion_obs":"Observaci&oacute;n",
            "obse_id_usu_fk":"Usuario observador",
            "obse_tipo_ob":"Tipo de Observaci&oacute;n",
            "key_7":"--------------------- REPORTE_PREDIO ---------------------",
            "repo_id_reporte":"Registro",
            "repo_the_geom":"Geograf&iacute;a",
            "repo_predial":"Predial reportado",
            "repo_tipo_reporte":"Tipo de reporte",
            "repo_fecha_reporte":"Fecha de reporte",
            "repo_direccion_predio_reporte":"Direcci&oacute;n predio ",
            "repo_dir_ip_reporte":"Direcci&oacute;n IP del reporte",
            "repo_estado_reporte":"Estado del reporte",
            "repo_foto_reporte":"Foto reporte",
            "repo_ciudadano_reporte":"Ciudadano",
            "repo_cedula_reporte":"Cedula",
            "repo_telefono_reporte":"telefono",
            "repo_radicado_orfeo":"radicado orfeo",
            "repo_observacion":"Observaci&oacute;n de seguimiento",
            "repo_fecha_solicitud_restitucion":"Fecha solicitud restituci&oacute;n",
            "repo_oficio_solicitud":"Orfeo de solicitud",
            "repo_fecha_inspeccion":"Fecha de inspecci&oacute;n",
            "repo_inspeccion":"Inspecci&oacute;n de polic&iacute;a",
            "repo_observacion_ciudadano":"Observaci&oacute;n del ciudadano",
            "key_8":"--------------------- SERVICIO_PUBLICO ---------------------",
            "serv_id_sp":"registro",
            "serv_predial_sp":"Predial asociado",
            "serv_suscriptor_sp":"Suscriptor",
            "serv_medidor_acueducto_sp":"Medidor Acueducto",
            "serv_medidor_energia_sp":"Medidor Energ&iacute;a"
        },
        "info_usuarios":{

        },
        "info_predio_w":{
            "grupo_1":{
                "texto":"Identificación del Predio",
                "datos":{
                    "id_p":"Registro No.",
                    "cedula_ppal_p":"Cedula catastral Principal",
                    //"id_catastro_p":"ID Catastro",
                    "identifica_p":"ID Catastro",
                    "nupre_p":"Número Predial -Nupre",
                    "dv_p":"Digito de verificación",
                    "codigonal_p":"Código Nacional",
                    "codigounico_p":"Código único",
                    "num_activofijo_p":"Número de Activo Fijo",
                    "nombrecomun_p":"Nombre común",
                    "predial_p":"Número Predial"//falta
                }
            },
            "grupo_2":{
                "texto":"Ubicación del Predio",
                "datos":{
                    "direccion_p":"Dirección Oficial",
                    "direccioncatastro_p":"Dirección Catastral",
                    "zona_p":"Zona",
                    "barrio":"Barrio",
                    "comuna":"Comuna",//falta
                    "pais_p":"Pais",
                    "nombre_dep":"Departamento",
                    "nombre_ciud":"Ciudad",//falta
                    "lind_norte_p":"Lindero Norte",
                    "lind_sur_p":"Lindero Sur",
                    "lind_este_p":"Lindero Este",
                    "lind_oeste_p":"Lindero Oeste",
                    "lind_adic_p":"Linderos adicionales",
                }
            },
            "grupo_3":{
                "texto":"Clasificación",
                "datos":{
                    "nombre_pro":"Proyecto Urbanístico",
                    "nombre_cb":" Calidad del Bien",
                    "clase":"Clase de Inmueble",
                    "nombre_tb":" Tipo de Bien",
                    "nombre_tu":"Tipo de Uso"
                }
            },
            "grupo_4":{
                "texto":"Titularidad y Áreas",
                "datos":{
                    "matricula_ppal_p":"Es Matricula principal?",
                    "mat_inmob_p":"Matricula inmobiliaria",
                    "matr_fecha_mat":"Fecha de apertura folio",
                    "matr_ciudad_mat":"Ciudad de la Matricula",
                    "matr_estado_juridico_mat":"Estado jurídico Matricula",
                    "matr_cantidad_gravamen_mat":"Cantidad de gravamenes",
                    "matr_procontra_mat":"Procesos en Contra?",
                    "matr_otroprop_mat":"¿Otro propietario en Matricula ?",
                    "matr_tipoprop_mat":"Tipo de propietario",
                    "nombre_madq":"Modo de Adquisición",
                    "nombre_areacedida_p":"Nombre área",
                    "nombre_tcro":"Cedente/Donante/Vendedor",
                    "derecho_p":"% de Propiedad",
                    "suscep_vta_p":"¿Susceptible de Venta ?",
                    "docu_id_tipod_fk":"Tipo Documento",//falta
                    "docu_numero_doc":"Número documento",//falta
                    "docu_fecha_doc":"Fecha del documento",//falta
                    "docu_id_oficina_expe":"Oficina de expedición",//falta
                    "docu_id_not_fk":"Notaría No.",//falta
                    "docu_ciudad_doc":"Ciudad",//falta
                    "docu_nombre_tipod":"Tipo Documento",
                    "docu_nombre_ciu":"Ciudad",
                    "docu_nombre_not":"Notaría No.",
                    "docu_nombre_oficina":"Oficina de expedición",
                    "area_cesion_p":"Área de cesión (mts2)",
                    "area_actual_p":"Área actual (mts2)",
                    "area_sicat_p":"Área Sicat (mts2)",
                    "area_terreno_p":"Área de terreno en SAP",
                    "nombre_tcro_p":"Nombre propietario anterior ",
                    "fecha_estudio_titulo_p":"Fecha estudio títulos",
                    "doc_calidad_bien":"Documento Calidad del Bien",
                    "fecha_expedicion_cb_p":"Fecha expedición Calidad del Bien",
                    "orfeo_cb_p":"Número Orfeo CB"               
                }
            },
            "grupo_5":{
                "texto":"SAP",
                "datos":{
                    "codigo_zhg_p":"Código ZHG",
                    "cuenta_terreno_p":"Código Cuenta Terreno",
                    "nombre_cuenta":"Nombre cuenta terreno",
                    "actualiza_sap":"Fecha actualización en span  SAP",
                    "impto_predial_p":"Impuesto Predial",
                    "aval_anio":"Año de avaluo",
                    "aval_valor_cial_terreno_aval":"Valor comercial terreno",
                    "aval_valor_cial_contruccion_aval":"Valor comercial construcción",
                    "aval_valor_cial_anexos_aval":"Valor comercial anexos",
                    "migracion_siga":"Fecha migración a SIGA"
                }
            },
            "grupo_6":{
                "texto":"Topografía",
                "datos":{
                    "id_shp_p":"Geografía",
                    "fecha_levantamiento_p":"Fecha levantamiento  Topog.",
                    "capa":"Capa visualización",
                    "fecha_creacion_p":"Fecha de registro en SIBICA",
                    "fecha_modifica_p":"Fecha modificación en SIBICA",
                    "nombre_estado":"Estado en Base de Datos"
                }
            },
            "grupo_7":{
                "texto":"Archivo",
                "datos":{
                    "documento_p":"Expediente Físico Escaneado del Predio",
                    "documento_digital_pro":"Expediente Fisico Escaneado del Proyecto",//falta
                    "ubica_archivo_p":"Ubicación Expediente"
                }
            },
            "grupo_8":{
                "texto":"Construcciones y Anexos",
                "datos":{
                    "cons_id_const":"Registro construcción",
                    "cons_predial_edificacion_const":"Predial construcción",
                    "cons_id_catastro_const":"ID Catastro construcción",
                    "cons_activofijo_const":"Activo fijo construcción",
                    "cons_codigonal_const":"Código nacional",
                    "cons_codigounico_const":"Código único",
                    "cons_direccion_const":"Dirección construcción",
                    "cons_nombre_const":"Nombre Construcción",
                    "cons_nombre_tb":"Tipo de Bien Constr.",
                    "cons_nombre_tu":"Tipo de Uso Constr.",
                    "cons_numpisos_const":"Número de pisos",
                    "cons_ano_const":"Año de construcción",
                    "cons_sismoresiste_const":"Sismoresistente ?",
                    "cons_afecta_pot_const":"Afecta POT ?",
                    "cons_area_edifica_const":"área eidificada (mts2)",
                    "cons_area_anexos_const":"área Anexos",
                    "cons_impto_predial_const":"Impuesto Predial",
                    "cons_mat_inmob_const":"Matricula Inmobiliaria construcción",
                    "cons_cuenta_const":"Cuenta construcción",
                    "cons_nombre_cuenta_const":"Nombre cuenta",
                    "cons_gid":"Geografía",
                    "cons_id_capa_const":"Capa visualización construción",
                    "cons_orfeo_cb_const":"Orfeo calidad",
                    "cons_id_depen_fk":"Organismo a cargo",
                    "cons_derecho_c":"% de propiedad",
                    "cons_fecha_registro_const":"Fecha registro construc.",
                    "cons_fecha_modifica_const":"Fecha modificación construc"
                }
            },
            "grupo_9":{
                "texto":"Ocupación",
                "datos":{
                    "cont_predial_cont_fk":"Predial asociado",
                    "cont_numero_cont":"Número de contrato",
                    "cont_id_tc_fk":"Tipo de contrato",
                    "cont_area_entregada_cont":"área entregada (mts2)",
                    "cont_fecha_ini_cont":"Fecha inicial contrato",
                    "cont_fecha_fin_cont":"Fecha final contrato",
                    "cont_id_estado_fk":"Estado del contrato",
                    "cont_nit_entidad_cont":"Nombre ocupante",
                    "cont_idusu_cont_fk":"usuario encargado",
                    "cont_lind_norte_cont":"Lindero Norte",
                    "cont_lind_sur_cont":"Lindero Sur",
                    "cont_lind_este_cont":"Lindero Este",
                    "cont_lind_oeste_cont":"Lindero Oeste",
                    "cont_lind_adic_cont":"Linderos Adicionales",
                    "cont_id_const_fk":"Construcción asociada",
                    "cont_cantidad_ocupa_cont":"Cantidad ocupación",
                    "cont_porcentaje_ocupa_cont":"% de Ocupación",
                    "cont_valor_canon_cont":"Valor de Canon",
                    "cont_tipo_ocupante_cont":"Tipo de ocupante"
                }
            },
            "grupo_10":{
                "texto":"Observaciones",
                "datos":{
                    "obse_id_obs":"Registro",
                    "obse_fecha_obs":"Fecha de Observación",
                    "obse_observacion_obs":"Observación",
                    "obse_id_usu_fk":"Usuario observador",
                    "obse_tipo_ob":"Tipo de Observación"
                }
            },
            "grupo_11":{
                "texto":"Ocupación Irreglamentaria",
                "datos":{
                    "repo_id_reporte":"Registro",
                    "repo_predial":"Predial reportado",
                    "repo_tipo_reporte":"Tipo de reporte",
                    "repo_fecha_reporte":"Fecha de reporte",
                    "repo_direccion_predio_reporte":"Dirección predio ",
                    "repo_dir_ip_reporte":"Dirección IP del reporte",
                    "repo_estado_reporte":"Estado del reporte",
                    "repo_foto_reporte":"Foto reporte",
                    "repo_ciudadano_reporte":"Ciudadano",
                    "repo_cedula_reporte":"Cedula",
                    "repo_telefono_reporte":"telefono",
                    "repo_radicado_orfeo":"radicado orfeo",
                    "repo_observacion":"Observación de seguimiento",
                    "repo_fecha_solicitud_restitucion":"Fecha solicitud restitución",
                    "repo_oficio_solicitud":"Orfeo de solicitud",
                    "repo_fecha_inspeccion":"Fecha de inspección",
                    "repo_inspeccion":"Inspección de policía",
                    "repo_observacion_ciudadano":"Observación del ciudadano"
                }
            },
            "grupo_12":{
                "texto":"Servicios Públicos",
                "datos":{
                    "serv_id_sp":"registro",
                    "serv_suscriptor_sp":"Suscriptor",
                    "serv_medidor_acueducto_sp":"Medidor Acueducto",
                    "serv_medidor_energia_sp":"Medidor Energía"
                }
            }
        }
    }

    return columnsTable[idTabla];
}

function descargarManual(isUser){
    var idModal =  'dialog_descargarDocPdf';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var mensaje = 'Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo';
    var urlDescargaMnual = './asset/public/fileDowload/manual.pdf';

    if(isUser){
        if(g_modulos_no_aplica != null){
            if(g_modulos_no_aplica.indexOf('doc-manual-key-css') == -1){
                window.open(urlDescargaMnual, '_blank');
            }else{
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            }
        }else{
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }
    }else{
        urlDescargaMnual = './asset/public/fileDowload/Manual_ciudadano_SIBICA.pdf';
        window.open(urlDescargaMnual, '_blank');
    }
    
}

function descargarDocPdf(urlDoc){
    var idModal =  'dialog_descargarDocPdf';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var mensaje = 'Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo';
    var urlDescargaPdf = '../Bienes_inmuebles/'+urlDoc;//'./asset/public/fileDowload/manual.pdf';    

    if(urlDoc != null && urlDoc != '' && urlDoc != undefined){
        if(g_modulos_no_aplica != null){
            if(g_modulos_no_aplica.indexOf('doc-calbien-key-css') == -1){
                //window.open(urlDescargaPdf);
                guardarAudiDoc('calidad_bien', urlDoc);
                location.href = urlDescargaPdf;
            }else{
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            }
        }else{
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }
    }else{
        mensaje = 'Estimado usuario, no se encontro documento alguno para este predio';
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
    }
}

function descargarDocPdfRef(urlDoc){
    var idModal =  'dialog_descargarDocPdf';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var mensaje = 'Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo';
    var urlDescargaPdf = '../Bienes_inmuebles/'+urlDoc;//'./asset/public/fileDowload/manual.pdf';

    if(urlDoc != null && urlDoc != '' && urlDoc != undefined){
        if(g_modulos_no_aplica != null){
            if(g_modulos_no_aplica.indexOf('doc-exped-key-css') == -1){
                //window.open(urlDescargaPdf);
                guardarAudiDoc('expediente_fisico', urlDoc);
                location.href = urlDescargaPdf;
            }else{
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            }
        }else{
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }
    }else{
        mensaje = 'Estimado usuario, no se encontro documento alguno para este predio';
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
    }
}

function descargarDocPdfExSesion(urlDoc){
    var idModal =  'dialog_descargarDocPdfExSesion';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var mensaje = 'Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo';
    var urlDescargaPdf = '../Bienes_inmuebles/'+urlDoc;//'./asset/public/fileDowload/manual.pdf';
    console.log(urlDoc);
    if(urlDoc != null && urlDoc != '' && urlDoc != undefined){
        if(g_modulos_no_aplica != null){
            if(g_modulos_no_aplica.indexOf('doc-expses-key-css') == -1){
                //window.open(urlDescargaPdf);
                guardarAudiDoc('expediente_sesion', urlDoc);
                location.href = urlDescargaPdf;
            }else{
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            }
        }else{
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }
    }else{
        mensaje = 'Estimado usuario, no se encontro documento alguno para este predio';
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
    }
}

function descargarAppMobile(tipo){
    var idModal =  'dialog_descargarAppMobile';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var mensaje = 'Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo';
    var urlDescargaAppGoogle = 'https://play.google.com/store/apps/details?id=com.ervic.alcaldia';
    var urlDescargaAppApple = 'https://apps.apple.com/co/app/sibica/id1198347047';

    if(g_modulos_no_aplica != null){
        if(g_modulos_no_aplica.indexOf('doc-app-sibica-key-css') == -1){
            if(tipo == 2){
                window.open(urlDescargaAppApple, '_blank');
            }else{
                window.open(urlDescargaAppGoogle, '_blank');
            }            
        }else{
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }
    }else{
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
    }
}

function getFrmReporteTerreno(){
    var idModal =  'dialog_getFrmReporteTerreno';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var url = "Home/getFrmReporteTerreno";
    var mensaje = "";
    var formData = {};
    //formData['codPredio'] = codPredio;
    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
        }else{
            var datosFrm = data["form_report"] != undefined ? data["form_report"] : [];
            crearModal(idModal, 'Reporte terreno', datosFrm, botonModal, '', 'modal-xl',true);

            $('#btConsultarTerreno').click(function(){
                getReporteTerreno();
            });

            $('#btLimpiarFiltros').click(function(){
                var filtros = ['txPredio','ltComuna','ltTipoBien','ltTipoUso','ltBarrio','txAreaCesion','ltCalidad'];
                limpiarFiltros(filtros);
            });

            //validRangoFechas('txFechaInicio', 'txFechaFin');
            //Ajustar modal contenedor
            $('#'+idModal+' .modal-content').last().addClass('content_modal');
            $('#'+idModal+' .modal-dialog').last().addClass('dialog_modal');
            $('#'+idModal+' .modal-body').last().addClass('body_modal');
            validarSolonumerosMobile("txAreaCesion");

        }
    });
}

function getReporteTerreno(){
    var idModal =  'dialog_getReporteTerreno';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm"}];
    var url = "Home/getReporteTerreno";
    var mensaje = "";
    var formData = {};
    formData['predio'] = $('#txPredio').val();
    formData['usuario'] = $('#ltUser').val();
    formData['fechaInicio'] = $('#txFechaInicio').val();
    formData['fechFin'] = $('#txFechaFin').val();
    formData['barrio'] = $('#ltBarrio').val();
    formData['comuna'] = $('#ltComuna').val();
    formData['tipoBien'] = $('#ltTipoBien').val();
    formData['tipoUso'] = $('#ltTipoUso').val();
    formData['areaCesion'] = $('#txAreaCesion').val();
    formData['calidad'] = $('#ltTiltCalidadpoUso').val();
    //formData['codPredio'] = codPredio;
    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
            });
        }else{
            var datosReporte = data["result"] != undefined ? data["result"] : [];
            var columnTable = getColumnTable('reporte_terreno');
            var tablaInfo = createTable('tbl_reporte_terreno', columnTable, datosReporte);
            
            $('#tablaReporteTerreno').html(tablaInfo);
            
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
            });

            aplicarDatatableGeneral("tbl_reporte_terreno",'',"Reporte Terreno");
            $('.buttons-pdf').remove();
        }
    });
}


function limpiarFiltros(arrFiltros, divTabla){
    for(c=0; c<arrFiltros.length; c++){
        var idCampo = arrFiltros[c];
        if($('#'+idCampo).get(0).tagName == 'SELECT'){
            $('#'+idCampo+' OPTION').removeAttr('selected').prop('selected',false);
        }else{
            $('#'+idCampo).val('');
        }
    }
}

function aplicarDatatableInfoPred(idTabla){
    $('#'+idTabla).DataTable({
        "responsive": true,    
        "ordering": false,
        "colReorder": true,
        "columns": [
            { "width": "30%" },
            { "width": "70%" }
        ],
        "language": {
            "processing":     "Procesando...",
            "search":         "B&uacute;squeda General:",
            "lengthMenu": "Mostrar _MENU_ por pagina",
            "zeroRecords": "No hay resultados",
            "info": "Mostrando p&aacute;gina _PAGE_ de _PAGES_",
            "infoEmpty": "Sin registros",
            "infoFiltered": "(Filtrar de _MAX_ total registros)",
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Ultimo"
            }
        },
        dom: 'lrtip',//Bfrtip|lrtip
        buttons: []
    });
}

function printFichaTecnica(codPredio, cod_predio_const){
    var idModal =  'dialog_printFichaTecnica';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm"}];
    var url = "Home/generaFichaTecnica";
    var mensaje = "";
    var formData = {};
    formData['codPredio'] = codPredio;
    formData['codPredioConst'] = cod_predio_const;
    formData['llavesInfo'] = getObjColumnsTable('info_predio_w');
    callAjaxCallback(url, formData,function(tipo_respuesta, data){
        console.log('traerInfoPredio : ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');
            });
        }else{
            var datosReporte = data["datosPredio"] != undefined ? data["datosPredio"] : '';
            var formPdf = $('<form id="infoPredioPdf" name="infoPredioPdf" action="Home/printFichaTecnica" method="POST"></form>');
            var textAreaData = $('<textarea id="datosTabla" name="datosTabla">'+datosReporte+'</textarea>');
            var inputPredio = $('<input type="text" id="codPredio" name="codPredio" value="'+codPredio+'">');
            formPdf.html(textAreaData);
            formPdf.append(inputPredio);          
            $('body').append(formPdf);
            
            crearModal(idModal, 'Informaci&oacute;n del predio PDF', datosReporte, botonModal, true, 'modal-xl', '',true);
            
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
            });

            $('#infoPredioPdf').submit();
        }
    });
}

function guardarAudiDoc(tipoDoc, patDoc){
    var idModal =  'dialog_guardarAudiDoc';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm"}];
    var url = "Home/guardarAudiDoc";
    var mensaje = "";
    var formData = {};
    var arrDoc = patDoc.split('/');
    
    formData['documento'] = arrDoc[arrDoc.length - 1];
    formData['tipoDoc'] = tipoDoc;
    
    callAjaxCallback(url, formData,function(tipo_respuesta, data){
        console.log('guardarAudiDoc : ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');
            });
        }else{
            var datosReporte = data["result"] != undefined ? data["result"] : {};
        }
    });
}