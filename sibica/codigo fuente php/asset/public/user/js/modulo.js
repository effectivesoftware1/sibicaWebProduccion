function modulos(){

    var idModalRol = 'modal_dialog_rol';
    var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModalRol, 'Modulos',g_modulo_table_view, botonModal, false, 'modal-xl', '',true);
    
    aplicarDatatableGeneral("tabla_modulo","0,1");
    $("#btn_agregarAdd").on("click",addMdodulo);
    
}

function addMdodulo(){

    var idModalRol = 'modal_dialog_addrol';
    var botonesModal = [{"id":"saveMdadd","label":"Guardar","class":"btn-primary btn-sm"},{"id":"cancelarMdadd","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModalRol, 'Agregar modulo',g_modulo_view, botonesModal, false, 'modal-lg', '',true);

    $("#saveMdadd").on("click",function(){
        saveModulo(0,'guardarDatos');
    });
}

function saveModulo(codigo_modulo,metodo){

    var idModal = 'modal_dialog_save_modulo';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm"}];
    
    var requeridos = [{"id":"nom_modulo", "texto":"Nombre"}];
    if(validRequired(requeridos)){

         var formData = $("#form_modulo").serializeArray();           
         formData.push({ name: "codigo_modulo", value: codigo_modulo});        

         var url = "Modulo/"+metodo;
         var mensaje = "";
         callAjaxCallback(url,formData,function(tipo_respuesta,data){
            if (tipo_respuesta == 0) {
              mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            }else{
              mensaje = data["result"];
            }           
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            
            $("#contenedor_table_modulo").html(data["tabla"]);
            aplicarDatatableGeneral("tabla_modulo","0,1");

            $('#cerrar_rol').click(function(){                
                $("#"+idModal).modal('hide');
                $("#modal_dialog_editrol").modal('hide');
                $("#modal_dialog_addrol").modal('hide');                
            });
  
          });
    }

}

function editModulo(codigo,nombre,desripcion){

    var idModalRol = 'modal_dialog_editrol';
    var botonesModal = [{"id":"saveMdedit","label":"Guardar","class":"btn-primary btn-sm"},{"id":"cancelarMdedit","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModalRol, 'Editar modulo',g_modulo_view, botonesModal, false, 'modal-lg', '',true);

    $("#nom_modulo").val(nombre);
    $("#des_modulo").val(desripcion);      
   
    $("#saveMdedit").on("click",function(){
        saveModulo(codigo,'editarDatos');
    });
    
}

function eliminarReigistro(codigo,nombre){
    var idModal = 'modal_dialog_eliminar';
    var botonesModal = [{"id":"eliminarMd","label":"Eliminar","class":"btn-primary btn-sm"},{"id":"cancelarMd","label":"Cancelar","class":"btn-primary btn-sm"}];
    var formulario = '¿Esta seguro de eliminar el registro <b>'+ nombre +'</b>?';
    
    crearModal(idModal, 'Eliminar modulo', formulario, botonesModal, true, '', '',true);
        
    $('#cancelarMd').click(function(){
        $('#'+idModal).modal('hide');
    });
    
    $('#eliminarMd').click(function(){
        quitarRegistro(codigo);
    });
}

function quitarRegistro(cod_modulo){   
    var idModal = 'modalConfirmar';
    var botonModal = [{"id":"cerrarMd","label":"Aceptar","class":"btn-primary btn-sm"}]; 

     var url = "Modulo/deteteDatos";
     var mensaje = "";
     var formData = {"cod_modulo":cod_modulo};

     callAjaxCallback(url,formData,function(tipo_respuesta,data){
        if (tipo_respuesta == 0) {
          mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
        }else{
          mensaje = data["result"];
        }           
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
        
        $("#contenedor_table_modulo").html(data["tabla"]);
        aplicarDatatableGeneral("tabla_modulo","0,1");

        $('#cerrarMd').click(function(){                
            $("#"+idModal).modal('hide');
            $("#modal_dialog_eliminar").modal('hide');                         
        });

      });
}



