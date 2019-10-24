var timeOutSesion = 0;//180000; //3 minutos
var userSesion;
$( document ).ready(function() {

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
        mostratOcultarMenu();
    }, function(){
        mostratOcultarMenu();
    });

    $(".menu-var-content-sibica").hover(function(){
        //No hace nada
    }, function(){
        mostratOcultarMenu();
    });

    if(vUrl.indexOf('/acciones') == -1){
        crearModal(idModal, 'Apreciado Usuario', msjPredios, botonModal, false, 'modal-lg', '',true, true);
    }

    
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
    $('#'+idComponente).click(function(){
        var visibleAfecta = $('#'+idAfecta+'[class*="oculta_elemnt"]').length;
        if(visibleAfecta > 0){
            $('#'+idAfecta).removeClass('oculta_elemnt');
            $('#'+idAfecta).children('span').removeClass('angle-double-left');
            $('#'+idAfecta).children('span').removeClass('angle-double-right');
        }else{
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
    }else{
        $('#navbarSupportedContent-333').attr('style','');
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

function traerInfoPredio(codPredio){
    var idModal =  'dialog_traerInfoPredio';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm"}];
    var url = "Home/traerInfoPredio";
    var mensaje = "";
    var formData = {};
    formData['codPredio'] = codPredio;
    callAjaxCallback(url, formData,function(tipo_respuesta, data){
        console.log('traerInfoPredio : ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');
            });
        }else{
            var datosReporte = data["result"] != undefined ? data["result"] : {};
            datosReporte = Array.isArray(datosReporte) ? datosReporte[0] : datosReporte;
            var tablaInfo = contstruirTablaInfo(datosReporte, 'info_predio');

            crearModal(idModal, 'Informaci&oacute;n del predio', tablaInfo, botonModal, true, 'modal-lg', '',true);
            
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
            });
        }
    });
}

function contstruirTablaInfo(objData, cbzTabla){
    var table = $('<table width="100%" class="table table-striped table-bordered table-hover" id="tabla_'+cbzTabla+'" cellspacing="0"> </table>');
    var thead = $('<thead> </thead>');
    var tbody = $('<tbody> </tbody>');
    var datosObj = objData;
    var llavesObj = getObjColumnsTable(cbzTabla);
    var arrUndefined = [undefined, 'undefined', null, 'null'];    

    thead.html('<tr><th>Campo</th><th>Valor</th></tr>');
    for(llave in llavesObj){
        console.log('dato-lleve: ', llave);
        var valorCampo =  typeof datosObj[llave] != 'undefined' ? datosObj[llave] : '';

        if(valorCampo != '' && arrUndefined.indexOf(valorCampo) == -1){
            var trBody = $('<tr><td class="llave_info_td">'+llavesObj[llave]+'</td><td class="volor_info_td">'+valorCampo+'</td></tr>');
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
            "id_p":"C&oacute;digo",
            "cedula_ppal_p":"C&eacute;dula catastral principal",
            "id_catastro_p":"C&oacute;digo bien Inmueble",
            "nupre_p":"N&uacute;mero predial",
            "dv_p":"Digito de verificaci&oacute;n nupre",
            "codigonal_p":"N&uacute;mero forma &uacute;nica nacional",
            "codigounico_p":"N&uacute;mero predio",
            "identifica_p":"Identificaci&oacute;n Registro catastral",
            "id_proyecto_p":"N&uacute;mero asociaci&oacute;n unica",
            "clase_inmueble_p":"Clase de Bien Inmueble",
            "id_cb_fk":"Calidad de Bien",
            "id_tb_fk":"Tipo de Bien",
            "id_tu_fk":"Uso predio",
            "direccion_p":"Direcci&oacute;n",
            "direccioncatastro_p":"Direcci&oacute;n predio catastro",
            "zona_p":"Zona &Uacute;bicacion",
            "id_barrio":"Barrio",
            "pais_p":"DANE pais",
            "ciudad_p":"DANE Ciudad",
            "lind_norte_p":"Limite norte del predio",
            "lind_sur_p":"Limite sur del predio",
            "lind_este_p":"Limite este del predio ",
            "lind_oeste_p":"Limite oeste del predio",
            "lind_adic_p":"Linderos adicionales",
            "matricula_ppal_p":"Matricula Inmobiliaria principal",
            "mat_inmob_p":"Matricula inmobiliaria",
            "id_madq_fk":"Modo de Adquisici&oacute;n del predio",
            "nombre_areacedida_p":"Nombre area cedida",
            "nit_cede_fk":"Quien cedio el predio",
            "derecho_p":"Porcentaje municipio sobre el predio",
            "afecta_pot_p":"Afectaciones POT",
            "asegurado_p":"Asegurado",
            "suscep_vta_p":"Predio es susceptible para la venta",
            "id_depen_fk":"Dependencia",
            "nombrecomun_p":"Nombre común del predio",
            "area_cesion_p":"Area cesion",
            "area_actual_p":"Area actual",
            "area_sicat_p":"Área según catastro",
            "area_terreno_p":"Área total del terreno",
            "fecha_estudio_titulo_p":"Fecha  estudio jurídico al bien",
            "num_activofijo_p":"Registro contable",
            "codigo_zhg_p":"Código zona geográfica",
            "cuenta_terreno_p":"Cuenta SAP",
            "propietario_antes_p":"Nombre del Propietario anterior",
            "actualiza_sap":"fecha actualizado o creado el bien en sistema SAP",
            "impto_predial_p":"Impuesto Predial",
            "id_shp_p":"Geo predio",
            "fecha_levantamiento_p":"Fecha levantamiento",
            "id_estado_fk":"Estado",
            "fecha_creacion_p":"Fecha creacion",
            "fecha_modifica_p":"Fecha modificacion",
            "migracion_siga":"Migracion SIGA ",
            "id_capa":"Capa",
            "doc_calidad_bien":"Calidad bien",
            "fecha_expedicion_cb_p":"Fecha expedicion",
            "orfeo_cb_p":"Orfeo",
            "documento_p":"Documento path",
            "foto_p":"Ruta fotografía del bien inmueble",
            "ubica_archivo_p":"Ubicación archivo",
            "mensaje_p":"Mensaje geovisor"
        },
        "info_usuarios":{

        }
    }

    return columnsTable[idTabla];
}

function descargarManual(){
    var idModal =  'dialog_descargarDocPdf';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var mensaje = 'Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo';
    var urlDescargaMnual = './asset/public/fileDowload/manual.pdf';

    if(g_modulos_no_aplica != null){
        if(g_modulos_no_aplica.indexOf('doc-manual-key-css') == -1){
            window.open(urlDescargaMnual, '_blank');
        }else{
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }
    }else{
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
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
                window.open(urlDescargaPdf, '_blank');
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
            if(g_modulos_no_aplica.indexOf('doc-calbien2-key-css') == -1){
                window.open(urlDescargaPdf, '_blank');
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