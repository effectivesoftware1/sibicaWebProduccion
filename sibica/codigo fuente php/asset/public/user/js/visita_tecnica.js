var global_ovservacion_persona = [];

function verVisita(codigo_predio, cod_predio_const){
    runLoading(true); 

    var idModal = 'modal_dialog_save_modulo';
    var botonesModal = [{"id":"add_contrato","label":"Agregar contrato","class":"btn-primary btn-sm"},{"id":"add_observacion","label":"Agregar observaci&oacute;n","class":"btn-primary btn-sm"},{"id":"save_visita","label":"Guardar","class":"btn-primary btn-sm panorama-key-css_1"},{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary close-modal-general btn-sm"},{"id":"imp_formato","label":"Imprimir formato","class":"btn-primary btn-sm"}];
    var botonModal = [{"id":"cerrar_modal","label":"Cerrar","class":"btn-primary close-modal-general btn-sm"}];
    $.ajax({    
          url: "Visita_tecnica/getVisitaTecnica",
          type: "POST",  
          dataType: "json",                   
          cache: false, 
          data:  {codigo_predio:codigo_predio, codigo_predio_const:cod_predio_const,codigo_visita:-1},                        
          success:function(data){
            runLoading(false);                                    
             
              crearModal(idModal, 'Crear visita t&eacute;cnica', data["visitaTecView"], botonesModal, false, 'modal-lg', '',true, null, 'panorama-key-css');
                          
              var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
              aplicInputFile(true,'file_visita','Cargar foto',aux_array_ext,"[]",false,'Seleccionar imagen','',true);      
          
              $("#fecha_ini_vt").val(getTimestamp()); 

              $("#tipo_visita").on("change",validTipoVisita); 
              
              var codigo_visita = $("#id_visita_tec").val() == "" ? -1 : $("#id_visita_tec").val();            
              $("#save_visita").on("click",function(){
                 saveVisitaTecnica(0,"",codigo_visita,codigo_predio,cod_predio_const,'I');                
              });             

              $('#add_observacion').click(function(){
                gestionarObservacionVisita(codigo_visita, -1);
              });

              $("#add_observacion").prop("disabled",true);
              $("#add_contrato").prop("disabled",true);

              $("#add_contrato").click(function(){
                  if ($("#tipo_visita").val() == 5) {
                    verContratosVisita(codigo_visita);
                  }else{
                    crearModal('valid_visita', 'Confirmaci&oacute;n','Para agregar un contrato debe seleccionar el tipo de visita <b>Servicios publicos</b>', botonModal, false, '', '',true);
                  }
              });


              $("#imp_formato").prop("disabled",true);
              $("#imp_formato").click(function(){            
                donwloadPdf(codigo_visita);
              });              
              
          },
          error: function(result) {
            runLoading(false);
            crearModal(idModal, 'Confirmaci\u00f3n', 'Se presentaron problemas al traer los reguistros', botonModal, false, '', '');
            $("#cerrar_rol").click(function(){
                $("#modal_dialog_save_modulo").modal("hide");                       
            });

          }
       });    
    
}

function saveVisitaTecnica(codigo_file,file_anterior,codigo_visita,codigo_predio,cod_predio_const,accion){

    var idModal2 = 'modal_dialog_save_modulo1';
    var botonModal2 = [{"id":"cerrar_rol_1","label":"Cerrar","class":"btn-primary btn-sm"}];
    
    var requeridos = [{"id":"atendido_por_p", "texto":"Atendido por"},
                      {"id":"calidad_inmueble", "texto":"Calidad del inmueble"},
                      {"id":"objetivo_visita", "texto":"Objetivo visita"},
                      {"id":"tipo_visita", "texto":"Tipo visita"}                      
                      ];
    if ($("#div_contrato").is(":visible") && accion == "I") {
       requeridos.push({"id":"suscriptor", "texto":"Suscriptor"});
       requeridos.push({"id":"medidor", "texto":"Medidor"});
    }

    if ($("#div_contrato").is(":visible") && accion != "I") {
      if ($("#suscriptor").val() != "") {
          requeridos.push({"id":"medidor", "texto":"Medidor"});
      }
      if ($("#medidor").val() != "") {
          requeridos.push({"id":"suscriptor", "texto":"Suscriptor"});
      }       
       
    }

    if(validRequired(requeridos)){         

         runLoading(true);        

         var formData = new FormData(document.getElementById("form_visita_tecnica"));
          formData.append('codigo_file_visita',codigo_file);  
          formData.append('file_visita_ant',file_anterior);
          formData.append('codigo_visita',codigo_visita);
          formData.append('codigo_predio',codigo_predio);
          formData.append('cod_predio_const',cod_predio_const);                   

         $.ajax({    
                  url: "Visita_tecnica/guardarVisitaTec", 
                  type: "POST",  
                  dataType: "json",
                  data:formData,             
                  cache: false,
                  contentType: false,
                  processData: false,                
                  success:function(data){
                    runLoading(false);
                    console.log("data ", data);
                    crearModal(idModal2, 'Confirmaci\u00f3n',data["result"], botonModal2, false, '', '',true);
                    
                    $("#cerrar_rol_1").click(function(){
                        $("#"+idModal2).modal("hide");  
                        $("#modal_gestionarEditPanorama").modal("hide");                      
                    }); 

                    $("#save_visita").prop("disabled",true); 
                    $("#add_observacion").prop("disabled",false);
                    $("#add_contrato").prop("disabled",false);
                    $("#imp_formato").prop("disabled",false);                    

                    if ($("#tipo_visita").val() == 5) {
                      $("#div_contratos").show();
                      $("#contenedor_table_contratos").html(data["tablaContrato"]);
                      aplicarDatatableGeneral("tabla_contrato_vista","0,1,2,3","Contratos");
                    }else{
                      $("#div_contratos").hide();
                    }                                                

                    //$("#contenedor_table_panorama").html(data["tabla"]);
                    //aplicarDatatableGeneral("tabla_panorama");
                  },
                  error: function(result) {
                    runLoading(false);
                    crearModal(idModal2, 'Confirmaci\u00f3n', 'Se presentaron problemas al guardar el registro', botonModal2, false, '', '',true);
                    $("#cerrar_rol_1").click(function(){
                        $("#"+idModal2).modal("hide");                       
                    });

                  }
       });
    }

}

function validTipoVisita(){
   if ($("#tipo_visita").val() == 5  ) {
      $("#div_contrato").show();
   }else{
      $("#div_contrato").hide();
   }
}

function gestionarObservacionVisita(codVisita, codObservacion){
    var url = 'Visita_tecnica/llamarObservacionVisita';
    var formData = {};
    var idModal = 'modal_gestionarObservacionVisita';
    var botonModal = [{"id":"gregaPersona"+idModal,"label":"Agregar persona","class":"btn-primary btn-sm"},{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    var frmPersona = '';
    var aux_array_ext_img = ['jpg', 'png', 'gif','jpeg','ico'];
    var aux_array_ext_doc = ['*'];
    
    formData['codVisita'] = codVisita;
    formData['codObservacion'] = typeof codObservacion == 'undefined' || codObservacion == '' ? '-1' : codObservacion;

    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        console.log('data OBSERVACION', data);
        var aux_obj_data_file = '{}';
        
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            botonModal.splice(0,1);
        }else{
            var datos = data['result'][0];
            mensaje = data["frm_observacion"];
            frmPersona = data["frm_observacion_persona"];
            /*global_tareas_panorama= '-1';
            //global_clasifica_tarea = data["clasifica_tarea"];
            if(data["status"] > 0){
                botonModal.splice(0,1);
            }else{
                if(codTarea != '-1' && codTarea != undefined && codTarea != null){
                    botonModal.unshift({"id":"addSeguimiento"+idModal,"label":"Agregar seguimiento","class":"btn-primary btn-sm"});
                    aux_obj_data_file = '[{"ruta":"'+datos['patFile']+'","nombre":"'+datos['nameFile']+'","cod_file":0}]';
                }
            }*/
        }
        
        crearModal(idModal, 'Observaci&oacute;n visita tecnica', mensaje, botonModal, true, 'modal-lg', '',true);
        
        $('#cerrar'+idModal).click(function(){
            $("#"+idModal).modal('hide');               
        });

        $('#aceptar'+idModal).click(function(){
            var requeridos = [
                {"id":"observacion_ovt", "texto":"Observaci&oacute;n"}                               
            ];
            if(validRequired(requeridos)){                
                guardarObservacionVisita(codVisita, codObservacion);                
            }            
        });

        $('#gregaPersona'+idModal).click(function(){
            agregarPersonaVisita(frmPersona);
        });        

        aplicInputFile(true,'fileImg_ovt','Cargar imagen',aux_array_ext_img, aux_obj_data_file,false,'Seleccionar imagen','',true);
        aplicInputFile(true,'fileDoc_ovt','Cargar documento',aux_array_ext_doc, aux_obj_data_file,false,'Seleccionar documento','',true);
        
        $("#add_img_tr").on("click",crearTipoRiesgo);
    });
}

function guardarObservacionVisita(codVisita, codObservacion){
    var idModal =  'dialog_guardarObservacionVisita';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm reporte-key-css_1"}];
    var url = "Visita_tecnica/guardarObservacionVisita";
    var formData = new FormData(document.getElementById("frm_observacion_visita_tecnica"));
    formData.append('codVisita', codVisita);
    formData.append('codObservacion',codObservacion);
    formData.append('persona',JSON.stringify(global_ovservacion_persona));
    //formData.append('codigos_delete',"[]");   

    callAjaxCallbackFile(url, formData, function(tipo_respuesta, data){
        var mensaje = '';
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
            });            
        }else{
            //var mensaje = data["result"] != undefined ? JSON.stringify(data["result"]) : 'Se guardo correctamente';
            var mensaje = !isNaN(parseInt(data["result"])) ? 'Se creo correctamente el registro' : data["result"];
            $('#contenedor_table_vt').html(data["tablaObs"]);
            aplicarDatatableGeneral("tablaObservacionVisita","0,1,2,3","Observaciones");
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
                $("#modal_gestionarObservacionVisita").modal('hide');
            });
        }
    });
}


