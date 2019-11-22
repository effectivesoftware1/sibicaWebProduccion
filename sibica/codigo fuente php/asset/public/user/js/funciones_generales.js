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
        $('#modmanual_login').removeClass('');
    }else{
        $("#li_user_no_logueado").show();
        $("#li_contend_admin").remove();
        $("#li_user_logueado").remove();
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
  //console.log('select -> ', selectedItem);
  $('#bs-example-navbar-collapse-1').find('li').each(function(index, elemento){
    console.log('onclic -> ',$('#bs-example-navbar-collapse-1').find('li').eq(index).children('a').attr('onclick_'));
    if($('#bs-example-navbar-collapse-1').find('li').eq(index).children('a').attr('onclick_') != undefined){
      if($('#bs-example-navbar-collapse-1').find('li').eq(index).children('a').attr('onclick_').indexOf(selectedItem) > -1){
        //console.log('Entroooo...............');
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
        alertify.notify(msj['mensaje'], 'error', 5, function(){ $('#div_required_nexos').remove(); });
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
    var hTitle = $('<h5 class="modal-title"><img src="./asset/public/img/logo_sibica.png" style="width:30px;height:30px;"> '+titleModal+'</h5>');
    var btClose = $('<button type="button" class="close" data-dismiss="modal">&times;</button>');
    var closeDefault = [];
    var existeModal = $('.modal').length;
    var timeOutNum = existeModal > 0 ? 700 : 0;
    var butonsModal = pButonsModal;
    console.log(global_altoBody,' - Heigh :: ', $('body').height());
    //global_altoBody = existeModal > 0 ? global_altoBody : $('body').height();
    global_altoBody = global_altoBody == 0 ? $('body').height() : global_altoBody;
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
            var heightModal = $('.modal-content:visible').last().height();//$('.modal-content').height();
            if((heightBody - 30) <= heightModal){
                $('.modal-content:visible').last().addClass('content_modal');
                $('.modal-dialog:visible').last().addClass('dialog_modal');
                $('.modal-body:visible').last().addClass('body_modal');
            }
        },500);        
    });

    /*$('#'+idModal).resize(function() {
        setTimeout(function(){
            var heightBody = global_altoBody;//$('body').height();
            var heightModal = $('.modal-content:visible').last().height();//$('.modal-content').height();
            if((heightBody - 30) <= heightModal){
                $('.modal-content:visible').last().addClass('content_modal');
                $('.modal-dialog:visible').last().addClass('dialog_modal');
                $('.modal-body:visible').last().addClass('body_modal');
            }
        },300);
    });*/

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
function aplicarDatatableGeneral(idTabla,arrayColums,title){
 
  var aux_arrayColums = "";  
  var aux_title = "";

  if (arrayColums == "" || arrayColums == undefined) {
      aux_arrayColums = ":visible";
  }else{
      aux_arrayColums = arrayColums.split(",");
  }

  if (title == "" || title == undefined) {
      aux_title = "";
  }else{
      aux_title = title;
  }
  
 
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
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<img src="./asset/public/img/excel.png" class="img-button_table">',
                titleAttr: 'Excel',
                exportOptions: {
                    columns: aux_arrayColums
                }
            },
            {
                extend:    'pdfHtml5',
                text:      '<img src="./asset/public/img/pdf.png" class="img-button_table">',
                titleAttr: 'PDF',
                title: aux_title,
                messageTop: getTimestamp(),
                filename:"archivo",
                //messageBottom: getTimestamp(),                
                exportOptions: {
                    columns: aux_arrayColums
                },
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',                        
                        image: 'data:image/jpeg;base64,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'
                    } );
                }
                
            }

        ]
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
    var datos = data;
    var datosExcluir = ['undefined', 'null', undefined, null,'',' '];

    //Llenar cabecera de la tabla
    for(z=0; z<columnTable.length; z++){
        var atributos_head = columnTable[z]['attribs_head'] != undefined ? columnTable[z]['attribs_head'] : '';
        var tdHead = $('<td '+atributos_head+'><b>'+columnTable[z]['label']+'</b></td>');
        trHead.append(tdHead);
    }
    thead.html(trHead);

    //Llenar cuerpo de la tabla
    if(datos.length > 0 &&  typeof datos == 'object'){
        
        //Llenar de datos el cuerpo de la tabla
        for(x=0; x<datos.length; x++){
            var trbody = $('<tr></tr>');            
            
            for(y=0; y<columnTable.length; y++){
                var labelTd = datosExcluir.indexOf(datos[x][columnTable[y]['column']]) > -1 ? '' : datos[x][columnTable[y]['column']];
                var atributos = columnTable[y]['attribs'] != undefined ? columnTable[y]['attribs'] : '';
                if(columnTable[y]['format'] != undefined){
                    var formatCampTd = formatCampTable(columnTable[y]['format'], labelTd);
                    labelTd = formatCampTd['label'];
                    atributos = atributos +' '+formatCampTd['attr'];  
                }
                
                var tdbody = $('<td '+atributos+'>'+labelTd+'</td>');
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
          {"column":"ch_estado", "label":'Estado <br><input type="checkbox" id="chcAll">', "attribs":'class="center_th"', "attribs_head":'class="center_th"'}
      ],
      "observacion_persona" : [
            {"column":"documento_ovp", "label":"Documento"},
            {"column":"nombre_ovp", "label":"Nombre"},
            {"column":"cargo_ovp", "label":"Cargo"},
            {"column":"quitar", "label":'Quitar'}
        ],
        "reporte_terreno": [
            {"column":"predial_terreno", "label":"No. Predial"},
            {"column":"nombre_proyecto", "label":"Nombre Proyecto"},
            {"column":"codigonal", "label":"Código Nacional"},
            {"column":"calidad_bien", "label":"Calidad del Bien"},
            {"column":"direccion_oficial", "label":"Dirección Oficial"},
            {"column":"tipo_bien", "label":"Tipo de Bien"},
            {"column":"barrio", "label":"Barrio"},
            {"column":"comuna", "label":"Comuna"},
            {"column":"n_folio", "label":"No. Folio"},
            {"column":"modo_adquisicion", "label":"Modo Adquisición"},
            {"column":"dependencia", "label":"Organismo"},
            {"column":"nombrecomun_p", "label":"Nombre Común"},
            {"column":"tipo_documento", "label":"Tipo de Documento"},
            {"column":"numero_documento", "label":"Número de Documento"},
            {"column":"fecha_doc", "label":"Fecha Documento"},
            {"column":"notaria_doc", "label":"Notaría"},
            {"column":"area_cesion", "label":"Área Cesión"},
            {"column":"area_actual", "label":"Área Actual"},
            {"column":"area_sicat", "label":"Área Sicat"},
            {"column":"area_terreno", "label":"Área en SAP"}
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

function validarMonto(campo, valmin, valmax){
    var valor_aux = (campo.value).replace(/\./g,'');
    var valor = parseInt(valor_aux);
    var limite = valmax != undefined ? parseInt(valmax) : 0;
    
    if(valor < valmin){
        valor_aux =  formatMiles(valmin);
        campo.value = valor_aux;
    }else{
        if(valor > limite && valmax != undefined){
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
        traerInfoPredio(codPoligono, cod_predio_const);
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
                        }else{
                            if(accion == 8){//Visita tecnica
                                verVisita(codPoligono, cod_predio_const);
                            }else{
                                if(accion == 9){//Ficha tecnica
                                    printFichaTecnica(codPoligono, cod_predio_const);
                                }else{
                                    if(accion == 10){//Expediente sesion
                                        descargarDocPdfExSesion(url_doc);
                                    }
                                }
                            }
                        }
                    }
                    
                }
            }
        }
    }
}

