var global_tareas_panorama = {};
var global_clasifica_tarea = [];

function verPanorama(codigo_predio, cod_predio_const){

    runLoading(true); 

    var idModal = 'modal_dialog_save_modulo';
    var botonesModal = [{"id":"add_tarea","label":"Agregar tarea","class":"btn-primary btn-sm"},{"id":"save_panorama","label":"Guardar","class":"btn-primary btn-sm panorama-key-css_1"},{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary close-modal-general btn-sm"},{"id":"ver_matriz","label":"Matriz","class":"btn-primary btn-sm"}];
    var botonModal = [{"id":"cerrar_modal","label":"Cerrar","class":"btn-primary close-modal-general btn-sm"}];
    $.ajax({    
          url: "Panorama_riesgos/getPanoramas", 
          type: "POST",  
          dataType: "json",                   
          cache: false, 
          data:  {codigo_predio:codigo_predio, codigo_predio_const:cod_predio_const,codigo_panorama:-1},                        
          success:function(data){
            runLoading(false);                                    
             
            crearModal(idModal, 'Gestionar panorama de riesgos', data["panoramaView"], botonesModal, false, 'modal-lg', '',true, null, 'panorama-key-css');
                       
            aplicarDatatableGeneral("tablaTareas");
            var dataPanorama = data["datosPanorama"][0];

              if (dataPanorama == "") {
                 var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
                 aplicInputFile(true,'file_panorama','Cargar foto',aux_array_ext,"[]",false,'Seleccionar imagen','',true);      
              }
              $("#save_panorama").on("click",function(){
                var codigo_panorama = $("#id_panorama_riesgos").val() == "" ? -1 : $("#id_panorama_riesgos").val();
                savePanorama(0,"",codigo_panorama,codigo_predio,cod_predio_const);                
              });   
              
              $("#add_tarea").on("click",function(){                    
                    var codigo_panorama = $("#id_panorama_riesgos").val() == "" ? -1 : $("#id_panorama_riesgos").val();
                    gestionarTareaPanorama(codigo_panorama, '-1');
              });

              if (dataPanorama != "") {

                  var aux_obj_data = '[{"ruta":"'+dataPanorama["ruta_file"]+'","nombre":"'+dataPanorama["nombre_file"]+'","cod_file":0}]';    
                  var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
                  aplicInputFile(true, 'file_panorama', 'Cargar imagen', aux_array_ext, aux_obj_data, false, 'Seleccionar imagen', '', true);
                  
                  $("#responsable_p").val(dataPanorama["usuario_responsable"]); 
                  $("#atendido_por_p").val(dataPanorama["atendido_por_panorama"]);               
                  $("#email_responsable").val(dataPanorama["correo_responsable_panorama"]);        
                  $("#descripcion_panorama").val(dataPanorama["descripcion_panorama"]);        
                  $("#estado_panorama").val(dataPanorama["nombre_estado"]);
                  $("#estado_panorama").attr("data-estado",dataPanorama["estado_pr_fk"]);
                  $("#fecha_inspeccion").val(dataPanorama["fecha_creacion"]); 

                  $("#label_panorama_riesgos").text("Panorama de Riesgo  No. "+dataPanorama["id_panorama"]);
                  $("#id_panorama_riesgos").val(dataPanorama["id_panorama"]);

              }
              
          },
          error: function(result) {
            runLoading(false);
            crearModal(idModal, 'Confirmarci\u00f3n', 'Se presentaron problemas al guardar el registro', botonModal, false, '', '');
            $("#cerrar_rol").click(function(){
                $("#modal_dialog_save_modulo").modal("hide");                       
            });

          }
       });    
    
}


function savePanorama(codigo_file,file_anterior,codigo,codigo_predio,codigo_construccion){

    var idModal2 = 'modal_dialog_save_modulo1';
    var botonModal2 = [{"id":"cerrar_rol_1","label":"Cerrar","class":"btn-primary btn-sm"}];
    
    var requeridos = [{"id":"id_panorama_riesgos", "texto":"C&oacute;digo panorama"},
                      {"id":"atendido_por_p", "texto":"Atendido por"},
                      {"id":"responsable_p", "texto":"Responsable"},
                      {"id":"email_responsable", "texto":"Email"},
                      {"id":"descripcion_panorama", "texto":"Descripci&oacute;n"}
                      ];

    if(validRequired(requeridos)){

        if ($("#email_responsable").val()!="") {  
             if (validarEmail($("#email_responsable").val()) == -1) {
               $("#email_responsable").focus();
                 alertify.notify('Email incorrecto', 'error', 3,null);
                return false;
             }
         }      

         runLoading(true);        

         var formData = new FormData(document.getElementById("form_panorama"));
          formData.append('codigo_file_panorama',codigo_file);  
          formData.append('file_panorama_ant',file_anterior);
          formData.append('codigo',codigo);
          formData.append('codigo_predio',codigo_predio);
          formData.append('estado_panorama',$("#estado_panorama").attr("data-estado"));         
          formData.append('codigo_construccion',codigo_construccion);

         $.ajax({    
                  url: "Panorama_riesgos/guardarPanorama", 
                  type: "POST",  
                  dataType: "json",
                  data:formData,             
                  cache: false,
                  contentType: false,
                  processData: false,                
                  success:function(data){
                    runLoading(false);
                    console.log("data ", data);
                    crearModal(idModal2, 'Confirmarci\u00f3n',data["result"], botonModal2, false, '', '',true);
                    
                    $("#cerrar_rol_1").click(function(){
                        $("#"+idModal2).modal("hide");  
                        $("#modal_gestionarEditPanorama").modal("hide");                      
                    });          

                    $("#contenedor_table_panorama").html(data["tabla"]);
                    aplicarDatatableGeneral("tabla_panorama");
                  },
                  error: function(result) {
                    runLoading(false);
                    crearModal(idModal2, 'Confirmarci\u00f3n', 'Se presentaron problemas al guardar el registro', botonModal2, false, '', '',true);
                    $("#cerrar_rol_1").click(function(){
                        $("#"+idModal2).modal("hide");                       
                    });

                  }
       });
    }

}

function editpanorama(codigo,descripcion,responsable,atendido_por,correo_responsable,usuario_crea,estado_codigo,nombre_estado,ruta_file,nombre_file,file_codigo,codigo_predio,fecha_inspeccion,codigo_predio_const){
    
    var url = 'Panorama_riesgos/getPanoramas';
    var formData = {};
    var idModal = 'modal_gestionarEditPanorama';
    var botonModal = [{"id":"add_tarea","label":"Agregar tarea","class":"btn-primary btn-sm"},{"id":"save"+idModal,"label":"Guardar","class":"btn-primary btn-sm panorama-key-css_2"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    formData['codigo_predio'] = codigo_predio;
    formData['codigo_predio_const'] = codigo_predio_const;
    formData['codigo_panorama'] = codigo;

    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        console.log('data TAREA', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
        }else{
            mensaje = data["panoramaView"];            
        }
        
        crearModal(idModal, 'Editar panorama de riesgos', mensaje, botonModal, true, 'modal-lg', '',true);
        
        $('#cerrar'+idModal).click(function(){
            $("#"+idModal).modal('hide');               
        });

        var aux_obj_data = '[{"ruta":"'+ruta_file+'","nombre":"'+nombre_file+'","cod_file":0}]';
    
        var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
        aplicInputFile(true,'file_panorama','Cargar imagen',aux_array_ext,aux_obj_data,false,'Seleccionar imagen','',true);      
        
        $("#responsable_p").val(responsable); 
        $("#atendido_por_p").val(atendido_por);               
        $("#email_responsable").val(correo_responsable);        
        $("#descripcion_panorama").val(descripcion);        
        $("#estado_panorama").val(nombre_estado);
        $("#estado_panorama").attr("data-estado",estado_codigo);
        $("#fecha_inspeccion").val(fecha_inspeccion);

        $("#label_panorama_riesgos").text("Panorama de Riesgo  No. "+codigo);
        $("#id_panorama_riesgos").val(codigo);

        $('#save'+idModal).click(function(){
            var aux_file_codigo = file_codigo == "" ? 0 : file_codigo;
            savePanorama(aux_file_codigo,ruta_file,codigo,-1,-1);          
        });

        $("#add_tarea").on("click",function(){
            console.log('Entro tarea');
            var codigo_panorama = $("#id_panorama_riesgos").val() == "" ? -1 : $("#id_panorama_riesgos").val();
            gestionarTareaPanorama(codigo_panorama, '-1');
        });

        aplicarDatatableGeneral("tablaTareas");

    });    
    
}

function gestionarTareaPanorama(codPanorama, codTarea){
    var url = 'Panorama_riesgos/llamarTareaPanorama';
    var formData = {};
    var idModal = 'modal_gestionarTareasPanorama';
    var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    //var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    formData['codPanorama'] = codPanorama;
    formData['codTarea'] = typeof codTarea == 'undefined' ? '-1' : codTarea;

    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        console.log('data TAREA', data);
        var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];  
        var aux_obj_data_file = '[]';
        //aplicInputFile(true,'file_panorama','Cargar imagen', aux_array_ext, aux_obj_data, false,'Seleccionar imagen','',true);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            botonModal.splice(0,1);
        }else{
            var datos = data['result'][0];
            mensaje = data["frm_tarea"];
            global_tareas_panorama= '-1';
            global_clasifica_tarea = data["clasifica_tarea"];

            if(data["status"] > 0){
                botonModal.splice(0,1);
            }else{
                if(codTarea != '-1' && codTarea != undefined && codTarea != null){
                    botonModal.unshift({"id":"addSeguimiento"+idModal,"label":"Agregar seguimiento","class":"btn-primary btn-sm"});
                    aux_obj_data_file = '[{"ruta":"'+datos['patFile']+'","nombre":"'+datos['nameFile']+'","cod_file":0}]';
                }
            }
        }
        
        crearModal(idModal, 'Tarea panorama', mensaje, botonModal, true, 'modal-lg', '',true);
        
        $('#cerrar'+idModal).click(function(){
            $("#"+idModal).modal('hide');               
        });

        $('#aceptar'+idModal).click(function(){
            if(validRequired(getObjRequerid('frm_tarea_panorama', ''))){
                guardarTareaPanorama(codPanorama, codTarea);
            }            
        });

        $('#addSeguimiento'+idModal).click(function(){
            gestionarSeguimientoTarea(codTarea, '-1');
        });        

        aplicInputFile(true,'foto_tr','Cargar imagen', aux_array_ext, aux_obj_data_file, false,'Seleccionar imagen','',true);
        validRangoFechas('fechaVence_tr');
        aplicarDatatableGeneral("tablaSeguimientoTarea");
        
    });
}