function verContratosVisita(codigo_visita){

    var idModal = 'modal_dialog_save_con_visit';
    var botonesModal = [{"id":"save_contrato","label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar_cv","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var formulario = $('<form id="form_contrato" name="form_contrato"><div class="container"><div class="row"><div class="col-sm-6"><label class="obligatorio">Medidor</label><input id="ipt_medidor" name="ipt_medidor" class="form-control campo-vd" /></div><div class="col-sm-6"><label class="obligatorio">Suscriptor</label><input id="ipt_suscriptor" name="ipt_suscriptor" class="form-control campo-vd" /></div></div></div></form>');

    crearModal(idModal, 'Crear contrato', formulario, botonesModal, false, '', '',true, null, 'panorama-key-css');
    
    $("#save_contrato").on("click",function(){
      saveContratoVisita(codigo_visita);                
    });     
}

function saveContratoVisita(codigo_visita){
     var requeridos = [
                       {"id":"ipt_medidor", "texto":"Medidor"},
                       {"id":"ipt_suscriptor", "texto":"Suscriptor"}
                      ];
    
    if(validRequired(requeridos)){     

        var url = 'Visita_tecnica/SaveContratosVisita';
        var formData = {};
        var idModal = 'modal_gestionarContratoVisita';
        var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
        //var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
        formData['codigo_visita'] = codigo_visita;
        formData['suscriptor'] = $("#ipt_suscriptor").val();
        formData['medidor'] = $("#ipt_medidor").val();

        callAjaxCallback(url, formData, function(tipo_respuesta, data){
            if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
                 $('#cerrar'+idModal).click(function(){
                    $("#"+idModal).modal('hide');               
                 });
            }else{
                $("#modal_dialog_save_con_visit").modal('hide');
                $("#div_contratos").show();
                $("#contenedor_table_contratos").html(data["tablaContratos"]);
                aplicarDatatableGeneral("tabla_contrato_vista","0,1,2,3","Contratos");
            }         
        });

  }
}

function agregarPersonaVisita(frmPersona){   
    var idModal = 'modal_agregarPersonaVisita';
    var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModal, 'Crear contrato', frmPersona, botonModal, false, '', '', true, null, 'visita-key-css');

    setTimeout(function(){
        $("#signature").jSignature();
    },2000);    

    $("#clearsignature").on("click",function(){
        $("#signature").jSignature("clear");
    });
    
    $('#aceptar'+idModal).click(function(){
        if(validRequired(getObjRequerid('frm_observacion_visita_persona', ''))){
            addGlobalPersonaVisita(idModal);
        }
    });
}

