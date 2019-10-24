var global_altoBody = 0;

jQuery(document).ready(function ($) {

  $("body").attr("style","overflow-x: hidden");
  activeMenuItem();
    runLoading(false);
  //fnSizeContador();   

    if (g_codigo_rol != null) {
        $("#li_contend_admin").show();
        $("#li_user_logueado").show();
        $("#li_user_no_logueado").remove();
    }

    actionEventMenu('btn_abrirCerrar', 'menu_admin');  
});

function activeMenuItem(){
  var patUrl = location.href.toString().split('/');
  console.log('patUrl -> ', patUrl);
  var adminControl = ['Usuario_control','AdminFiles_control','Registro_control','Reporte_control'];
  //var selectedItem = localStorage.itemSelect;
  var selectedItem = patUrl[patUrl.length - 1].indexOf('_control') > -1 ? patUrl[patUrl.length - 1] : 'Inicio_control';
  selectedItem = adminControl.indexOf(selectedItem) > -1 ? 'Admin_control' : selectedItem;
  console.log('select -> ', selectedItem);
  $('#bs-example-navbar-collapse-1').find('li').each(function(index, elemento){
    console.log('onclic -> ',$('#bs-example-navbar-collapse-1').find('li').eq(index).children('a').attr('onclick_'));
    if($('#bs-example-navbar-collapse-1').find('li').eq(index).children('a').attr('onclick_') != undefined){
      if($('#bs-example-navbar-collapse-1').find('li').eq(index).children('a').attr('onclick_').indexOf(selectedItem) > -1){
        console.log('Entroooo...............');
        var auxClass = $('#bs-example-navbar-collapse-1').find('li').eq(index).attr('class');
        $('#bs-example-navbar-collapse-1').find('li').eq(index).attr('class', auxClass+' active');
      }     
    }
  });
}

/*Esta funcion valida que solo se ingresen numeros
implementacion dentro de un input:
onkeypress="return validar_solonumeros(event)"*/

function validar_solonumeros(e, valor) {
  
    var tecla = (document.all) ? e.keyCode : e.which;    
    console.log('valid', tecla, ' value ->', valor);
    if (tecla == 8 || tecla == 0 || (tecla == 45 && valor != undefined && valor == '')){
        return true;
    }
        
    var patron = /[\d]/; // [A-Za-zñÑ\s solo letras y espacios  \d solo numeros 
    var te = String.fromCharCode(tecla);
    console.log('valid_patron ->', te);
   
    return patron.test(te);
}

/*Esta funcion valida que solo se ingresen letras y espacios
implementacion dentro de un input:
onkeypress="return validar_sololetras_espacios(event)"*/

function validar_sololetras_espacios(e) {
    var tecla = (document.all) ? e.keyCode : e.which;    
    if (tecla == 8 || tecla == 0)
        return true;
    var patron = /[A-Za-zñÑ\s]/; 
    var te = String.fromCharCode(tecla);
    return patron.test(te);
}

/*Esta funcion valida que se ingrese un email correcto
implementacion: retorna -1 si esta malo "*/

function validarEmail(valor) {
    if (/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/.test(valor)) {
        return 0;
    } else {
        return -1;
    }
}

/*Esta funcion compara dos fechas
implementacion: retorna  0 si la fecha inicial es mayor o igual a la fecha final "*/

function validate_fechaMayorQue(fechaInicial,fechaFinal){
    valuesStart=fechaInicial.split("-");
    valuesEnd=fechaFinal.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
    var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
    if(dateStart>=dateEnd)
    {
        return 0;
    }
    return 1;
} 

/*Esta funcion coloca la primera letra de cada palabra en mayuscula*/

