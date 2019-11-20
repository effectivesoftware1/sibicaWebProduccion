<form id="form_usuario2" name="form_usuario2" autocomplete="off" enctype="multipart/form-data">
       <div class="row" id="div_contenedor_identif">
          <div class="col-sm-6">
            <label for="tipoIdentificacion" class="obligatorio">Tipo identificaci&oacute;n</label>
              <?php echo $TipoIdentificacion?>                        
          </div>
          <div class="col-sm-6" id="div_identificacion">
            <label for="identificacion" class="obligatorio">Identificaci&oacute;n</label>
             <input id="identificacion" name="identificacion" maxlength="16" type="text" class="form-control input-sm campo-vd">                        
          </div>                                           
       </div>
       <div class="row">
           <div class="col-sm-6">
            <label for="nombre1" class="obligatorio">Primer Nombre</label>
            <input id="nombre1" name="nombre1" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>
           <div class="col-sm-6">
            <label for="nombre2">Segundo Nombre</label>
            <input id="nombre2" name="nombre2" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>               
       </div>   
       <div class="row">
           <div class="col-sm-6">
            <label for="apellido1" class="obligatorio">Primer Apellido</label>
            <input id="apellido1" name="apellido1" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>
          <div class="col-sm-6">
            <label for="apellido2">Segundo Apellido</label>
            <input id="apellido2" name="apellido2" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>                     
       </div>
       <div class="row" id="div_container_tel">
          <div class="col-sm-6">
            <label for="telefono">Tel&eacute;fono</label>
            <input id="telefono" name="telefono" type="text" maxlength="20" class="form-control input-sm campo-vd">
          </div>
          <div class="col-sm-6">
            <label for="celular" class="obligatorio">Celular</label>
            <input id="celular" name="celular" type="text" maxlength="20" class="form-control input-sm campo-vd">
          </div>                     
       </div>
       <div class="row" id="div_container_email">
           <div class="col-sm-6">
            <label for="correo">Email</label>
            <input id="correo" name="correo" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
           </div>                       
           <div class="col-sm-6">
            <label for="direccion">Direcci&oacute;n</label>
            <input id="direccion" name="direccion" type="text" maxlength="100" class="form-control input-sm campo-vd">
          </div>
       </div> 
       <div class="row" id="div_negocio">
          <div class="col-sm-6">
            <label for="nomNegocio" class="obligatorio">Nombre negocio</label>
            <input id="nomNegocio" name="nomNegocio" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>
           <div class="col-sm-6">
            <label for="dirNegocio" class="obligatorio">Direcci&oacute;n negocio</label>
            <input id="dirNegocio" name="dirNegocio" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>                     
       </div>
       <div class="row" id="div_container">
         <div class="col-sm-6">
              <div><label for="sexo">Sexo</label></div>
              <div class="form-check form-check-inline">
                    <label class="form-check-label mr-4">
                      <input class="form-check-input" type="radio" name="sexo" value="M">M
                      <span class="circle">
                        <span class="check"></span>
                      </span>
                    </label>
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="sexo" value="F">F
                      <span class="circle">
                          <span class="check"></span>
                      </span>
                    </label>
              </div>                      
          </div>
         <div class="col-sm-6" id="div_foto">
            <label for="archivo">Foto</label>
            <div id="div_file">
              <input type="file" id="archivo" name="archivo" class="file" accept="image/*">
            </div>               
         </div>
       </div>
       <div class="row" id="div_usu_login">
          <div class="col-sm-6">
            <label for="usu" class="obligatorio">Usuario</label>
            <input id="usu" name="usu" type="text" maxlength="20" class="form-control input-sm campo-vd">                        
          </div>
           <div class="col-sm-6">
            <label for="contrasena" class="obligatorio">Contrase&ntilde;a</label>
            <input id="contrasena" name="contrasena" type="password" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>                     
       </div>                  
       <br>
        <div class="row">
        <div class="col-sm-12">
          <label>los campos con * son obligatorios.</label>
        </div> 
       </div>                         
 </form>