function addGlobalPersonaVisita(idModal){ 
    var validFirma =  $("#signature").jSignature("getData", "base30");
    if (validFirma[1] == "") {
       alertify.alert("Advertencia","Debe firmar el contrato");
       return false;
    }  
    var persona = {};
    var columns = getColumnTable('observacion_persona');
    var tabla = '';
    var existePersona = false;
    persona['documento_ovp'] = $('#documento_ovp').val();
    persona['nombre_ovp'] = $('#nombre_ovp').val();
    persona['cargo_ovp'] = $('#cargo_ovp').val();
    persona['correo_ovp'] = $('#correo_ovp').val();
    persona['quitar'] = '<div id="td_'+persona['documento_ovp']+'" style="text-align:center;"><img class="img-button" title="Quitar registro" src="./asset/public/img/delete.png" onclick="quitarPersona(\''+persona['documento_ovp']+'\');"></div>';
    persona['firma_ovp'] =  $("#signature").jSignature('getData','default');

    for(p=0; p<global_ovservacion_persona.length; p++){
        var gpersona = global_ovservacion_persona[p];
        if(gpersona['documento_ovp'] == persona['documento_ovp']){
            existePersona = true;
            break;
        }
    }

    if(!existePersona){
        global_ovservacion_persona.push(persona);
        tabla = createTable('tablaObservacionPersona', columns, global_ovservacion_persona);
        $('#div_tablaObservacionPersona').html(tabla);
        aplicarDatatableGeneral("tablaObservacionPersona","0,1,2","Personas");
        $('#'+idModal).modal('hide');
    }else{
        $('#msj_ovp').html('El numero de cedula ya se encuentra asociado');
        setTimeout(function(){
            $('#msj_ovp').html('');
        }, 3000);
    }
}

