function campo(){

    var idModalRol = 'modal_dialog_rol';
    var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];
    var aux_tablas = [];
    crearModal(idModalRol, 'Campos',g_campos_view, botonModal, false, 'modal-lg', '',true);
    
    aplicarDatatableGeneral("tabla_campo","0,1");
    $("#btn_agregarAdd").on("click",saveCampo);

    $("#lista_tabla").html(crearListaTablas());

    $("#lista_tabla").selectpicker({         
        liveSearch: true,
        width: "100%"
    }); 

    $("#lista_campo").selectpicker({         
        liveSearch: true,
        width: "100%"
    }); 

    $("#lista_tabla").on("change",getCampos);  
    
}

function crearListaTablas(){
  
        var cadenaLista = '';
        for (fila in g_regTablas){
            var dato = g_regTablas[fila];
            var nombre = dato['tablename'];
            cadenaLista += '<option  value="'+nombre+'" >'+nombre+'</option>';
        }       

        return cadenaLista;
    
}

function getCampos(){

     var tabla = $("#lista_tabla").selectpicker("val");

     formData = {"tabla":tabla};

     var url = "Campo/getCampos";
     var mensaje = "";
     var options = "";
     var idModal = 'modal_confirmar_campo';
     var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];
     var campos = "";

     callAjaxCallback(url,formData,function(tipo_respuesta,data){
        if (tipo_respuesta == 0) {
          mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
          crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, false, '', '',true);
        }else{
          options = data["result"];
          campos = data["campos"];
          $("#lista_campo").selectpicker("destroy");
          $("#lista_campo").html(options);

          var arrayData = [];

          for (fila in campos){
             arrayData.push(campos[fila]["nombre_campo"]);
          }           
          $("#lista_campo").selectpicker({         
            liveSearch: true,
            width: "100%"
          });

           $("#lista_campo").selectpicker("val",arrayData);
        }

      });
}

function saveCampo(){

    var idModal = 'modal_dialog_save_modulo';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];
    
    var requeridos = [{"id":"lista_tabla", "texto":"Tabla"},
                      {"id":"lista_campo", "texto":"Campo"}];

    if(validRequired(requeridos)){

         var campos = $("#lista_campo").selectpicker("val").toString();
         var tabla = $("#lista_tabla").selectpicker("val");  

         formData = {"campos":campos,"tabla":tabla};

         var url = "Campo/saveCampos";
         var mensaje = "";
         callAjaxCallback(url,formData,function(tipo_respuesta,data){
            if (tipo_respuesta == 0) {
              mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
            }else{
              mensaje = data["result"];
            }           
            crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, false, '', '',true);
            
            $("#contenedor_table_campo").html(data["tabla"]);
            aplicarDatatableGeneral("tabla_campo","0,1");  
            });
    }

}