function getTimestamp(){
    var date = new Date();
    var anio = date.getFullYear();
    var mes = (date.getMonth()+1) < 10 ? "0"+(date.getMonth()+1) : (date.getMonth()+1);
    var dia = date.getDate() < 10 ?  "0"+date.getDate() : date.getDate();
    var hora = date.getHours() < 10 ? "0"+date.getHours() : date.getHours(); 
    var minuto = date.getMinutes() < 10 ? "0"+date.getMinutes() : date.getMinutes();
    var segundo = date.getSeconds() < 10 ? "0"+date.getSeconds() : date.getSeconds(); 
    var fecha = anio+"/"+mes+"/"+dia+" "+hora+":"+minuto+":"+segundo;
    
    return fecha;
}

function fnPrueba(){

    var idModal = 'modal_dialog_save_rol';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm"}];

    var formData = {};

        var url = "WebService/enviarEmailTareasVencidas"
        var mensaje = "";
        callAjaxCallback(url,formData,function(tipo_respuesta,data){
            console.log('Datos rol: ', data);
            if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            }else{               
                console.log("pasoo");
            }

        });
}

function callAjaxCallbackTx(p_url, p_paramadd,p_fn_callback){   
    runLoading(true);
    $.ajax({    
            url: p_url,  
            type: "POST",  
            dataType: "text",
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