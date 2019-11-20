<style type="text/css">
    table{
      width: 100%;      
    }
    
    #table_pdf td{
      text-align: center;
    }
    
    .tabla-reporte-info td{
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

    .llave_info_td{
        text-align: end;
        font-weight: 700;
        width: 30%;
    }

    .valor_info_td{
        text-align: left;
        width: 70%;
    }

    thead td{
        text-align: center;
    }

    .llave_noinfo_td{
        text-align: center;
        width: 100%;
    }    

    table {page-break-inside:auto !important}
    tr   { page-break-inside:avoid; page-break-after:auto !important}

    
  </style>

<!--page backtop="45mm" backbottom="10mm" backleft="0mm" backright="5mm">-->
<page backtop="45mm" backbottom="10mm" backleft="0mm" backright="0mm">  
  <page_header>
    <table id="table_pdf" border="0"> 
      <tr>
        <td style="width: 25%;">
          <img src="./asset/public/img/logo_alcaldia.png" style="width:100px;">
        </td>
        <td style="width: 40%;">
        </td>
        <td  style="width: 25%;">
            <img src="./asset/public/img/logo_sibica.png" style="width:100px;">
        </td>
      </tr>
      <tr>
        <td colspan="3" style="width: 100%; text-align:center;">
            <p><b>SISTEMA DE INFORMACI&Oacute;N DE BIENES INMUEBLES DE CALI - SIBICA</b><br>
                  Unidad Administrativa Especial de Gesti&oacute;n de Bienes y Servicios</p>
        </td>        
      </tr>
    </table>
    <br> 
	</page_header>
    <div style="width:100%; text-align:right;">
              <?php echo date("Y/m/d H:m:s"); ?>
    <br></div>
    <?php echo $datosPredio; ?>
</page>