var global_permisos_rol = {"rol":"-1", "permisos":{}};

function roles(){

    var idModalRol = 'modal_dialog_rol';
    var botonModal = [{"id":"cancelarMdget","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModalRol, 'Roles',g_rol_table_view, botonModal, false, 'modal-xl', '',true, null, 'roles-key-css');
    
    aplicarDatatableGeneral("tabla_rol");
    $("#btn_agregarAdd").on("click",addRoles);
    
}

function addRoles(){

    var idModalRol = 'modal_dialog_addrol';
    var botonesModal = [{"id":"saveMdadd","label":"Guardar","class":"btn-primary btn-sm roles-key-css_1"},{"id":"cancelarMdadd","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModalRol, 'Agregar rol',g_rol_view, botonesModal, false, 'modal-lg', '',true, null, 'roles-key-css');
    permisosRol('-1', '');

    $("#saveMdadd").on("click",function(){
        saveRol(0,'guardarDatos');
    });
}

function saveRol(codigo_rol,metodo){

    var idModal = 'modal_dialog_save_rol';
    var botonModal = [{"id":"cerrar_rol","label":"Cerrar","class":"btn-primary btn-sm"}];
    
    var requeridos = [{"id":"nom_rol", "texto":"Nombre"}];
    if(validRequired(requeridos)){

        var formData = $("#form_rol").serializeArray();           
        formData.push({ name: "codigo_rol", value: codigo_rol});        

        var url = "Rol/"+metodo;
        var mensaje = "";
        callAjaxCallback(url,formData,function(tipo_respuesta,data){
            console.log('Datos rol: ', data);
            if (tipo_respuesta == 0) {
                mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
                crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
            }else{
                var codRol = parseInt(data["result"]) ? data["result"] : '-1';
                mensaje = codRol != '-1' ? 'Operaci&oacute;n realizada correctamente.' : data["result"];
                if(codRol != '-1'){
                    fn_guardarPermisosRol(codRol);
                }else{
                    console.log('COD ROL2: ',codRol);
                    crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, true, '', '',true);
                }
                
                $("#contenedor_table_rol").html(data["tabla"]);
                aplicarDatatableGeneral("tabla_rol");
            }
            
            $('#cerrar_rol').click(function(){
                $("#"+idModal).modal('hide');
                $("#modal_dialog_editrol").modal('hide');
                $("#modal_dialog_addrol").modal('hide');                
            });

        });
    }
}

function editRol(codigo,nombre,desripcion,estado){
    var idModalRol = 'modal_dialog_editrol';
    var botonesModal = [{"id":"saveMdedit","label":"Guardar","class":"btn-primary btn-sm roles-key-css_2"},{"id":"cancelarMdedit","label":"Cerrar","class":"btn-primary btn-sm close-modal-general"}];

    crearModal(idModalRol, 'Editar rol',g_rol_view, botonesModal, false, 'modal-lg', '',true, null, 'roles-key-css');

    $("#nom_rol").val(nombre);
    $("#des_rol").val(desripcion);
    $("#estado_rol").val(estado);   
   
    $("#saveMdedit").on("click",function(){
        saveRol(codigo,'editarDatos');
    });
    
}


function permisosRol(codigo, nombre, desripcion, estado){
    var url = 'Rol/traerPermisosRol';
    var formData = {};
    var idModal = 'modal_permisosRol';
    var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm roles-key-css_1"},{"id":"cancelar"+idModal,"label":"Cancelar","class":"btn-primary btn-sm close-modal-general"}];
    var pAcordeonRol = $('<div id="pAcordeonRol"></div>');
    var pModulos = $('<div id="pModulos"></div>');
    var pCampos = $('<div id="pCampos"></div>');
    formData['cod_rol'] = codigo;
    pAcordeonRol.html('<h3>Permisos modulos</h3>');
    pAcordeonRol.append(pModulos);
    pAcordeonRol.append('<h3>Permisos campos</h3>');
    pAcordeonRol.append(pCampos);
    
    callAjaxCallback(url, formData, function(tipo_respuesta, data){
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la base de datos.";
            botonModal.splice(0, 1);
        }else{
            pModulos.html(data["tabla"]);
            mensaje = pAcordeonRol;
            global_permisos_rol['rol'] = codigo;
            global_permisos_rol['permisos'] = data["objDatos"];
        }

        if(codigo == '-1' && tipo_respuesta != 0){
            $('#permisosRolNuevo').html(mensaje);
            aplicarDatatableGeneral("tabla_rol_permisos");
        }else{
            crearModal(idModal, 'Permisos rol - '+nombre, mensaje, botonModal, false, 'modal-lg', '',true, null, 'roles-key-css');    
            //$("#contenedor_table_rol").html(data["tabla"]);
            aplicarDatatableGeneral("tabla_rol_permisos");

            $('#aceptar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');
                fn_guardarPermisosRol(codigo);
            });

            $('#cancelar'+idModal).click(function(){                
                $("#"+idModal).modal('hide');               
            });

            //$('#pAcordeonRol').accordion();
        }
        

    });
    
}