function aplicarDataTableCampos(idTabla){
  // Setup - add a text input to each footer cell
  $('#'+idTabla+' thead td').each(function () {
      var title = $(this).text();
      if(title != 'Estado'){
          $(this).append('<br><input type="text" placeholder="Buscar '+title+'" />');
      }        
  });

  // DataTable
  var tableData = $('#'+idTabla).DataTable({
      "retrieve": true,
      "bPaginate": false,
      "scrollY": "300px",
      "scrollX": true,
      "language": {
          "processing":     "Procesando...",
          "search":         "Búsqueda General:",
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
      dom: 'Bfrtip',
      buttons: [ ]
  });
}

function gestionarPanorama(){
    var idModal = 'modal_dialog_gestion_p';
    var botonModal = [{"id":"cerrar_gest","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var url = "Panorama_riesgos/getionarPanoramas";    
    var mensaje = "";
    var formData = "";
    
    callAjaxCallback(url,formData,function(tipo_respuesta,data){            
        crearModal(idModal, 'Gesti&oacute;n de panorama de riesgos',data["panoramaViewTable"], botonModal, false, 'modal-xl', '',true);
        
        validRangoFechas("fecha_inicial","fecha_final");
        aplicarDatatableGeneral("tabla_panorama");
        $("#consultar_panorama").on("click",gestionarPanoramaFechas);

    });
}

function gestionarPanoramaFechas(){
    
     formData = {};

     formData['fecha_inicial'] = $("#fecha_inicial").val();
     formData['fecha_final'] = $("#fecha_final").val();

     var url = "Panorama_riesgos/getTablaPanorama";
     var mensaje = "";

     var requeridos = [{"id":"fecha_inicial", "texto":"Fecha inicial"},
                       {"id":"fecha_final", "texto":"Fecha final"}                      
                      ];

    if(validRequired(requeridos)){

       callAjaxCallback(url,formData,function(tipo_respuesta,data){

          $("#contenedor_table_panorama").html(data["tabla"]);               
          aplicarDatatableGeneral("tabla_panorama");

       });

   }
}

function verpanorama(codigo,descripcion,responsable,atendido_por,correo_responsable,usuario_crea,estado_codigo,nombre_estado,ruta_file,nombre_file,file_codigo,codigo_predio,fecha_inspeccion,codigo_construccion){
    var url = 'Panorama_riesgos/getPanoramas';
    var formData = {};
    var idModal = 'modal_verpanorama';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    formData['codigo_predio'] = codigo_predio;
    formData['codigo_predio_const'] = codigo_construccion;
    formData['codigo_panorama'] = codigo;

    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        console.log('data TAREA', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
        }else{
            mensaje = data["panoramaView"];            
        }
        
        crearModal(idModal, 'Panorama de riesgos', mensaje, botonModal, true, 'modal-lg', '',true);
        
        $('#cerrar'+idModal).click(function(){
            $("#"+idModal).modal('hide');               
        });

        var aux_obj_data = '[{"ruta":"'+ruta_file+'","nombre":"'+nombre_file+'","cod_file":0}]';    
        var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
        aplicInputFile(true, 'file_panorama', 'Cargar imagen', aux_array_ext, aux_obj_data, false, 'Seleccionar imagen', '', true);
        
        $("#responsable_p").val(responsable); 
        $("#atendido_por_p").val(atendido_por);               
        $("#email_responsable").val(correo_responsable);        
        $("#descripcion_panorama").val(descripcion);        
        $("#estado_panorama").val(nombre_estado);
        $("#estado_panorama").attr("data-estado",estado_codigo);
        $("#fecha_inspeccion").val(fecha_inspeccion);

        $("#label_panorama_riesgos").text("Panorama de Riesgo  No. "+codigo);
        $("#id_panorama_riesgos").val(codigo);
    });  

}

function gestionarSeguimientoTarea(codTarea, codSeguimiento){
    var url = 'Panorama_riesgos/llamarSeguimientoTarea';
    var formData = {};
    var idModal = 'modal_gestionarSeguimientoTarea';
    var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
  
    formData['codTarea'] = typeof codTarea == 'undefined' ? '-1' : codTarea;
    formData['codSeguimiento'] = typeof codSeguimiento == 'undefined' ? '-1' : codSeguimiento;

    callAjaxCallbackFile(url, formData, function(tipo_respuesta, data){
        console.log('data TAREA', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
        }else{
            mensaje = data["frm_seguimiento"];
            global_tareas_panorama= '-1';
        }
        
        crearModal(idModal, 'Seguimiento tarea', mensaje, botonModal, true, 'modal-lg', '',true);
        
        $('#cerrar'+idModal).click(function(){
            $("#"+idModal).modal('hide');               
        });

        $('#aceptar'+idModal).click(function(){

         var requeridos = [{"id":"estado_sg", "texto":"Estado"},
                           {"id":"observacion_sg", "texto":"Observaci&oacute;n"}
                           //,{"id":"foto_sg", "texto":"Foto"}                                                  
                          ];

          if(validRequired(requeridos)){
              guardarSeguimientoTarea(codTarea, codSeguimiento);
          }        
        });

        aplicInputFile(true, 'foto_sg', 'Cargar imagen', aux_array_ext, '[]', false, 'Seleccionar imagen', '', true);      
    });
}

function guardarTareaPanorama(codPanorama, codTarea){
    var idModal =  'dialog_guardarTareaPanorama';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm reporte-key-css_1"}];
    var url = "Panorama_riesgos/guardarTareaPanorama";
    var formData = new FormData(document.getElementById("frm_tarea_panorama"));
    formData.append('codPanorama',codPanorama);
    formData.append('codTarea', codTarea);
    formData.append('codRiesgo', $('#puntaje_tr').attr('data-riesgo'));
    formData.append('puntaje_vl', $('#puntaje_tr').val());
    formData.append('estado_vl', $('#estado_tr').val());
    

    callAjaxCallbackFile(url, formData,function(tipo_respuesta, data){
        console.log('Respuesta guardar : ', data);
        var mensaje = '';
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){            
                $("#"+idModal).modal('hide');               
            });            
        }else{
            var mensaje = data["result"] != undefined ? data["result"] : 'Se guardo correctamente';
            var tablaTarea = data["tabla_tarea"] != undefined ? data["tabla_tarea"] : '';

            if(tablaTarea != ''){
                $('#contenedor_table_tarea').html(tablaTarea);
                aplicarDatatableGeneral("tablaTareas");
            }

            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
                $('#modal_gestionarTareasPanorama').modal('hide');
            });
        }
                
    });
}

