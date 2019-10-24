function reportarIrregular(codPoligono, typePoligono){
    var url = "Reporte_irregular/traerReporteIrregular";
    var mensaje = "";
    var formData = {};
    formData['codPredio'] = codPoligono;
    callAjaxCallback(url, formData,function(tipo_respuesta, data){
        console.log('Respuesta : ', data);
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            crearModal(idModal, 'Reportar Irregularidad', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');               
            });
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

    if(existeReporte > 0){
        botonModal = [{"id":"cerrar"+idModal,"label":"Cancelar","class":"btn-primary btn-sm"}];
    }

    crearModal(idModal, 'Reporte irregularidad', contenedor, botonModal, true, 'modal-lg', '',true,null,"reporte-key-css_3");

    $('#aceptar'+idModal).click(function(){
        guardarReporte(codPoligono);
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
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){            
                $("#"+idModal).modal('hide');               
            });            
        }else{
            var mensaje = data["result"] != undefined ? data["result"] : 'Se guardo correctamente';
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            $('#cerrar'+idModal).click(function(){
                $(".modal").modal('hide');               
            });
        }
                
    });
}