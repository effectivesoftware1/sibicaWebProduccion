    <form id="form_change_contrasena" autocomplete="off">
        <div class="row"> 
          <div class="col-sm-8">
              <label for="txtContrasenaActual" class="obligatorio">Contrase&ntilde;a actual</label>
              <input id="txtContrasenaActual" name="txtContrasenaActual" type="password" class="form-control input-sm">                        
          </div>
          <div class="col-sm-4">
            <label for="recor_clave">Mostrar contrase&ntilde;a</label>
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" onclick="showClave()" type="checkbox">
                <span class="circle">
                  <span class="check"></span>
                </span>
              </label>                           
            </div>                           
          </div>                    
        </div> 
        <div class="row"> 
           <div class="col-sm-8">
                <label for="txtContrasenaNueva" class="obligatorio">Contrase&ntilde;a nueva</label>
                <input id="txtContrasenaNueva" name="txtContrasenaNueva" type="password" class="form-control input-sm">                        
            </div>
          <div class="col-sm-4">
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
         <div class="col-sm-8">
              <label for="txtConfirmarContrasena" class="obligatorio">Ingrese nuevamente la contrase&ntilde;a</label>
              <input id="txtConfirmarContrasena" name="txtConfirmarContrasena" type="password" class="form-control input-sm">                        
         </div>
         <div class="col-sm-4">
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