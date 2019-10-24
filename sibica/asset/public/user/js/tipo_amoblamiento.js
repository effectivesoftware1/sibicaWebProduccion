function verTipoAmoblamiento(){

    var idModalRol = 'modal_dialog_rol';
    var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];
    var aux_tablas = [];
    crearModal(idModalRol, 'Tipo amoblamiento',g_ta_table_view, botonModal, false, 'modal-lg', '',true,null,'tipo-amobl-key-css_3');
    
    aplicarDatatableGeneral("tabla_ta");
    $("#btn_agregarAdd").on("click",formSaveTa);      
    
}

function formSaveTa(){

    var idModalRol = 'modal_dialog_ta';
    var botonModal = [{"id":"aceptarMdta","label":"Guardar","class":"btn-primary btn-sm tipo-amobl-key-css_1"},{"id":"cancelarMdta","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];
   
    crearModal(idModalRol, 'Tipo amoblamiento',g_ta_view, botonModal, false, 'modal-lg', '',true,null,'tipo-amobl-key-css_3');
   
    var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
    aplicInputFile(true,'file_ta','Imagen',aux_array_ext,"[]",false,'Seleccionar imagen','',true);      
    
    $("#aceptarMdta").on("click",function(){
        saveTa(0,"",-1);
    });
}

function saveTa(codigo_file,file_anterior,codigo){

    var idModal = 'modal_dialog_save_modulo';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm"}];
    
    var requeridos = [{"id":"nom_ta", "texto":"Nombre"},
                      {"id":"estado_ta", "texto":"Estado"}];    

    if(validRequired(requeridos)){

         runLoading(true);

         var formData = new FormData(document.getElementById("form_ta"));
          formData.append('codigo_file_ta',codigo_file);  
          formData.append('file_ta_ant',file_anterior);
          formData.append('codigo',codigo);
      
         var mensaje = "";

         $.ajax({    
                  url: "Tipo_amoblamiento/guardarDatos", 
                  type: "POST",  
                  dataType: "json",
                  data:formData,             
                  cache: false,
                  contentType: false,
                  processData: false,                
                  success:function(data){
                    runLoading(false);                              
                     
                    crearModal(idModal, 'Confirmarci\u00f3n', data["result"], botonModal, false, '', '',true);
                    $("#cerrar_rol").click(function(){
                        $("#modal_dialog_save_modulo").modal("hide");
                        $("#modal_dialog_ta").modal("hide");
                    });
                    $("#contenedor_table_ta").html(data["tabla"]);
                    aplicarDatatableGeneral("tabla_ta");  
                                                           
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

}

function editarTa(codigo,nombre,estado_codigo,estado_nombre,file_codigo,ruta_file,nombre_file){
    var idModalRol = 'modal_dialog_ta';
    var botonModal = [{"id":"aceptarMdta","label":"Guardar","class":"btn-primary btn-sm tipo-amobl-key-css_2"},{"id":"cancelarMdta","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];
    var aux_obj_data = '[{"ruta":"'+ruta_file+'","nombre":"'+nombre_file+'","cod_file":0}]';
        
    crearModal(idModalRol, 'Tipo amoblamiento',g_ta_view, botonModal, false, 'modal-lg', '',true,null,'tipo-amobl-key-css_3');
   
    var aux_array_ext = ['jpg', 'png', 'gif','jpeg','ico'];       
    aplicInputFile(true,'file_ta','Imagen',aux_array_ext,aux_obj_data,false,'Seleccionar imagen','',true);      
    
    $("#nom_ta").val(nombre);

    $("#aceptarMdta").on("click",function(){
        saveTa(file_codigo,ruta_file,codigo);
    });
}