function guardarSeguimientoTarea(codTarea, codSeguimiento){
    var idModal =  'dialog_guardarSeguimientoTarea';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm reporte-key-css_1"}];
    var url = "Panorama_riesgos/guardarSeguimientoTarea";
    var formData = new FormData(document.getElementById("frm_seguimiento_tarea"));
    formData.append('codTarea', codTarea);
    formData.append('codSeguimiento',codSeguimiento); 
    formData.append('codigos_delete',"[]");   

    callAjaxCallbackFile(url, formData,function(tipo_respuesta, data){
        console.log('Respuesta guardar : ', data);
        var mensaje = '';
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){            
                $("#"+idModal).modal('hide');               
            });            
        }else{
            //var mensaje = data["result"] != undefined ? JSON.stringify(data["result"]) : 'Se guardo correctamente';
            var mensaje = data["result"];
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $(".modal").modal('hide');               
            });
        }
                
    });
}

function fnCalcPuntaje(){
    var vProv = !isNaN(parseInt($('#probabilidad_tr').val())) ? parseInt($('#probabilidad_tr').val()) : 0;
    var vSeve = !isNaN(parseInt($('#severidad_tr').val())) ? parseInt($('#severidad_tr').val()) : 0;
    var vExpo = !isNaN(parseInt($('#exposicion_tr').val())) ? parseInt($('#exposicion_tr').val()) : 0;
    var vProt = !isNaN(parseInt($('#proteccion_tr').val())) ? parseInt($('#proteccion_tr').val()) : 1;
    var vPuntaje = (vProv * vSeve * vExpo) / vProt;
    vPuntaje = !isNaN(vPuntaje) && isFinite(vPuntaje) ? vPuntaje : 0;

    for(c=0; c<global_clasifica_tarea.length; c++){
        var objDato = global_clasifica_tarea[c];
        var vMenor = !isNaN(parseInt(objDato['valor_menor'])) ?  parseInt(objDato['valor_menor']) : 0;
        var vMayor = !isNaN(parseInt(objDato['valor_mayor'])) ?  parseInt(objDato['valor_mayor']) : 0;
        if((vPuntaje >= vMenor && vPuntaje < vMayor) || (c == global_clasifica_tarea.length - 1) ){
            $('#puntaje_tr').attr('data-riesgo', objDato['id_clasificacion']);
            $('#lbRiesgo_tr').html('<b>'+objDato['nombre_clasificacion']+'</b>');
            break;
        }
    }

    $('#puntaje_tr').val(vPuntaje);
}