function quitarPersona(numDoc){
    var columns = getColumnTable('observacion_persona');
    var tabla = '';
    //$('#td_'+numDoc).parent().parent('tr').remove();
    for(p=0; p<global_ovservacion_persona.length; p++){
        var gpersona = global_ovservacion_persona[p];
        if(gpersona['documento_ovp'] == numDoc){
            global_ovservacion_persona.splice(p,1);
            break;
        }
    }

    tabla = createTable('tablaObservacionPersona', columns, global_ovservacion_persona);
    $('#div_tablaObservacionPersona').html(tabla);
    aplicarDatatableGeneral("tablaObservacionPersona","0,1,2","Personas");
}


function gestionarVisitas(){     

        var url = 'Visita_tecnica/getionarVisitasTecnicas';
        var formData = {};
        var idModal = 'modal_gestionarVisitas';
        var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
        
        callAjaxCallback(url, formData, function(tipo_respuesta, data){
            if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
                
            }else{                
               crearModal(idModal, 'Gesti&oacute;n de visitas t&eacute;cnicas', data["visitaViewTable"], botonModal, true, 'modal-xl', '',true);
            }           

           validRangoFechas("fecha_inicial","fecha_final");
           aplicarDatatableGeneral("tabla_visita","0,1,2,3,4,5","Visitas t&eacute;cnicas");
           $("#consultar_visita").on("click",gestionarVisitasFechas);
           $("#limpiar_visita").on("click",limpiarVisitas);           

        });
}

function limpiarVisitas(){

  $("#fecha_inicial").val("");
  $("#fecha_final").val("");
   gestionarVisitasFechas();

}

function gestionarVisitasFechas(){
    
     formData = {};

     formData['fecha_inicial'] = $("#fecha_inicial").val();
     formData['fecha_final'] = $("#fecha_final").val();

     var url = "Visita_tecnica/getTablaVisita";
     var mensaje = "";
     var requeridos = [];

     if ($("#fecha_inicial").val() != "") {
        requeridos.push({"id":"fecha_final", "texto":"Fecha final"});
     }

     if ($("#fecha_final").val() != "") {
        requeridos.push({"id":"fecha_inicial", "texto":"Fecha inicial"});
     }
    
    if(validRequired(requeridos)){

       callAjaxCallback(url,formData,function(tipo_respuesta,data){

          $("#contenedor_table_visita").html(data["tabla"]);               
          aplicarDatatableGeneral("tabla_visita","0,1,2,3,4,5","Visitas t&eacute;cnicas");

       });

   }
}

