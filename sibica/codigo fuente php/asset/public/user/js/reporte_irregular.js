function reportarIrregular(codPoligono, typePoligono){
    var idModal =  'dialog_reportarIrregular';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cancelar","class":"btn-primary btn-sm close-modal-general"}];
    var url = "Reporte_irregular/traerReporteIrregular";
    var mensaje = "";
    var formData = {};
    formData['codPredio'] = codPoligono;
    callAjaxCallback(url, formData,function(tipo_respuesta, data){
        console.log('Respuesta : ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
        }else{
            
            var datosReporte = data["result"] != undefined ? data["result"] : {};
            var objMsjReporte = datosReporte['msj_reporte'] ? datosReporte['msj_reporte'] : [];
            //var msjReporte = '';
            pintarReporteIrregular(codPoligono, data, objMsjReporte);

            /*for(m=0; m<objMsjReporte.length; m++){
                var datoMsj = objMsjReporte[m];
                msjReporte += '<b>'+datoMsj['nombre']+'</b>';
                msjReporte += '<p>'+datoMsj['mensaje']+'</p>';
            }

            crearModal(idModal, 'Informaci&oacute;n', msjReporte, botonModal, true, 'modal-lg', '',true);
            $('#cerrar'+idModal).click(function(){
                $("#"+idModal).modal('hide');
                pintarReporteIrregular(codPoligono, data);                              
            });*/
        }
    });
}

function pintarReporteIrregular(codPoligono, datos, objMsjReporte){
    var idModal =  'dialog_pintarReporteIrregular';
    var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm reporte-key-css_1"},{"id":"cerrar"+idModal,"label":"Cancelar","class":"btn-primary btn-sm"}];
    var existeReporte = datos["result"]['existe_reporte'] != undefined ? datos["result"]['existe_reporte'] : 0;
    var contenedor = datos["frm"];
    var objDato = datos["result"] != undefined ? datos["result"] : {};
    var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];
    var aux_obj_data = '[{"ruta":"'+objDato['adjunto']+'","nombre":"Adjunto","cod_file":0}]';
    var tamanioModal = 'modal-lg';
    
    if(existeReporte > 0){
        botonModal = [{"id":"cerrar"+idModal,"label":"Cancelar","class":"btn-primary btn-sm"}];
        tamanioModal = 'modal-mg';
    }

    crearModal(idModal, 'Reporte irregularidad', contenedor, botonModal, true, tamanioModal, '',true,null,"reporte-key-css_3");
    aplicInputFile(true,'adjunto','Cargar imagen',aux_array_ext, aux_obj_data,false,'Seleccionar imagen','',true);

    $('#aceptar'+idModal).click(function(){
        var requeridos = [
                            {"id":"listaTipoReporte", "texto":"Tipo reporte"},
                            {"id":"correo", "texto":"Correo"}                                               
                          ];

        if(codPoligono == -1){
            requeridos.push({"id":"direccion", "texto":"Direcci&oacute;n"});
        }

        if(validRequired(requeridos)){
            guardarReporte(codPoligono);
        }
    });

    $('#cerrar'+idModal).click(function(){
        $("#"+idModal).modal('hide');
    });

    $('#listaTipoReporte').change(function(){
        var valorList = $(this).val();
        var objAux = {};
        for(m=0; m<objMsjReporte.length; m++){
            var datoMsj = objMsjReporte[m];
            if(datoMsj['id'] == valorList){
                pintarInfoTipoIrregular(datoMsj);
                break;
            }
        }
    });

    $('#chAcuerdo').change(function(){
        if($(this).is(':checked')){
            $('#aceptar'+idModal).removeAttr('disabled');
        }else{
            $('#aceptar'+idModal).attr('disabled','disabled');
        }
    });

    $('#aceptar'+idModal).attr('disabled','disabled');
    
}

function pintarInfoTipoIrregular(objDatoMsj){
    var idModal =  'dialog_pintarInfoTipoIrregular';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm"}];
    //var datosReporte = data["result"] != undefined ? data["result"] : {};
    //var objMsjReporte = datosReporte['msj_reporte'] ? datosReporte['msj_reporte'] : [];
    var msjReporte = '';

    msjReporte += '<b>'+objDatoMsj['nombre']+'</b>';
    msjReporte += '<p>'+objDatoMsj['mensaje']+'</p>';

    crearModal(idModal, 'Informaci&oacute;n', msjReporte, botonModal, true, 'modal-md', '',true);
    $('#cerrar'+idModal).click(function(){
        $("#"+idModal).modal('hide');
        //pintarReporteIrregular(codPoligono, data);                              
    });
}

function guardarReporte(codPoligono){
    var idModal =  'dialog_guardarReporte';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Aceptar","class":"btn-primary btn-sm reporte-key-css_1"}];
    var url = "Reporte_irregular/guardarReporteIrregular";
    var mensaje = "";
    //var formData = {};
    var formData = new FormData(document.getElementById("reporte_irregular"));
    var listTipoReporte = $('#listaTipoReporte').val();
    var listTipoReporteText = $('#listaTipoReporte OPTION[value="'+listTipoReporte+'"]').text();    
    formData.append('codPredio',codPoligono);
    formData.append('tipoReporteText', listTipoReporteText);    

    callAjaxCallbackFile(url, formData,function(tipo_respuesta, data){
        console.log('Respuesta guardar : ', data);
        var mensaje = '';
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){            
                $("#"+idModal).modal('hide');               
            });            
        }else{
            var mensaje = data["result"] != undefined ? data["result"] +' <br>No. Orfeo: <b>'+data['orfeo']+'</b>' : 'Se guardo correctamente';
            mensaje += '<br><br>Gracias por utilizar la herramienta SIBICA.'
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $(".modal").modal('hide');               
            });
        }                
    });
}

