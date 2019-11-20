	<style type="text/css">
    table{
      width: 100%;      
    }
    
    table td{
      text-align: center; 
      border: 1px solid rgb(220,220,220);
      height: 15px;   
    }   
    .espacio{
      height:10px;
     }
    .tr_obj{
    height: 100px;
    }
    .color_td{
    background: #b5bfb5;
    }
    .aling_lef{
    text-align: left !important;
    }
      .negrita{
        font-weight: bold;
      }
      .img_file{
       width: 335px; 
       height: 200px;
       
     }
      .img_file_base64{
       width: 100px; 
       height: 40px;       
     }

     #table_pdf6{
        text-transform: uppercase;
     }

     table {page-break-inside:auto !important}
      tr   { page-break-inside:avoid; page-break-after:auto !important}

    
  </style>

<!--page backtop="45mm" backbottom="10mm" backleft="0mm" backright="5mm">-->
<page backtop="45mm" backbottom="10mm" backleft="0mm" backright="0mm">  
  <page_header>
    <table id="table_pdf" border="1"> 
      <tr>
        <td rowspan="3" style="width: 30%;">
          <img src="./asset/public/img/logo_alcaldia.png"><br>
          GESTI&Oacute;N JUR&Iacute;DICO ADMINISTRATIVA<br>
          ADMINISTRACI&oacute;N DE BIENES INMUEBLES,<br> 
          MUEBLES Y AUTOMOTORES
        </td>
        <td rowspan="3" style="width: 40%;"><p>SISTEMAS DE GESTI&Oacute;N Y CONTROL INTEGRADOS<br>
                            (SISTEDA, SGC y MECI)</p>

                          <p><b>ACTA DE VISITA  PARA LA ADMINISTRACI&Oacute;N DE <br>BIENES INMUEBLES</b></p>
        </td>
        <td colspan="2" style="width: 30%;">MAJA01.03.03.18.P13.F02</td>
      </tr>
      <tr>
        <td style="width: 15%;">VERSI&Oacute;N</td>
        <td style="width: 15%;">1</td>
      </tr>
      <tr>
        <td style="width: 15%;">FECHA  DE ENTRADA EN VIGENCIA</td>
        <td style="width: 15%;">18/sep/2015</td>
      </tr>    
  </table>	   
	</page_header>
  <br>
	<table id="table_pdf2" border="1">		
			<tr>
				<td style="width:30%;" class="color_td">CALIDAD DEL BIEN INMUEBLE</td>
				<td style="width:20%;">USO P&Uacute;BLICO </td>
				<td style="width:10%;"><?php echo $data->calidad_in_pu; ?></td>
				<td style="width:20%;">FISCAL</td>
				<td style="width:20%;"><?php echo $data->calidad_in_fiscal; ?></td>
			</tr>			
			<tr>
				<td style="width: 100%;" colspan="5" id="td_objetivo" class="negrita">OBJETIVO DE LA VISITA:</td>				
			</tr>
			<tr class="tr_obj1">
				<td style="width: 100%;"  colspan="5"  class="aling_lef"><?php echo $data->objetivo; ?></td>				
			</tr>
      <tr>     
        <td style="width: 30%;" colspan="1" class="negrita">N&Uacute;MERO PREDIAL:</td>
        <td style="width: 30%;" colspan="2" ><?php echo $data->num_predial; ?></td> 
        <td style="width: 20%;" colspan="1" class="negrita">CALIDAD BIEN:</td>
        <td style="width: 20%;" colspan="1" ><?php echo $data->nom_calidad_bien; ?></td>        
      </tr> 
      <tr>
        <td style="width: 30%;" colspan="1" class="negrita" >NOMBRE:</td>
        <td style="width: 30%;" colspan="2" ><?php echo $data->nombre_terreno; ?></td> 
        <td style="width: 20%;" colspan="1" class="negrita">EP:</td>
        <td style="width: 20%;" colspan="1" ><?php echo $data->ep; ?></td>        
      </tr> 
      <tr>
        <td style="width: 30%;" colspan="1"class="negrita" >MATRICULA:</td>
        <td style="width: 30%;" colspan="2" ><?php echo $data->num_matricula; ?></td> 
        <td style="width: 20%;" colspan="1" class="negrita">TIPO BIEN:</td>
        <td style="width: 20%;" colspan="1" ><?php echo $data->nom_tipo_bien; ?></td>        
      </tr> 
       <tr>
        <td style="width: 30%;" colspan="1" class="negrita" >USO:</td>
        <td style="width: 30%;" colspan="2" ><?php echo $data->nom_uso; ?></td> 
        <td style="width: 20%;" colspan="1" class="negrita">PROYECTO:</td>
        <td style="width: 20%;" colspan="1" ><?php echo $data->nom_proyect; ?></td>      
      </tr> 
	</table>
	<table id="table_pdf3" border="1" >	
			<tr>
				<td style="width: 15%;">HORA:</td>
				<td style="width: 15%;">INICIO</td>
				<td style="width: 25%;"><?php echo $data->fecha_inicio; ?></td>
				<td style="width: 20%;">FINALIZACI&Oacute;N</td>
				<td style="width: 25%;"><?php echo $data->fecha_fin; ?></td>
			</tr>
			<tr class="color_td">
				<td style="width: 100%;" colspan="5">LOCALIZACI&Oacute;N</td>				
			</tr>
			<tr>				
				<td style="width: 30%;" colspan="2">DIRECCI&Oacute;N</td>
				<td style="width: 70%;" colspan="3"><?php echo $data->direccion; ?></td>				
			</tr>
			<tr>				
				<td style="width: 30%;" colspan="2">BARRIO/URBANIZACI&Oacute;N:</td>
				<td style="width: 25%;"><?php echo $data->barrio; ?></td>
				<td style="width: 20%;">COMUNA:</td>
				<td style="width: 25%;"><?php echo $data->comuna; ?></td>				
			</tr>
			<tr class="color_td">
				<td style="width: 55%;"  colspan="3">TIPO DE VISITA</td>
				<td style="width: 45%;"  colspan="2">ESQUEMA DE LOCALIZACI&Oacute;N</td>				
			</tr>
			<tr>
				<td style="width: 15%;"  colspan="1"><?php echo $data->tip_vis_1; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">T&Eacute;CNICA BIENES INMUEBLES.</td>
				<td style="width: 45%;" colspan="2" rowspan="8"><img class="img_file" src="<?php echo $data->ruta_img_visita; ?>"></td>								
			</tr>
			<tr>
				<td style="width: 15%;" colspan="1"><?php echo $data->tip_vis_2; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">JUR&Iacute;DICA BIENES INMUEBLES.</td>								
			</tr>
			<tr>
				<td style="width: 15%;" colspan="1"><?php echo $data->tip_vis_3; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">SANEAMIENTO CONTABLE.</td>								
			</tr>
			<tr>
				<td style="width: 15%;" colspan="1"><?php echo $data->tip_vis_4; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">SERVICIOS P&Uacute;BLICOS.</td>								
			</tr>
			<tr>
				<td style="width: 15%;" colspan="1"><?php echo $data->tip_vis_5; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">CALIDAD DE BIEN.</td>								
			</tr>
			<tr>
				<td style="width: 15%;" colspan="1"><?php echo $data->tip_vis_6; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">TOPOGRAFIA.</td>								
			</tr>
			<tr>
				<td style="width: 15%;" colspan="1"><?php echo $data->tip_vis_7; ?></td>
				<td style="width: 40%;" class="aling_lef" colspan="2">INCORPORACI&Oacute;N Y ENTREGA DE &Aacute;REAS DE CESI&Oacute;N.</td>								
			</tr>
			<tr>
				<td  style="width: 15%;" colspan="1"><?php echo $data->tip_vis_8; ?></td>
				<td  style="width: 40%;" class="aling_lef" colspan="2">PROCESO DE RESTITUCI&Oacute;N.</td>								
			</tr>      
  			<tr class="color_td">
  				<td style="width: 100%;" colspan="5">OBSERVACIONES</td>											
  			</tr>      
         <?php echo $datatr["observacion"];?>     
        <tr class="color_td">
          <td style="width: 100%;" colspan="5">DOCUMENTOS ASOCIADOS</td>                     
        </tr>
        <tr>
          <td style="width: 15%;" colspan="1">#</td>
          <td style="width: 85%;" colspan="4">ANEXO</td>                     
        </tr>
        <?php echo $datatr["nombre_files"]; ?>               
	</table>  
  <nobreak> 
    <table id="table_pdf4" border="1">
        <tr class="color_td">
          <td colspan="2" style="width: 100%;">FOTOGRAFIAS</td>                     
        </tr>
       <?php echo $datatr["images"]; ?>
    </table>
  </nobreak> 
  <br>
  <br>
  <table id="table_pdf5" border="1">
       <tr>
          <td style="width: 60%;">Se firma por quienes intervienen en ella:</td>
          <td style="width: 20%;">FECHA VISITA</td>
          <td style="width: 20%;"><?php echo $data->fecha_visita;?></td>                     
       </tr>    
  </table>
  <br>
  <br>
  <br>
  <br>
  <table id="table_pdf6" border="0">
       <?php echo $datatr["personas"];?>
  </table>  
 

</page>