function verVisitaReadOnly(codigo_vista,codigo_terreno,predial_edificacion_const){
    var url = 'Visita_tecnica/getVisitaTecnica';
    var formData = {};
    var idModal = 'modal_verVisita';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    formData['codigo_predio'] = codigo_terreno;
    formData['codigo_predio_const'] = predial_edificacion_const;
    formData['codigo_visita'] = codigo_vista;

    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        console.log('data TAREA', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
        }else{
            mensaje = data["visitaTecView"];            
        }
        
        crearModal(idModal, 'Visita t&eacute;cnica', mensaje, botonModal, true, 'modal-lg', '',true);
        
        $('#cerrar'+idModal).click(function(){
            $("#"+idModal).modal('hide');               
        });
        var datosVisita = data["dataVisita"][0];
        var ruta_file = datosVisita["ruta_file"];
        var nombre_file = datosVisita["nombre_file"];
        var aux_obj_data = "[]";

        if (ruta_file != "" && ruta_file != null) {
            aux_obj_data = '[{"ruta":"'+ruta_file+'","nombre":"'+nombre_file+'","cod_file":0}]';
        }

        var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
        aplicInputFile(true, 'file_visita', 'Cargar imagen', aux_array_ext, aux_obj_data, false, 'Seleccionar imagen', '', true);
        $("#div_fecha_fin_vt").show(); 

        $("#atendido_por_p").val(datosVisita["atendido_por_vt"]);               
        $("#calidad_inmueble").val(datosVisita["calidad_inmueble_vt_fk"]);        
        $("#objetivo_visita").val(datosVisita["objetivo_vt"]);        
        $("#fecha_ini_vt").val(datosVisita["fecha_inicio_vt"]);
        $("#tipo_visita").val(datosVisita["tv_vt_fk"]);
        $("#fecha_inspeccion").val(datosVisita["fecha_inicio_vt"]);
        $("#fecha_fin_vt").val(datosVisita["fecha_fin_vt"]);

        $("#label_id_visita_tec").text("Visita t&eacute;cnica  No. "+codigo_vista);
        $("#id_visita_tec").val(codigo_vista);

        if (datosVisita["tv_vt_fk"] == 5) {
          $("#contenedor_table_contratos").html(data["tableContrato"]);
          $("#div_contratos").show();
          //$("#tabla_contrato_vista th").eq(4).hide();
          $("#tabla_contrato_vista").find(".btn_image").hide();
           aplicarDatatableGeneral("tabla_contrato_vista","0,1,2,3","Contratos");
        }
        
        $("#contenedor_table_vt").html(data["tableObservacion"]);       
        aplicarDatatableGeneral("tablaObservacionVisita","0,1,2,3","Observaciones"); 

        $("#imp_formato").click(function(){            
              donwloadPdf(codigo_visita);
        });      

    });  

}