function initcap(str){
    return str.replace(/([^\W_]+[^\s-]*) */g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

/*esta funcion utilza un cargando. resive true o false*/
function runLoading(tipo){
    if(tipo){
        var div_load = $('<div id="div_loading_nexos" class="loading_nexos"> </div>');
        $('body').append(div_load);
    }else{
        $('#div_loading_nexos').remove();
    }

}

/*funciones para validar campos requridos
implementacion: validRequired(getObjRequerid("controller_limite", "")), donde controller_limite es el div que contiene los campos y el otro parametro
es opcional donde van los campos separados por copas(id) de los campos qeu no  quiero q me valide */

function validRequired(requeridos){
    var msj = {};
    var ress = true;
    for(z=0; z<requeridos.length; z++){
        var campo = requeridos[z];
        if($('#'+campo['id']).get(0).tagName == 'SELECT'){
            if($('#'+campo['id']).val() == '' || $('#'+campo['id']).val() == ' ' || $('#'+campo['id']).val() == '-1'){
                msj['id'] = campo['id'];
                msj['mensaje'] = 'Por favor seleccionar un valor en el campo <b>'+campo['texto']+'</b>';
                ress = false;
                break;
            }
        }else{            
            if($('#'+campo['id']).get(0).tagName == 'INPUT' || $('#'+campo['id']).get(0).tagName == 'TEXTAREA' || $('#'+campo['id']).get(0).tagName == 'PASSWORD' || $('#'+campo['id']).get(0).tagName == 'NUMBER' || $('#'+campo['id']).get(0).tagName == 'FILE'){
                if($('#'+campo['id']).val() == '' || $('#'+campo['id']).val() == ' '){
                    msj['id'] = campo['id'];
                    msj['mensaje'] = 'Por favor ingresar un valor en el campo <b>'+campo['texto']+'</b>';
                    ress = false;
                    break;
                }
            }
        }
    }
    
    if(!ress){  
        var posicion = $('#'+msj['id']).offset();
        var divRequired = $('<div id="div_required_nexos" class="required_nexos" style="left:'+posicion['left']+'px;top:'+(posicion['top']-35)+'px;"> </div>');
        $('body').append(divRequired);
        $('#'+msj['id']).focus();
        alertify.notify(msj['mensaje'], 'error', 3, function(){ $('#div_required_nexos').remove(); });
    }    
    
    return ress;
}
    
function getObjRequerid(element, excluir){
    var requeridos = [];
    var excluidos = excluir != '' ? excluir.split(',') : [];
    $('#'+element).find('input[type="text"],input[type="file"],select,textarea,input[type="password"],input[type="number"]').each(function(index, elemento){
        if(excluidos.indexOf(elemento['id']) < 0){
            var objRequeridos = {};
            objRequeridos['id'] = elemento['id'];
            objRequeridos['texto'] = $('#'+elemento['id']).prev('label').text();
            if (objRequeridos['texto'] == '') {
               objRequeridos['texto'] = $('#'+elemento['id']).parent().prev('label').text();
               if (objRequeridos['texto'] == '') {
                    objRequeridos['texto'] = $('#'+elemento['id']).parent().parent().prev('label').text();
                    if (objRequeridos['texto'] == '') {
                        objRequeridos['texto'] = $('#'+elemento['id']).parent().parent().parent().prev('label').text();
                    }
               }
            }

            if(objRequeridos['id'] != '' && objRequeridos['id'] != undefined){
                requeridos.push(objRequeridos); 
            }
        }
    });
    console.log('requeridos ---> ',requeridos);
    return requeridos;
}


/*funcion para traducir a español el datatable*/

function traducirTabla(nombre_tabla){

    if (nombre_tabla==undefined) {
        nombre_tabla="tabla1";
    }

     $('#'+nombre_tabla).DataTable({
        responsive: true,
        "colReorder": true,
        "ordering": false,
        "language": {
            "processing":     "Procesando...",
            "search":         "B&uacute;squeda General:",
            "lengthMenu": "Mostrar _MENU_ por pagina",
            "zeroRecords": "No hay resultados",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "Sin registros",
            "infoFiltered": "(Filtrar de _MAX_ total registros)",
            "paginate": {
                  "first": "Primero",
                  "previous": "Anterior",
                  "next": "Siguiente",
                  "last": "Ultimo"
              }
        },
        //dom: 'Bfrtip',
        buttons: [  ]
    });

    $('[data-toggle="tooltip"]').tooltip();     
}

/*funcion para validar cualquier caracter especial o lietras o numeos*/

function validarn(e) { 
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    if (tecla==9) return true; // 3
    if (tecla==11) return true; // 3
    patron = /[A-Za-zñÑ'áéíóúÁÉÍÓÚàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛÑñäëïöüÄËÏÖÜ\s\t]/; // 4
 
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

/*funciones para validar q no se peguen otros caracteres de numeros con el raton, recibe dos parametros
 'campos' son los ids de los campos qeu quiero que me valide y menos es cualquie variable q le pongan , es decir si cua
 ando s llama se pone este parametro entonces se esta diciendo que deje pegar solo un signno menos */
function validarCopyNumeric(campos,menos){ 

 var arrayCampos=campos.split(",");
   
   for (var i = 0; i < arrayCampos.length; i++) {
      validando2(arrayCampos[i],menos);
   }
   
}

function validando2(campo,menos){
  $("#"+campo).bind({      
          paste : function(){
              var valorCampo="";
              setTimeout(function (){ 

                if (menos != undefined) {
                    valorCampo=$("#"+campo).val();
                }else{
                    valorCampo=$("#"+campo).val().replace('-','z');
                }               
                 if (isNaN(valorCampo)) {
                   $("#"+campo).val("");                
                 }
                      
              },100);
          }
      });   
}

function formatMiles(p_valor){
    var valor = typeof p_valor == "number" ? (p_valor.toString()).replace('.',',') : p_valor; 
    var valorCampo = valor == null ? '' : valor.replace(/\./g,'').replace(/\$/g,'');
    var arrayMilDecimal = valorCampo.split(',');
    var valCampo = arrayMilDecimal[0];
    var decimales = arrayMilDecimal[1] != undefined ? ','+arrayMilDecimal[1] : '';
    var cadenaMiles = '';
    var contarMiles = 0;
    var cadenaMilesDecimal = '';

    for(v=valCampo.length; v>0; v--){
        //console.log('VAR_V ->',v, ' = ',valCampo[v-1]);        
        if(contarMiles % 3 == 0){
          cadenaMiles = valCampo[v-1] + '.' + cadenaMiles;
        }else{
          cadenaMiles = valCampo[v-1] +''+ cadenaMiles;
        }
        contarMiles++;
    }
    
    cadenaMilesDecimal = cadenaMiles.substr(0, cadenaMiles.length-1) + decimales;
    return cadenaMilesDecimal;
} 

/*function fnSizeContador(){
  var sizeContar = [
            {"padding":30, "size":40},
            {"padding":30, "size":40},
            {"padding":30, "size":40},
            {"padding":30, "size":40},
            {"padding":35, "size":30},
            {"padding":40, "size":25},
            {"padding":45, "size":20},
            {"padding":48, "size":18},
            {"padding":50, "size":15},
            {"padding":50, "size":15},
            {"padding":52, "size":12},
            {"padding":53, "size":11},
            {"padding":55, "size":10}
          ];
  
  var valorContar = $('.divContador').html().trim();
  var tamano = sizeContar[valorContar.length]['size'];
  var padTop = sizeContar[valorContar.length]['padding'];
  $('.divContador').attr('style','font-size:'+tamano+'px; padding-top:'+padTop+'px');
  $('.divContador').html(formatMiles(valorContar));
  
  
}*/

function traducirCalendar(){
       $.datepicker.regional['es'] = {
         closeText: 'Cerrar',
         prevText: '< Ant',
         nextText: 'Sig >',
         currentText: 'Hoy',
         monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
         monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
         dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
         dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
         dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
         weekHeader: 'Sm',
         dateFormat: 'yy/mm/dd',
         firstDay: 1,
         isRTL: false,
         showMonthAfterYear: false,
         yearSuffix: ''
         };
         $.datepicker.setDefaults($.datepicker.regional['es']);
   }
   
function crearModal(idModal, titleModal, contentModal, pButonsModal, closeModal, classModal, attrModal, openModal, fnCloseModal, key_modulo){ 
    var classChidrem = classModal.replace(/bd-example-/g, '');
    var divModal = $('<div id="'+idModal+'" class="modal fade" role="dialog" '+attrModal+'> </div>');
    var divModalChildren = $('<div id="div_mod_dialog" class="modal-dialog '+classChidrem+'"> </div>');
    var divContent = $('<div class="modal-content">');
    var divHader = $('<div id="mdHader_'+idModal+'" class="modal-header">');
    var divBody = $('<div id="mdBody_'+idModal+'" class="modal-body">');
    var divfooter = $('<div id="mdFooter_'+idModal+'" class="modal-footer">');
    var hTitle = $('<h4 class="modal-title">'+titleModal+'</h4>');
    var btClose = $('<button type="button" class="close" data-dismiss="modal">&times;</button>');
    var closeDefault = [];
    var existeModal = $('.modal').length;
    var timeOutNum = existeModal > 0 ? 700 : 0;
    var butonsModal = pButonsModal;
    global_altoBody = existeModal > 0 ? global_altoBody : $('body').height();
    divHader.html('');
    divfooter.html('');

    if(g_modulos_no_aplica != null){
        if(g_modulos_no_aplica.indexOf(key_modulo) == -1){
            divBody.html(contentModal);
        }else{
            divBody.html('Estimado usuario, usted no posee permisos para visualizar este m&oacute;dulo');
            butonsModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
        }
    }else{
        divBody.html(contentModal);
    }

    if(closeModal){
        divHader.append(btClose);
    }
    divHader.append(hTitle);
  
    for(b=0; b<butonsModal.length; b++){
        var btn = butonsModal[b];
        var clases = btn['class'] != '' ? btn['class'] : 'btn-default';
        var mdBoton = $('<button type="button" class="btn '+clases+'" id="'+btn['id']+'">'+btn['label']+'</button>');
        
        divfooter.append(mdBoton);
        if(btn['class'].indexOf('close-modal-general') > -1){
            closeDefault.push(btn['id']);
        }
    }
  
    divContent.append(divHader);
    divContent.append(divBody);
    divContent.append(divfooter);
    divModalChildren.html(divContent);
    divModal.html(divModalChildren);
    $('body').append(divModal);
  
    $('#'+idModal).bind('hidden.bs.modal', function () {
        console.log('cerrando modal', idModal);
        $('#'+idModal).remove();
        if(typeof fnCloseModal == 'function'){
            fnCloseModal();
        }

        setTimeout(function(){
            var countModalWindow = $('.modal:visible').length;
            var urlWindow = location.href.split('?');
            var arrPathUrl = urlWindow[0].split('/');
            console.log('arrLocation:',arrPathUrl,' countModalWindow:',countModalWindow);
            if((arrPathUrl.indexOf('acciones') > -1 || arrPathUrl.indexOf('Acciones') > -1) && countModalWindow == 0){
                console.log('Ejecutando close.........');
                window.close();
                window.close();
            }
        }, 500);

    });
  
    if(openModal == undefined || openModal == true){
        runLoading(true);
        setTimeout(function(){
            runLoading(false);
            $('#'+idModal).modal({backdrop: "static",show:true});
        }, timeOutNum);        
    }

    $('#'+idModal).bind('shown.bs.modal', function() {
        setTimeout(function(){
            var heightBody = global_altoBody;//$('body').height();
            var heightModal = $('.modal-content').height();
            if((heightBody - 30) <= heightModal){
                $('.modal-content').addClass('content_modal');
                $('.modal-dialog').addClass('dialog_modal');
                $('.modal-body').addClass('body_modal');
            }

        },500);        
    });

    //Aplicar evento click para cerrar modal
    for(c=0; c<closeDefault.length; c++){
        $('#'+closeDefault[c]).click(function(){
            $('#'+idModal).modal('hide');
        });
    }
}


function openPage(page){
  var urlConsulta = 'Home/getPageLoad';
  var paramConsulta = {};
  
  paramConsulta['page'] = page;
  
  runLoading(true); 
  $.ajax({    
    url: urlConsulta, 
    type: "POST",  
    dataType: "html",          
    data: paramConsulta,
    encode:true,
    success:function(resp){
      runLoading(false);
      console.log('LISTA_ORDEN : ',resp);
      $('#contenedor_page').html(resp);
    },
    error: function(result) {
      runLoading(false);
      console.log('ERROR_AJAX: La operaci\u00f3n no se pudo completar por que ocurrio un error en la base de datos');
    }
  });
  
}

// funccion para aplicarle plugin fiileinput a un campo input file
function aplicInputFile(showPreview,id_input,browseLabel,array_allowedFileExtensions,objDatosFiles,showDelete,msgPlaceholder,type_extension,overwrite){

    /*
     showPreview = true o false. con este parametro decidimos si queremos que la imagen se previsualice 
     id_input = identificador del campo file del formaulario
     browseLabel = el lebel del campo file    
     array_allowedFileExtensions = array de las extensiones de archivos permitidas para subir
     objDatosFiles = objto de datos a cargar
     showDelete = true o false. con este parametro dicidimos si se muestra la opcion de elimianr en cada archivo     
     msgPlaceholder = nombre del placeholder del campo file
     type_extension = la extension del archivo a subir
     overwrite = true o false. con este parametro decidimos si se sobrescribe el archivo adjuntado

    */ 
       
        var aux_rutas_files = [];
        var datos_files =  JSON.parse(objDatosFiles);     
        var codigos_delete = [];
        var prewConfig = []; 
        var aux_prewConfig = '';         

        if (datos_files != null && datos_files != "") {
            for(fila in datos_files){
             aux_rutas_files.push(datos_files[fila]["ruta"]);           
             aux_prewConfig = {caption: ''+datos_files[fila]["nombre"]+'', size: 329892, width: "120px", url: "", key: ''+datos_files[fila]["cod_file"]+''};
             prewConfig.push(aux_prewConfig);                   
            }
        }

      $("#"+id_input).fileinput({
                            theme: 'fas',
                            uploadUrl: '#', 
                            language: 'es',
                            previewFileType: "any",
                            allowedFileExtensions: array_allowedFileExtensions, 
                            showUpload : false,
                            showRemove : false,
                            showCaption: true,
                            showPreview: showPreview,    
                            showCancel : false,
                            showClose : false,
                            initialPreviewAsData: true, 
                            overwriteInitial: overwrite,                         
                            initialPreview: aux_rutas_files,
                            initialPreviewConfig: prewConfig,                                    
                            browseLabel : browseLabel,
                            minFileCount: 1,
                            maxFileCount: 20,
                            maxFileSize:1024000,
                            fileActionSettings:{
                                showRemove:showDelete,
                                showUpload:false
                            }                                                   
                        });

                        $(".kv-file-remove").on("click",function(){
                            var id_file = $(this).attr("data-key");
                            var ruta = $(this).closest(".file-preview-frame").find(".kv-file-content > img").attr("src");
                            var objData = {};
                            objData = {"codigo_file":id_file,"ruta":ruta};                           
                            $("#imagen_pr").find("option[value= '"+id_file+"']").remove();                            
                            global_array_data_delete.push(objData);
                            $(this).closest(".file-preview-frame").remove();
                        });  
}  


// funcion para validar la extencion(s) de un archivo
function validarExtFile(id_file,extensiones_file){

   var respueta = validarExtensionFile(id_file,extensiones_file);
      if (respueta!='OK') {
         var idModal = 'modalConfirmar';
         var botonesModal = [{
                              "id": "cerrarMd",
                              "label": "Aceptar",
                              "class": "btn-primary"
                           }];

         crearModal(idModal, 'Advertencia', respueta, botonesModal, false, '', '',true);                           
         $('#cerrarMd').click(function() {
            $('.modal').modal('hide');
         });                
          return false;
      }  
} 

//funcion para obtener la extension de un archivo
function getFileExtension(filename) {
  return (/[.]/.exec(filename.trim())) ? /[^.]+$/.exec(filename.trim())[0] : undefined;
}

//funcion para traer la fecha actual. recive un parametro para definir el formato su valor es 0 = "dd/mm/yyyy" si no "yyyy/mm/dd"

function getFechaActual(formato){  
  var date = new Date();
  var dia = date.getDate() < 10 ? ("0"+date.getDate()) : date.getDate();
  var mes = (date.getMonth() +1) < 10 ? "0"+(date.getMonth() +1) : (date.getMonth() +1);
  var anio = date.getFullYear();
  var fechaActual = "";
  if (formato == 0) {
     fechaActual = anio + "/" + mes + "/" + dia;
  }else{
     fechaActual = dia + "/" + mes + "/" + anio;
  }  
    
  return fechaActual;
}



/*
  funcion para validar un rango de valores.
*/

function validarRango(campo, mayor, menor){
    //console.log('campo -> ',campo.value, ' mayor -> ', mayor);
    var valor = parseInt(campo.value);
    var limite = parseInt(mayor);
    var limiteMenor = menor != undefined ? parseInt(menor) : 0;
    //console.log('campo -> ',typeof parseInt(valor), ' mayor -> ', typeof limite);
    if(valor > limite || valor < limiteMenor){
      //console.log('valor falso, no puede ser mayor');
      var val = valor.toString();
      var valAux = parseInt(val.substring(0, val.length - 1));
      while(valAux > limite || valAux < limiteMenor){
        val = valAux.toString();
        valAux = parseInt(val.substring(0, val.length - 1));
        //console.log('val1 -- ',valAux);
      }

      campo.value = val.substring(0, val.length - 1);
    }
    
    setTimeout(function(){
      if(campo.value == '' || campo.value == undefined){
        //campo.value = 0;
      }
    },1000);

}

function fechaActual(){
    var objFecha = {};
    var fecha = new Date();
    objFecha['anio'] = auxFecha(fecha.getFullYear());
    objFecha['mes'] = auxFecha(fecha.getMonth() + 1);
    objFecha['dia'] = auxFecha(fecha.getDate());
    objFecha['dia_semana'] = auxFecha(fecha.getDay());
    objFecha['hora'] = auxFecha(fecha.getHours());
    objFecha['minuto'] = auxFecha(fecha.getMinutes());
    objFecha['segundo'] = auxFecha(fecha.getSeconds());

    return objFecha;
}

function auxFecha(numero){
    var datoRetorno = String(numero);
    if(numero < 10){
        datoReturn = '0' + String(numero);
    }

    return datoRetorno;
}

/*funcion retornar la hora formateada con minutos*/

function formatHora(){
  var tiempo = new Date();
  var minutos = tiempo.getMinutes();
  var segundos = tiempo.getSeconds();
  var hora = tiempo.getHours();  
  var aux_hora ="";   
  var tipo_hora = "";
  var anio = fechaActual()["anio"];
  var mes = fechaActual()["mes"];
  var dia = fechaActual()["dia"];

  if (minutos < 10) {
    minutos = "0" + minutos;
  }else{
    minutos = "" + minutos;
  }
  if (segundos < 10) {
    segundos = "0" + segundos;
  }else{
    segundos = "" + segundos;
  }

  if (hora > 12) {
    tipo_hora = "PM";
  }else{
    tipo_hora = "AM";
  }  

  if (hora > 12) {
    hora -= 12;
  }else{
    hora = hora;
  }

  if (hora == 0) {
    hora = 12;
  }else{
    hora = hora;
  }

  if (dia < 10) {
    dia = "0" + dia;
  }else{
    dia = "" + dia;
  }

  if (mes < 10) {
    mes = "0" + mes;
  }else{
    mes = "" + mes;
  }

  aux_hora = dia+"/"+mes+"/"+anio+"  "+ hora+":"+minutos+":"+segundos+" "+tipo_hora;

  return aux_hora;
}

function llamarRecursive(){
    var url = 'Home/recursiveCallback_control';
    var arrDatos = [{"AA":"11","BB":"22","CC":"33"},{"AA":"44","BB":"55","CC":"66"},{"AA":"77","BB":"88","CC":"99"},{"AA":"00","BB":"12","CC":"34"},{"AA":"56","BB":"78","CC":"90"},{"AA":"09","BB":"87","CC":"65"},{"AA":"43","BB":"21","CC":"10"}];
    var paramadd = {"param1":123, "param2":456, "param3":7890};
    recurAjaxCallback(url, arrDatos, paramadd, 1, 0, 2, function(estado, datos){
        var nomEstado = ['error', 'success'];
        //console.log('CALLBACK-------------------------------------- ');
        //console.log('Estado de la tranaccion...', nomEstado[estado]);
        //console.log('Datos de la tranaccion...', datos);
    });
}

function recurAjaxCallback(p_url, p_registros, p_paramadd, p_senal, p_iteracion, p_bash, p_fn_callback){
    var v_bash = p_bash < 1 ? p_registros.length : p_bash;
    var posicionIni = p_iteracion * v_bash;
    var posicionFin = posicionIni + v_bash;
    var paramObj = {};
    //Definir prametros default para el llamado ajax
    //paramObj['registros_all'] = p_registros;
    paramObj['registros'] = JSON.stringify(p_registros.slice(posicionIni, posicionFin));
    paramObj['senal'] = p_senal;
    paramObj['iteracion'] = p_iteracion;    
    paramObj['bash'] = v_bash;
    //Combinar parametros default, con parametros adicionales
    if(typeof p_paramadd == 'object'){
        Object.assign(paramObj, p_paramadd);
    }    
    //console.log('AJAX2-------------------------------------- ',p_iteracion);
    //console.log('Datos iteracion : ['+p_iteracion+']', paramObj['registros']);
    runLoading(true);
    $.ajax({
        url: p_url, 
        type: "POST",  
        dataType: "json",         
        data: paramObj,  
        success:function(data){
            if(posicionFin < p_registros.length && p_senal == 1){
                runLoading(false);
                //console.log('Datos success : ', data);
                var v_senal = data['senal'] != undefined ? data['senal'] : p_senal;
                recurAjaxCallback(p_url, p_registros, p_paramadd, v_senal, p_iteracion + 1, v_bash, p_fn_callback);
            }else{
                runLoading(false);                
                p_fn_callback(1, data);
            }
        },
        error: function(error){
            runLoading(false);
            console.log('Datos error : ', error);
            p_fn_callback(0, error);
        }
    });
}

//funcion para validar solo numeros en dispositivos mobiles
// recive una cadena separada por comas, entre los ids de cada campo
function validarSolonumerosMobile(string_idsCampos){

    var str = string_idsCampos;
    var idCampo = str.split(",");

    for (var i = 0; i < idCampo.length; i++) {
        $("#"+idCampo[i]).on('input', function () { 
         this.value = this.value.replace(/[^0-9]/g,'');
        });
    }
    
}

function pointToUrl(){
    var cadena = '';
    var cPunto = '../';
    var aux_url=location.href.split("/");
    var nPosition = 0;

    if(aux_url[aux_url.length-1] != ''){
      nPosition = (aux_url.length - aux_url.indexOf("invent_online")) - 2;
      
    }else{
      nPosition = (aux_url.length - aux_url.indexOf("invent_online")) - 3;  
    }

    for(p=0; p<nPosition; p++){
      cadena += cPunto;
    }

    return cadena;
}


//funcion pra validar un rango de fechas con datepicker
function validRangoFechas(fechaInicio, fechaFin){
    
      if(fechaInicio != '' && fechaInicio != undefined){  

            $('#'+fechaInicio).datepicker({
                locale: 'es-es',
                format: 'yyyy/mm/dd',
                //uiLibrary: 'bootstrap4',
                //iconsLibrary: 'fontawesome',              
                maxDate: function () {
                    return $('#'+fechaFin).val() == "" ? getFechaActual(0) : $('#'+fechaFin).val();
                },
                change: function (e) {
                    if(fechaFin != '' && fechaFin != undefined){
                        var valFechaIni = aplicarFormatDate($('#'+fechaInicio).val());
                        var valFechaFin = aplicarFormatDate($('#'+fechaFin).val());

                        if(valFechaIni != '' && valFechaFin != ''){
                            var dateIni = new Date(valFechaIni);
                            var dateFin = new Date(valFechaFin);
                            if(dateIni > dateFin){
                                $('#'+fechaFin).val('');
                            }
                        }               
                    }
               }
            });

             $('#'+fechaInicio).bind("cut copy paste",function(e) {
                 e.preventDefault();
             });

              $('#'+fechaInicio).attr({
                    "onkeypress":"return false;",
                    "autocomplete":"off"
              });
      }

     if(fechaFin != '' && fechaFin != undefined){

        $('#'+fechaFin).datepicker({
            locale: 'es-es',
            format: 'yyyy/mm/dd',
            //uiLibrary: 'bootstrap4',
            //iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#'+fechaInicio).val();
            },           
            maxDate:getFechaActual(0)
        });

         $('#'+fechaFin).bind("cut copy paste",function(e) {
             e.preventDefault();
        });

         $('#'+fechaFin).attr({
                "onkeypress":"return false;",
                "autocomplete":"off"
         }); 

    }   
   
}

function aplicarFormatDate(fecha, formato){
    var formatFecha = formato == undefined ? 'dd-mm-yyyy' : formato;
    var arrFecha = fecha.indexOf('/') > -1 ? fecha.split('/') : fecha.split('-');
    var resFecha = fecha;
    //aplicar formato mm/dd/yyyy
    if(formatFecha == 'dd-mm-yyyy' || formatFecha == 'dd/mm/yyyy'){
        if(arrFecha.length >= 2){
            resFecha = arrFecha[1] + '/' + arrFecha[0] + '/' +  arrFecha[2];
        }       
    }else{
        if(formatFecha == 'yyyy-mm-dd' || formatFecha == 'yyyy/mm/dd'){
            if(arrFecha.length >= 2){
                resFecha = arrFecha[1] + '/' + arrFecha[2] + '/' +  arrFecha[0];
            }
        }
    }
    
    return resFecha;
}

function iniciarMap(){
    /*var coord = {lat:-34.5956145 ,lng: -58.4431949};
    var map = new google.maps.Map(document.getElementById('mapContainer'),{
      zoom: 10,
      center: coord
    });
    var marker = new google.maps.Marker({
      position: coord,
      map: map
    });*/
}

function callAjaxCallback(p_url, p_paramadd,p_fn_callback){   
        runLoading(true);
        $.ajax({    
                url: p_url,  
                type: "POST",  
                dataType: "json",
                data:p_paramadd,   
                success:function(resp){
                    runLoading(false);
                    console.log("succes");
                    refrescarGlobales(); //Refrescar variables globales del home view
                    p_fn_callback(1, resp);                       
                },
                error: function(error) {
                    runLoading(false); 
                    console.log("error"); 
                    p_fn_callback(0, error);                   
                }

           });
}

function callAjaxCallbackFile(p_url, p_paramadd,p_fn_callback){   
    runLoading(true);
    $.ajax({    
            url: p_url,  
            type: "POST",  
            dataType: "json",
            data: p_paramadd,
            cache: false,
            contentType: false,
            processData: false,
            success:function(resp){
                runLoading(false);
                console.log("succes");
                refrescarGlobales(); //Refrescar variables globales del home view
                p_fn_callback(1, resp);                       
            },
            error: function(error) {
                runLoading(false); 
                console.log("error"); 
                p_fn_callback(0, error);                   
            }

       });
}

/*funcion para aplicar el data table*/
function aplicarDatatableGeneral(idTabla){
  $('#'+idTabla).DataTable({
    responsive: true,    
    "ordering": false,
    "colReorder": true,
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
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf']
  });
}

/*funcion para crera una tabla con el datatable
  IDTABLE
  columnTable RETORNO getColumnTable
  data: DATOS DEL CONTROLADOR EN FORMATO JSON
*/
function createTable(idTabla, columnTable, data){
  var table = $('<table width="100%" class="table table-striped table-bordered table-hover" id="'+idTabla+'" cellspacing="0"> </table>');
  var thead = $('<thead> </thead>');
  var tbody = $('<tbody> </tbody>');
  var trHead = $('<tr></tr>');
  var arrUndefined = [undefined, 'undefined', null, 'null'];
  var datos = data;

  //Llenar cabecera de la tabla
  for(z=0; z<columnTable.length; z++){
      var tdHead = $('<td><b>'+columnTable[z]['label']+'</b></td>');
      trHead.append(tdHead);
  }
  thead.html(trHead);

  //Llenar cuerpo de la tabla
  if(datos.length > 0 &&  typeof datos == 'object'){
      
      //Llenar de datos el cuerpo de la tabla
      for(x=0; x<datos.length; x++){
          var trbody = $('<tr></tr>');    
          for(y=0; y<columnTable.length; y++){
              var labelTd = datos[x][columnTable[y]['column']];
              var labelTd_aux = arrUndefined.indexOf(labelTd) > -1 ? '' : labelTd+'';
              var alingTd = '';
              if(columnTable[y]['format'] != undefined){
                  /*if(columnTable[y]['format'] == 'numero'){
                      labelTd = labelTd_aux.trim() != '' ? formatMiles(labelTd_aux) : '';
                      alingTd = ' class="class-numero"';
                  }else{
                      if(columnTable[y]['format'] == 'miles'){
                          labelTd = labelTd_aux.trim() != '' ? formatMiles(labelTd_aux) : '';
                          alingTd = ' class="class-pesos"';
                      }
                  }*/
                  var formatCampTd = formatCampTable(columnTable[y]['format'], labelTd_aux);
                  labelTd = formatCampTd['label'];
                  alingTd = formatCampTd['attr'];

              }
              var tdbody = $('<td '+alingTd+'>'+labelTd+'</td>');
              trbody.append(tdbody);
          }

          tbody.append(trbody);
      }
  }else{
      tbody.html('');
  }

  table.html(thead);
  table.append(tbody);   
  
  return table;
}

function formatCampTable(format, labelText){
  objResult = {};
  objResult['label'] = '';
  objResult['attr'] = '';
  
  if(format == 'numero'){
      objResult['label'] = labelText.trim() != '' ? formatMiles(labelText) : '';
      objResult['attr'] = ' class="class-numero"';
  }else{
      if(format == 'miles'){
          objResult['label'] = labelText.trim() != '' ? formatMiles(labelText) : '';
          objResult['attr'] = ' class="class-pesos"';
      }
  }

  return objResult;
}

/*funcion que retorna las columnas que va ha tener la tabla donde
colmn es el nombre real del select 
label es el nombre qeu se va ha mirar en la tabla*/
function getColumnTable(tabla){
columns = {
      "permisos_campo_rol" : [
          {"column":"nom_tabla", "label":"Tabla"},
          {"column":"nom_campo", "label":"Campo"},            
          {"column":"ch_estado", "label":"Estado", "attribs":'class="center_th"'}
      ],
      "1" : [
              {"column":"identificacion", "label":"Identificaci&oacute;n"},
              {"column":"nombre", "label":"Nombre"},            
              {"column":"telefono", "label":"Tel&eacute;fono"},
              {"column":"email", "label":"Correo el&eacute;ctronico"},
              {"column":"direccion", "label":"Direcci&oacute;n"},            
              {"column":"login", "label":"Login"},            
              {"column":"rol", "label":"rol"},
              {"column":"estado", "label":"Estado"},
              {"column":"editar", "label":"Editar", "attribs":'class="class_edit"', "attribs_head":'class="class_edit"'},
              {"column":"activar", "label":"Activar"},
              {"column":"eliminar", "label":"Desactivar", "attribs":'class="class_delete"', "attribs_head":'class="class_delete"'}                    
          ],   
      "2" : [
              {"column":"identificacion", "label":"Nit"},
              {"column":"nombre", "label":"Nombre"},
              {"column":"telefono", "label":"Tel&eacute;fono"},
              {"column":"email", "label":"Correo el&eacute;ctronico"},
              {"column":"direccion", "label":"Direcci&oacute;n"},           
              {"column":"login", "label":"Login"},
              {"column":"rol", "label":"rol"},                   
              {"column":"estado", "label":"Estado"},
              {"column":"editar", "label":"Editar", "attribs":'class="class_edit"', "attribs_head":'class="class_edit"'}, 
              {"column":"activar", "label":"Activar"},
              {"column":"eliminar", "label":"Desactivar", "attribs":'class="class_delete"', "attribs_head":'class="class_delete"'}                
          ]
    };

    return columns[tabla];

}

function validar_solo_letras(e){
  
    var tecla = (document.all) ? e.keyCode : e.which;  
    if (tecla == 8 || tecla == 45){
        return true;
    }
        
    var patron = /[A-Za-zñÑ\s]/; // [A-Za-zñÑ\s solo letras y espacios  \d solo numeros 
    var te = String.fromCharCode(tecla);    
   
    return patron.test(te);
}

function removerOpcionesMenu(){
  if(typeof g_modulos_no_aplica != 'undefined'){
      if(g_modulos_no_aplica != null){
          var opcionesMenu = g_modulos_no_aplica;

          for(o=0; o<opcionesMenu.length; o++){
              var opcionMenu = opcionesMenu[o];
              $('.'+opcionMenu).remove();
          }
      }
      
  }    
}

function validarMonto(campo, presupuesto){
    var valor_aux = (campo.value).replace(/\./g,'');
    var valor = parseInt(valor_aux);
    var limite = presupuesto != undefined ? parseInt(presupuesto) : 0;
    
    if(valor > limite && presupuesto != undefined){
        var val = valor.toString();
        var valAux = parseInt(val.substring(0, val.length - 1));
        while(valAux > limite){
            val = valAux.toString();
            valAux = parseInt(val.substring(0, val.length - 1));
        }

        valor_aux =  val.substring(0, val.length - 1);
        campo.value = formatMiles(valor_aux);
    }else{
        valor_aux =  formatMiles(campo.value);
        campo.value = valor_aux;
    }
    
    setTimeout(function(){
        /*if(campo.value == '' || campo.value == undefined){
            campo.value = 0;
        }*/
    },1000);    
}


function llamarAccionPoligono(accion, codPoligono, cod_predio_const, url_doc){
    console.log('Accion: '+accion+'\nPredio: '+codPoligono);    
    if(accion == 1){//Informacion poligono
        traerInfoPredio(codPoligono);
    }else{
        if(accion == 2){//Registrar reporte de irregularida en poligono
            reportarIrregular(codPoligono);
        }else{
            if(accion == 3){//Panorama de riesgos
                verPanorama(codPoligono, cod_predio_const);
            }else{
                if(accion == 4){//Gestionar panorama de riesgos
                    gestionarPanorama();
                }else{
                    if(accion == 5){//Descargar documento pdf
                        descargarDocPdf(url_doc);
                    }else{
                        if(accion == 6){//Descargar documento pdf ref
                            descargarDocPdfRef(url_doc);
                        }
                    }
                    
                }
            }
        }
    }
}