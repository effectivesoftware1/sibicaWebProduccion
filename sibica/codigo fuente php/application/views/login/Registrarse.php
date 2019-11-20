    <form id="form_usuario" name="form_usuario" autocomplete="off">
       <div class="row form-group">          
          <!--<div class="col-sm-6" id="div_identificacion">
             <label for="identificacion" class="obligatorio">Identificaci&oacute;n</label>
             <input id="identificacion" name="identificacion" maxlength="16" type="text" class="form-control input-sm campo-vd">                        
          </div>-->
          <div class="col-sm-6">
            <label for="nombre1" class="obligatorio">Primer Nombre</label>
            <input id="nombre1" name="nombre1" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>
          <div class="col-sm-6">
            <label for="nombre2">Segundo Nombre</label>
            <input id="nombre2" name="nombre2" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>                                            
       </div>
       <div class="row form-group"> 
          <div class="col-sm-6">
            <label for="apellido1" class="obligatorio">Primer Apellido</label>
            <input id="apellido1" name="apellido1" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>
          <div class="col-sm-6">
            <label for="apellido2">Segundo Apellido</label>
            <input id="apellido2" name="apellido2" type="text" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>              
       </div>   
       <div class="row form-group"> 
          <div class="col-sm-6">
            <label for="dependencia" class="obligatorio">Dependencia</label>
            <select id="dependencia" name="dependencia" class="form-control selectpicker" data-style="btn-sm">
               <?php echo $optdependencia?>
            </select>            
          </div>
          <div class="col-sm-6">
            <label for="rol" class="obligatorio">Rol</label>
             <select id="rol" name="rol" class="form-control lista-vd">
                <?php echo $optrol?>
            </select> 
          </div>    
       </div>       
       <div class="row form-group">                                
          <div class="col-sm-6">
            <label class="obligatorio" for="email">Email</label>
            <input id="email" name="email" type="text" maxlength="100" class="form-control input-sm campo-vd">
          </div>
          <div class="col-sm-6">
            <label for="clave" class="obligatorio">Clave</label>
            <input id="clave" name="clave" type="password" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>
       </div> 
       <div class="row form-group"> 
          <div class="col-sm-6">
            <label for="estado" class="obligatorio">Estado</label>
            <select id="estado" name="estado" class="form-control lista-vd">
                <?php echo $optestado?>
            </select>             
          </div>
          <div class="col-sm-6">
            <label for="clave_2" class="obligatorio">Confirmar clave</label>
            <input id="clave_2" name="clave_2" type="password" maxlength="100" class="form-control input-sm campo-vd">                        
          </div>                           
       </div>     
       <br>
        <div class="row form-group">
          <div class="col-sm-12">
            <label>los campos con * son obligatorios.</label>
          </div> 
       </div>                         
 </form>