function editarVisita(codigo_vista,codigo_terreno,predial_edificacion_const){

    var url = 'Visita_tecnica/getVisitaTecnica';
    var formData = {};
    var idModal = 'modal_verVisita';
    var botonesModal = [{"id":"add_contrato","label":"Agregar contrato","class":"btn-primary btn-sm"},{"id":"add_observacion","label":"Agregar observaci&oacute;n","class":"btn-primary btn-sm"},{"id":"save_visita","label":"Guardar","class":"btn-primary btn-sm panorama-key-css_1"},{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary close-modal-general btn-sm"},{"id":"imp_formato","label":"Imprimir formato","class":"btn-primary btn-sm"}];  
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    formData['codigo_predio'] = codigo_terreno;
    formData['codigo_predio_const'] = predial_edificacion_const;
    formData['codigo_visita'] = codigo_vista;

    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        console.log('data TAREA', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Advertencia', mensaje, botonModal, true, '', '',true);
        
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');               
            });

        }else{
            mensaje = data["visitaTecView"];   
            crearModal(idModal, 'Editar visita t&eacute;cnica', mensaje, botonesModal, true, 'modal-lg', '',true);
                 
        }
        
        var datosVisita = data["dataVisita"][0];
        var ruta_file = datosVisita["ruta_file"];
        var nombre_file = datosVisita["nombre_file"];

        var aux_obj_data = "[]";

        if (ruta_file != "" && ruta_file != null) {
            aux_obj_data = '[{"ruta":"'+ruta_file+'","nombre":"'+nombre_file+'","cod_file":0}]';
        }
        var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
        aplicInputFile(true, 'file_visita', 'Cargar imagen', aux_array_ext, aux_obj_data, false, 'Seleccionar imagen', '', true);
        $("#div_fecha_fin_vt").show(); 

        $("#atendido_por_p").val(datosVisita["atendido_por_vt"]);               
        $("#calidad_inmueble").val(datosVisita["calidad_inmueble_vt_fk"]);        
        $("#objetivo_visita").val(datosVisita["objetivo_vt"]);        
        $("#fecha_ini_vt").val(datosVisita["fecha_inicio_vt"]);
        $("#tipo_visita").val(datosVisita["tv_vt_fk"]);
        $("#fecha_inspeccion").val(datosVisita["fecha_inicio_vt"]);
        $("#fecha_fin_vt").val(datosVisita["fecha_fin_vt"]);

        $("#label_id_visita_tec").text("Visita t&eacute;cnica  No. "+codigo_vista);
        $("#id_visita_tec").val(codigo_vista);

        if (datosVisita["tv_vt_fk"] == 5) {
          $("#contenedor_table_contratos").html(data["tableContrato"]);
          $("#div_contratos").show();
           aplicarDatatableGeneral("tabla_contrato_vista","0,1,2,3","Contratos");
        }
        
        $("#contenedor_table_vt").html(data["tableObservacion"]);       
        aplicarDatatableGeneral("tablaObservacionVisita","0,1,2,3","Observaciones");  

        $("#tipo_visita").on("change",validTipoVisita); 
        $("#tipo_visita").trigger("change");
              
        var codigo_visita = $("#id_visita_tec").val() == "" ? -1 : $("#id_visita_tec").val();
        var codigo_file = data["file_vt_fk"] == null || data["file_vt_fk"] == "" ? 0 : data["file_vt_fk"];
        $("#save_visita").on("click",function(){
           saveVisitaTecnica(codigo_file,ruta_file,codigo_visita,codigo_terreno,predial_edificacion_const,"A");                
        });             

        $('#add_observacion').click(function(){
          gestionarObservacionVisita(codigo_visita, -1);
        });        

        $("#add_contrato").click(function(){
            if ($("#tipo_visita").val() == 5) {
              verContratosVisita(codigo_visita);
            }else{
              crearModal('valid_visita', 'Confirmaci&oacute;n','Para agregar un contrato debe seleccionar el tipo de visita <b>Servicios publicos</b>', botonModal, false, '', '',true);
            }
        });

        $("#imp_formato").click(function(){            
              donwloadPdf(codigo_visita);
        });
    });  

}

function eliminarContrato(codigo_contrato,codigo_visita){
       
        var url = 'Visita_tecnica/eliminarContrato';
        var formData = {};
        var idModal = 'modal_deleteContrato';
        var botonesModal = [{"id":"save"+idModal,"label":"SI","class":"btn-primary btn-sm"},{"id":"cerrar"+idModal,"label":"NO","class":"btn-primary btn-sm close-modal-general"}];
        var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
       
        crearModal(idModal, 'Eliminar contrato','¿Est&aacute; seguro de eliminar este contrato?', botonesModal, true, '', '',true);

        $("#save"+idModal).on("click",function(){

          formData["codigo_contrato"] = codigo_contrato;
          formData["codigo_visita"] = codigo_visita;

          callAjaxCallback(url, formData, function(tipo_respuesta, data){           

              if (tipo_respuesta == 0) {
                  mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
                  crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
                  
              }else{                
                 $("#contenedor_table_contratos").html(data["tableContrato"]);
                 $("#div_contratos").show();
                 aplicarDatatableGeneral("tabla_contrato_vista","0,1,2,3","Contratos");
                 $("#modal_deleteContrato").modal("hide");
              }               

          });

      });


}

function donwloadExcel(){

    var idModal = 'modal_dialog_save_rol';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm"}];

    var formData = {};
    formData["codigo_visita"] = 18

    var url = "Visita_tecnica/editExcel"
    var mensaje = "";
    callAjaxCallback(url,formData,function(tipo_respuesta,data){
        console.log('Datos rol: ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        }else{               
            console.log("creo excel");
        }

    });
}

function donwloadPdf(codigo_visita){
    $("#codigo_visita_pdf").val(codigo_visita);
    $("#form_excel").submit();
}





