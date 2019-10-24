function tablas(){

    var idModalRol = 'modal_dialog_rol';
    var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];
    var aux_tablas = [];
    crearModal(idModalRol, 'Tablas',g_tablas_view, botonModal, false, 'modal-lg', '',true);
    
    aplicarDatatableGeneral("tabla_tabla");
    $("#btn_agregarAdd").on("click",saveTabla);

    $("#lista_tabla").selectpicker({         
        liveSearch: true,
        width: "100%",       
        actionsBox:true
    }); 

    var arrayData = [];

    for (fila in g_regTablas){
       arrayData.push(g_regTablas[fila]["tablename"]);
    } 

    $("#lista_tabla").selectpicker("val",arrayData);
    
}

function saveTabla(){

    var idModal = 'modal_dialog_save_modulo';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    
    var requeridos = [{"id":"lista_tabla", "texto":"Tabla"}];
    if(validRequired(requeridos)){

         var datos = $("#lista_tabla").selectpicker("val").toString(); 

         formData = {"datos":datos};

         var url = "Tabla/saveTablas";
         var mensaje = "";
         callAjaxCallback(url,formData,function(tipo_respuesta,data){
            if (tipo_respuesta == 0) {
              mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
            }else{
              mensaje = data["result"];
            }           
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, false, '', '',true);
            
            $("#contenedor_table_tabla").html(data["tabla"]);
            aplicarDatatableGeneral("tabla_tabla");
  
          });
    }

}




