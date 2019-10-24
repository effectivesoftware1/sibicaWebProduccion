<form id="form_change_contrasena" autocomplete="off">
     <div class="row"> 
         <div class="col-lg-12 col-md-12 col-sm-12">
              <label for="identificacion_rest" class="obligatorio">Identificaci&oacute;n</label>
			  <input id="identificacion_rest" name="identificacion_rest" type="text" maxlength="12" class="form-control input-sm campo-vd">                        
         </div>
     </div>
     <div class="row"> 
         <div class="col-lg-12 col-md-12 col-sm-12">
              <label for="codigo_rest" class="obligatorio">C&oacute;digo enviado a su correo</label>
			  <input id="codigo_rest" name="codigo_rest" type="text" maxlength="6"  class="form-control input-sm campo-vd">                        
         </div>
     </div>
      <div class="row"> 
         <div class="col-lg-8 col-md-8 col-sm-8">
                 <label for="txtContrasenaNueva" class="obligatorio">Contrase&ntilde;a nueva</label>
			           <input id="txtContrasenaNueva" name="txtContrasenaNueva" type="password" maxlength="100" class="form-control input-sm campo-vd">                        
         </div>
         <div class="col-lg-4 col-md-4 col-sm-4">
              <label for="recor_clave">Mostrar contrase&ntilde;a</label>
		 	        <div class="form-check">
			       <label class="form-check-label">
                  <input class="form-check-input" onclick="showClave2()" type="checkbox">
                  <span class="circle">
						 <span class="check"></span>
					  </span>
              </label>			                      
          	</div>                           
         </div>
     </div>
      <div class="row"> 
         <div class="col-lg-8 col-md-8 col-sm-8">
              <label for="txtConfirmarContrasena" class="obligatorio">Ingrese nuevamente la contrase&ntilde;a</label>
			  <input id="txtConfirmarContrasena" name="txtConfirmarContrasena" type="password" maxlength="100" class="form-control input-sm campo-vd">                        
         </div>
         <div class="col-lg-4 col-md-4 col-sm-4">
            <label for="recor_clave">Mostrar contrase&ntilde;a</label>
		 	<div class="form-check">
			  <label class="form-check-label">
                  <input class="form-check-input" onclick="showClave3()" type="checkbox">
                  <span class="circle">
						 <span class="check"></span>
					  </span>
              </label>			                      
          	</div>                           
         </div>
     </div>
 </form>