function verTerminosCondicionesIrregular(){
    var idModal =  'dialog_guardarReporte';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    var msj = '<div id="terminos">'
    +'    <center><h2>T&eacute;rminos y condiciones de la plataforma de participaci&oacute;n ciudadana: SIBICA</h2></center><br>'
    +'	Los datos recibidos en esta aplicaci&oacute;n, son utilizados &uacute;nicamente para acceder y ejecutar las funciones de la misma, y no son distribuidos a terceros. El usuario acepta las condiciones de uso de la aplicaci&oacute;n al momento de realizar el registro y de manera indefinida durante su ejecuci&oacute;n.<br><br>'
    +'	Acceso. Al momento de acceder a la aplicaci&oacute;n, el usuario acepta y reconoce las condiciones de uso.<br><br>'
    +'	Derechos de propiedad intelectual. Todos los derechos de propiedad intelectual e industrial est&aacute;n en cabeza de la Alcald&iacute;a de Santiago de Cali. Cualquier violaci&oacute;n directa o indirecta ser&aacute;n denunciadas y judicializadas a trav&eacute;s de las autoridades competentes.<br><br>'
    +'	Enlaces Externos. La aplicaci&oacute;n utiliza plugins de terceros por lo cual de el usuario debe aceptar los t&eacute;rminos, aceptar las restricciones y adherirse a las condiciones de uso que el propietario de dicho software o servicio establezca. Entre ellos se encuentran la herramienta GOOGLE MAPS ® de acuerdo a los t&eacute;rminos y condiciones señalados por GOOGLE para su uso por parte de los usuarios.<br><br>'
    +'	Uso. Para generar un reporte en la aplicaci&oacute;n, cada usuario debe ingresar obligatoriamente los siguientes datos:<br><br>'
    +'	Correo electr&oacute;nico<br>'
    +'	Obligaciones del registro. Cada usuario se compromete a proveer informaci&oacute;n verdadera, precisa, actualizada y completa sobre s&iacute; mismo y los registros de incidentes que realice con la cuenta. Si el usuario proporciona alguna informaci&oacute;n que sea falsa, inexacta, desactualizada o incompleta, o la Alcald&iacute;a de Cali tiene motivos razonables para sospechar que dicha informaci&oacute;n es falsa, inexacta, desactualizada o incompleta, la Alcald&iacute;a de Cali tiene el derecho de suspender o cancelar el registro y negarle el uso presente o futuro del servicio.<br><br>'
    +'	Descripci&oacute;n del servicio. La plataforma web de participaci&oacute;n ciudadana, permite al ciudadano reportar predios que est&aacute;n siendo usados irregularmente y est&aacute;n a cargo de la Alcald&iacute;a de Cali. Es un espacio brindado donde lo que se pretende es que las personas participen de forma interactiva en la construcci&oacute;n y fortalecimiento de la relaci&oacute;n entre los entes territoriales y la ciudadan&iacute;a al dar soluciones a los eventos que se reportan mediante la plataforma.<br><br>'
    +'	Responsabilidad. El uso y manejo de la presente aplicaci&oacute;n es total responsabilidad del uso y manejo que ejecuten los usuarios.<br><br>'
    +'	El usuario entiende que toda la informaci&oacute;n, datos, texto, fotograf&iacute;as, mensajes, u otros materiales ("Contenido"), que sean publicados, son responsabilidad exclusiva de la persona de la que se origin&oacute; dicho contenido. Esto significa que el usuario, y no la Alcald&iacute;a de Cali, es enteramente responsable por todo el contenido que suba o se transmita.<br><br>'
    +'	Reporte de eventos. El usuario podr&aacute; reportar eventos a trav&eacute;s de la aplicaci&oacute;n, diligenciando los siguientes campos: Tipo de reporte, fotograf&iacute;a, Direcci&oacute;n, n&uacute;mero predial, nombre, c&eacute;dula, correo electr&oacute;nico y tel&eacute;fono.<br><br>'
    +'	Uso indebido. Cualquier uso indebido que presente o vulnere leyes nacionales colombianas, ser&aacute; sancionado y judicializado por la autoridad competente. Los usuarios no deben usar la presente aplicaci&oacute;n para infringir la ley, las buenas costumbres o la moral p&uacute;blica.<br><br>'
    +'	Gratuidad del servicio. El uso de la aplicaci&oacute;n es completamente gratuito y no tendr&aacute; cobros parciales o totales por su uso y ejecuci&oacute;n. Queda completamente prohibido por parte del usuario o terceros, realizar cobros en dinero o especie por el uso de la aplicaci&oacute;n.<br><br>'
    +'	Leyes aplicables y jurisdicci&oacute;n. Para el servicio y ejecuci&oacute;n de la aplicaci&oacute;n se aplicar&aacute;n todas las leyes vigentes en Colombia.<br><br>'
    +'	Modificaci&oacute;n de contenidos. El usuario no podr&aacute; modificar total o parcialmente los contenidos de la aplicaci&oacute;n, incluyendo el c&oacute;digo, im&aacute;genes o alquier otro elemento de la misma.   ';
    +'</div>';

    crearModal(idModal, 'T&eacute;rminos y condiciones SIBICA', msj, botonModal, true, 'modal-lg', '',true);
}