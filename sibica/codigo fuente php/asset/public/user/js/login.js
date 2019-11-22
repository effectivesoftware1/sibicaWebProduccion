 $(document).ready(function() {
 	 $("body").keypress(function(event){    
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
        $("#btn_iniciar_session").trigger('click');         
      }
    });  

 });

 function usuarios(){

    var idModalRol = 'modal_dialog';
    var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general btn-sm"}];

    crearModal(idModalRol, 'Usuarios',g_usuario_table_view, botonModal, false, 'modal-xl', '',true,null,'usuarios-key-css');
    
    aplicarDatatableGeneral("tabla_usuario","0,1,2,3,4","Usuarios");
    $("#btn_agregarAdd").on("click",registrarse);
    
}

 function registrarse(){

	 	var idModal = 'modal_dialog_cambio';
		var botonesModal = [{"id":"saveMd","label":"Guardar","class":"btn-primary btn-sm class_save mr-2 btn_clave btn-sm usuarios-key-css_1"},{"id":"cancelarMd","label":"Cancelar","class":"btn-primary btn-sm btn-sm"}];
		
    crearModal(idModal,"Registrar usuario", g_registro_view, botonesModal, false, 'modal-lg', '',true,null,'usuarios-key-css');
		
		$('#cancelarMd').click(function(){
			$('#'+idModal).modal('hide');
		});

		$("#clave").PassRequirements();
    $("#clave_2").PassRequirements();

     $("#dependencia").selectpicker({         
        liveSearch: true,       
        dropupAuto: false,
        width: "100%"
     });

     $("#nombre1,#nombre2,#apellido1,#apellido2").on("keypress",function(){
            return validar_solo_letras(event);
     });

		setTimeout(function(){		
			$("#clave").val("");
      $("#clave_2").val("");	
      $("#email").val("");    	
		}, 1000);	

    	

		$('#saveMd').click(function(){

			var camposRequeridos = [			               
                                //{"id":"identificacion", "texto":"Identificaci&oacute;n"},
                                {"id":"nombre1", "texto":"Primer nombre"},
                                {"id":"apellido1", "texto":"Primer apellido"},
                                {"id":"rol", "texto":"Rol"},
                                {"id":"dependencia", "texto":"Dependencia"}, 
                                {"id":"email", "texto":"Email"},                     
                                {"id":"clave", "texto":"Usuario"},
                                {"id":"estado", "texto":"Estado"}
                              ];

       if(validRequired(camposRequeridos)){

         	 var validaClave   = $("#clave").attr('validaPassword');
           var validaClave2   = $("#clave_2").attr('validaPassword');

	         if (validaClave == 0){
	            $("#clave").focus();
	            return false; 
	         } 

           if (validaClave2 == 0){
              $("#clave_2").focus();
              return false; 
           } 

           if ($("#clave").val() != $("#clave_2").val()) {
              $("#clave").focus();
                 alertify.notify('Las claves ingresadas no coinciden', 'error', 3,null);
                return false;

           }

         	 if ($("#email").val()!="") {  
		         if (validarEmail($("#email").val()) == -1) {
		         	 $("#email").focus();
		             alertify.notify('Email incorrecto', 'error', 3,null);
		            return false;
	           }
			     }          

          var url = "Login/guardarUsuario";
          var formData = $("#form_usuario").serializeArray();           
          formData.push({ name: "codigo_usuario", value: 0});
          formData.push({ name: "email_anterior", value: ""});           
          
          var mensaje = "";
          var idModal = 'modal_dialog_save';
          var botonModal = [{"id":"cerrar","label":"Cerrar","class":"btn-primary btn-sm"}];
           
           callAjaxCallback(url,formData,function(tipo_respuesta, data){            
              if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
              }else{
                mensaje = data["result"];
              }
              crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, false, '', '',true);
              
              $("#contenedor_table_usuario").html(data["tabla"]);
              aplicarDatatableGeneral("tabla_usuario","0,1,2,3,4","Usuarios");

              $('#cerrar').click(function(){                
                  $("#"+idModal).modal('hide');
                  $("#modal_dialog_cambio").modal('hide');                                 
              });
    
            });

        }
     });
  }

 function editarReigistro(codigo,identificacion,nombre1,nombre2,apellido1,apellido2,correo,estado,rol,dependencia){

    var idModal = 'modal_dialog_cambio';
    var botonesModal = [{"id":"saveMd","label":"Guardar","class":"btn-primary btn-sm class_save mr-2 btn_clave btn-sm usuarios-key-css_2"},{"id":"cancelarMd","label":"Cancelar","class":"btn-primary btn-sm btn-sm"}];
    
    crearModal(idModal,"Editar usuario", g_registro_view, botonesModal, true, 'modal-lg', '',true,null,'usuarios-key-css');
    
    $('#cancelarMd').click(function(){
      $('#'+idModal).modal('hide');
    });

    $("#clave").PassRequirements();
    $("#clave_2").PassRequirements();

     $("#dependencia").selectpicker({         
        liveSearch: true,       
        dropupAuto: false,
        width: "100%"
     }); 

     $("#nombre1,#nombre2,#apellido1,#apellido2").on("keypress",function(){
            return validar_solo_letras(event);
     });     

    setTimeout(function(){    
      $("#clave").val("");
      $("#clave_2").val("");
      $("#email").val(correo);
    }, 1000);  

    //$("#identificacion").val(identificacion);
    $("#nombre1").val(nombre1);
    $("#nombre2").val(nombre2);
    $("#apellido1").val(apellido1); 
    $("#apellido2").val(apellido2); 
    $("#dependencia").selectpicker("val",dependencia);
    $("#email").val(correo);    
    $("#estado").val(estado);
    $("#rol").val(rol);     
    $("#clave").prev().removeClass("obligatorio");
    $("#clave_2").prev().removeClass("obligatorio")   


    $('#saveMd').click(function(){

      var camposRequeridos = [                     
                                //{"id":"identificacion", "texto":"Identificaci&oacute;n"},
                                {"id":"nombre1", "texto":"Primer nombre"},
                                {"id":"apellido1", "texto":"Primer apellido"},
                                {"id":"rol", "texto":"Rol"},
                                {"id":"dependencia", "texto":"Dependencia"}, 
                                {"id":"email", "texto":"Email"},
                                {"id":"estado", "texto":"Estado"}
                              ];

       if(validRequired(camposRequeridos)){

          if ($("#clave").val() != "") {
             var validaClave   = $("#clave").attr('validaPassword');

             if (validaClave == 0){
                $("#clave").focus();
                return false; 
             } 
          }

          if ($("#clave_2").val() != "") {
             var validaClave2   = $("#clave_2").attr('validaPassword');

             if (validaClave2 == 0){
                $("#clave_2").focus();
                return false; 
             } 
          }

          if ($("#clave").val() != $("#clave_2").val()) {
              $("#clave").focus();
                 alertify.notify('Las claves ingresadas no coinciden', 'error', 3,null);
                return false;

           }

           if ($("#email").val()!="") {  
             if (validarEmail($("#email").val()) == -1) {
               $("#email").focus();
                 alertify.notify('Email incorrecto', 'error', 3,null);
                return false;
             }
           }          

          var url = "Login/guardarUsuario";
          var formData = $("#form_usuario").serializeArray();           
          formData.push({ name: "codigo_usuario", value: codigo});
          formData.push({ name: "email_anterior", value: correo});   
          
          var mensaje = "";
          var idModal = 'modal_dialog_save';
          var botonModal = [{"id":"cerrar","label":"Cerrar","class":"btn-primary btn-sm"}];
           
           callAjaxCallback(url,formData,function(tipo_respuesta, data){            
              if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";
              }else{
                mensaje = data["result"];
              }
              crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
              
              $("#contenedor_table_usuario").html(data["tabla"]);
              aplicarDatatableGeneral("tabla_usuario","0,1,2,3,4","Usuarios");

              $('#cerrar').click(function(){                
                  $("#"+idModal).modal('hide');
                  $("#modal_dialog_cambio").modal('hide');                                 
              });
    
            });

        }
     });
  }
 