function fn_permisoModulo(idCh, codRol, codModulo, permiso){
    var tipoPermiso = ['insertar','editar','consultar','eliminar'];
    var valorCampo = $('#'+idCh).is(':checked') ? '1' : '0';

    if(global_permisos_rol['rol'] == codRol){
        global_permisos_rol['permisos'][codModulo][tipoPermiso[permiso]] = valorCampo;
    }
}

function fn_editPermisosCampos(codRol, codModulo){
    var idModal = 'modal_editPermisosCampos';
    //var botonModal = [{"id":"aceptar"+idModal,"label":"Guardar","class":"btn-primary btn-sm"},{"id":"cancelar"+idModal,"label":"Cancelar","class":"btn-primary btn-sm close-modal-general"}];
    var dvContenido = $('<div class="tb-maxalto"></div>');
    var dvBotones = $('<div><button id="aceptar'+idModal+'" class="btn-primary btn-sm roles-key-css_1" >Agregar</button> <button id="cancelar'+idModal+'" class="btn-primary btn-sm" >Cancelar</button></div>');
    if(global_permisos_rol['rol'] == codRol){
        var campos = global_permisos_rol['permisos'][codModulo]['campos'];
        var columnTable = getColumnTable('permisos_campo_rol');
        var arrChecked = ['', 'checked'];
        var tabla = '';
        for(c=0; c<campos.length; c++){
            var campo = campos[c];
            console.log('campo: ',campo);
            campos[c]['ch_estado'] = '<input type="checkbox" id="chc_'+campo['cod_campo']+'" '+arrChecked[campo['estado']]+' >';
        }

        tabla = createTable('tabla_campos_permisos', columnTable, campos);
        dvContenido.html(tabla[0]);
        $('#pCampos').html(dvContenido);
        $('#pCampos').append(dvBotones);

        //crearModal(idModal, 'Permisos campos rol', tabla[0], botonModal, false, 'modal-lg', '',true);
        setTimeout(function(){
            aplicarDataTableCampos("tabla_campos_permisos");
            $('#pModulos').addClass('oculta_elemnt');
        },500);
        
        $('#aceptar'+idModal).click(function(){
            for(d=0; d<campos.length; d++){
                var campo = campos[d];
                var codCampo = global_permisos_rol['permisos'][codModulo]['campos'][d]['cod_campo'];
                global_permisos_rol['permisos'][codModulo]['campos'][d]['estado'] = $('#chc_'+codCampo).is(':checked') ? '1' : '0';
            }
            //$("#"+idModal).modal('hide');
            $('#pModulos').removeClass('oculta_elemnt');
            $('#pCampos').html('');
        });

        $('#cancelar'+idModal).click(function(){
            //$("#"+idModal).modal('hide');
            $('#pModulos').removeClass('oculta_elemnt');
            $('#pCampos').html('');
        });

    }
}

function pasarObjToArr(dataObj){
    var resArr = [];
    for(r in dataObj){
        resArr.push(dataObj[r]);
    }

    return resArr;
}

function fn_guardarPermisosRol(codRol){
    var url = 'Rol/guardarPermisosRol';
    var formData = {};
    var idModal = 'modal_guardarPermisosRol';
    var botonModal = [{"id":"cerrar"+idModal,"label":"Cerrar","class":"btn-primary btn-sm"}];
    //formData['permisos'] = codRol == global_permisos_rol['rol'] ? global_permisos_rol['permisos'] : {};
    //var permisosObj = codRol == global_permisos_rol['rol'] ? global_permisos_rol['permisos'] : {};
    var permisosObj = global_permisos_rol['permisos'];
    var permisosArr = pasarObjToArr(permisosObj);
    console.log('ARR: ',permisosArr);
    formData['cod_rol'] = codRol;
    
    //function recurAjaxCallback(p_url, p_registros, p_paramadd, p_senal, p_iteracion, p_bash, p_fn_callback){
    //callAjaxCallback(url, formData, function(tipo_respuesta, data){
    recurAjaxCallback(url, permisosArr, formData, 1, 0, 1,  function(tipo_respuesta, data){
        if (tipo_respuesta == 0) {
            mensaje = "La operaci&oacute;n no se puedo completar por que ocurrio un error el la basse de datos.";
        }else{
            mensaje = data["result"];
            global_permisos_rol['rol'] = '-1';
            global_permisos_rol['permisos'] = {};
        }
        
        crearModal(idModal, 'Confirmaci&oacute;n', mensaje, botonModal, false, 'modal-md', '',true);
        
        $('#cerrar'+idModal).click(function(){                
            $("#"+idModal).modal('hide');
            $("#modal_dialog_addrol").modal('hide');//Cerrar modal addRol
            $("#modal_dialog_save_rol").modal('hide');//Cerrar modal saveRol
            
        });
    });
}

function aplicarDataTableCampos(idTabla){
    // Setup - add a text input to each footer cell
    $('#'+idTabla+' thead td').each( function () {
        var title = $(this).text();
        if(title != 'Estado'){
            $(this).append('<br><input type="text" placeholder="Buscar '+title+'" />');
        }        
    } );
 
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
 
    // Apply the search
    tableData.columns().every( function () {
        var that = this; 
        $('input[type="text"]', this.header() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        } );
    } );
}