function inicioSession(){

    var idModal = 'modalConfirmar';     
    var botonesModal = [{
                        "id": "cerrarMd"+idModal,
                        "label": "Cerrar",
                        "class": "btn-primary btn-sm btn-sm"
                        }];    

    crearModal(idModal, 'Inicio sesi&oacute;n', g_inicioSesion_view, botonesModal, false, '', '',true);
    
    setTimeout(function(){
       $("#email").val("");
       $("#clave").val("");         
    },1000);     

    $("#btn_iniciar_session").on("click",function(){
          var camposRequeridos = [  
                            {"id":"email", "texto":"Email"},
                            {"id":"clave", "texto":"Contrase\u00f1a"}                      
                          ];
          if(validRequired(camposRequeridos)){

               /*if ($("#email").val()!="") {  
                   if (validarEmail($("#email").val()) == -1) {
                     $("#email").focus();
                       alertify.notify('Email incorrecto', 'error', 3,null);
                      return false;
                   }
                }*/   
                
                var url = "Login/loguear";
                var mensaje = "";
                var idModal = 'modal_dialog_save';
                var botonModal = [{"id":"cerrar","label":"Cerrar","class":"btn-primary btn-sm"}];
                var formData = $("#form_inicio_session").serialize();

           callAjaxCallback(url,formData,function(tipo_respuesta, data){

              console.log("tipo_respuesta ", tipo_respuesta);
              console.log("data ", data);
                       
              if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se pudo completar por que ocurrio un error el la base de datos.";

              }else if (tipo_respuesta == 1 && data["respuesta"] != 'OK'){
                mensaje = data["respuesta"];
              }else if (tipo_respuesta == 1 && data["respuesta"] == 'OK'){
                 location.href = "Home";
                 return false;   
              }

              crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
              
              $('#cerrar').click(function(){                
                  $("#"+idModal).modal('hide');                                                   
              });    
            });                  
          }

    });

    $('#cerrarMd'+idModal).click(function(){
         location.href = 'Home';
    });
 }

