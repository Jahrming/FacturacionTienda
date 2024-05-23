<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $v_numCedula='';
        $v_nombres='';
        $v_valor='';
        
        $sql="SELECT * from systemprofile ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 
        $periodoLectivo = $registro['PeriodoLectivoActual'];

       #---------Carga Proveedores ---------#
       $SqlProveedores="Select * from proveedores where EstadoProveedor='A'";       
       $ResultProveedores=  mysqli_query($conexion, $SqlProveedores);
       while($reg_Proveedores=  mysqli_fetch_array($ResultProveedores))
       {
           $IdProveedor=$reg_Proveedores['IdProveedor'];
           $DescProveedor=$reg_Proveedores['DescripcionProveedor'];
           $ListaProveedores.=
              "<option value='".$IdProveedor."'>".$DescProveedor."</option>";
       }  
       #---------Carga Forma de Pago Proveedores ---------#
       $ListaFormaPagoProveedores='';
       $SqlFormaPagoProveedores="Select * from formapagoproveedores where EstadoFormaPago='A'";    
       $ResultFormaPagoProveedores=  mysqli_query($conexion, $SqlFormaPagoProveedores);
       while($reg_FormaPagoProveedores=  mysqli_fetch_array($ResultFormaPagoProveedores))
       {
           $IdFormaPagoProveedor=$reg_FormaPagoProveedores['IdFormaPagoProveedor'];
           $DescFormaPagoProveedor=$reg_FormaPagoProveedores['DescripcionFormaPago'];
           $ListaFormaPagoProveedores.=
              "<option value='".$IdFormaPagoProveedor."'>".$DescFormaPagoProveedor."</option>";
       }  
       #---------Carga Forma de Pago Proveedores ---------#
       $ListaEstadoFinanciero='';
       $SqlEstados="Select * from estadofinancierofacturaproveedor where Estado='A'";       
       $ResultEstados=  mysqli_query($conexion, $SqlEstados);
       while($reg_Estados=  mysqli_fetch_array($ResultEstados))
       {
           $IdEstado=$reg_Estados['IdEstadoFinanciero'];
           $DescEstadoFinanciero=$reg_Estados['DescripcionEstadoFinanciero'];
           $ListaEstadoFinanciero.=
              "<option value='".$IdEstado."'>".$DescEstadoFinanciero."</option>";
       }  


      }
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA IMPORTBOOKS </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">


  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body >

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action="GrabarFacturaProveedor.php" >  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">INGRESO DE COMPRAS
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="submit" class="btn btn-primary btn-sm" title='Grabar' onClick='trampa();' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                  <div class="form-row"  >
                      <input type='hidden' id='IdProveedor' name='IdProveedor' value=''>
                      <input type='hidden' id='NumeroFilas' name='NumeroFilas' value='0'/>

                      <input type='hidden' id='Email' name='Email' >
                      <input type='hidden' id='Direccion' name='Direccion' >
                      <input type='hidden' id='ivaActual' name='ivaActual' value='<?php echo $ivaActual;?>' >
                      <div class="form-group col-md-3">
                          <label style='color:#0080FF' for="proveedor">RUC Proveedor:</label>
                          <input style='color:#0080FF' type="text" onkeypress="return pulsar(event)" class="form-control" id="RucProveedor" name='RucProveedor' placeholder="Cédula o RUC" required="yes">
                      </div>
                      <div class="form-group col-md-1">
                          <label style='color:#FFFFFF' for="f_buscar">Bus</label>
                          <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('proveedor')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
                      </div>
                      <div class="form-group col-md-5">
                          <label style='color:#0080FF'  for="f_apellidos">Nombre Proveedor:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="NombreProveedor" name='NombreProveedor' readonly="yes">
                      </div>
                      <div class="form-group col-md-3">
                              <label style='color:#0080FF'  for="f_apellidos">Fecha Factura: </label>
                              <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="FecFactura" name='FecFactura' required="yes">
                      </div>    
                 </div>            

                  <div class="form-row"  >
  
                      <div class="form-group col-md-3">
                        <label style='color:#0080FF'  for="f_apellidos">Forma Pago:</label>
                        <select style='color:#0080FF' id='IdFormaPagoProveedor' name='IdFormaPagoProveedor' class="form-control" required="yes" onkeypress="return pulsar(event)">
                            <option value=''>Seleecionar</option>
                            <?php
                               echo $ListaFormaPagoProveedores;
                             ?>
                        </select> 
                      </div>
                      <div class="form-group col-md-3">
                        <label style='color:#0080FF'  for="f_apellidos">Estado Factura:</label>
                        <select style='color:#0080FF' id='IdEstadoFinanciero' name='IdEstadoFinanciero' class="form-control"  required="yes" onkeypress="return pulsar(event)">
                            <option value=''>Seleecionar</option>
                            <?php
                               echo $ListaEstadoFinanciero;
                             ?>
                        </select> 
                      </div>  
                      <div class="form-group col-md-3">
                              <label style='color:#0080FF'  for="f_descuento">No Factura: </label>
                              <input style='color:#0080FF;text-align:right;' type="text" class="form-control" id="FacturaSri" name='FacturaSri' required="yes" onkeypress="return pulsar(event)">
                      </div>       
                      <div class="form-group col-md-3">
                              <label style='color:#0080FF'  for="f_descuento">Descuento: </label>
                              <input style='color:#0080FF;text-align:right;' type="number" class="form-control" id="Descuento" name='Descuento' value='0.00' step='0.01' onkeypress="return pulsar(event)">
                      </div>   
                                                              
                 </div>     
              </div>
             

              <div class="panel-body" style="width:25%; float:left; display:block;background-color:#E6E6E6"> 
                  <div class="form-row" style="width:100%"  >
                    <style>
                        table {
                            font-family: 'Poppins', sans-serif;
                            /*border-collapse: collapse;*/
                            /*width: 100%;*/
                            font-size: 15px;
                        }
                    </style>
                    <table >
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspSubtotal:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='SubTotalPrincipal'  name='SubTotalPrincipal' size='7' readonly style='border:none;width:100px;height:25px;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspDscto:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='DescuentoPrincipal'  name='DescuentoPrincipal' size='7' readonly style='border:none;width:100px;height:25px;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspI.V.A.:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='IvaPrincipal'  name='IvaPrincipal' size='7' readonly style='border:none;width:100px;height:25px;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspTotal:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='TotalFactura'  name='TotalFactura'' size='7' readonly style='border:none;width:100px;height:25px;;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>                      
                    </table>
                 </div>                                                                  
              </div>  
             </div>              
          </div>            
        </div>   
     </div>

  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >DETALLE DE ITEMS</div>
       <div class="panel-body" style="width:100%; display:block;">

                <div class="form-row"  >
                  <div class="form-group col-md-2">
                          <input type='hidden' id='IdReferencia' name='IdReferencia' value=''>
                          <input type='hidden' id='CargaIva' name='CargaIva' value=''>
                          <input type='hidden' id='Iva' name='Iva' value=''>
                          <input type='hidden' id='Existe' name='Existe' value=''>

                          <label style='color:#0080FF' for="f_codigo">Item:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="Codigo" name='Codigo' placeholder="Código Barra" required="yes" onkeypress='return pulsar(event)' onkeydown="capturaKey(event);">
                  </div>
                  <div class="form-group col-md-1">
                      <label style='color:#FFFFFF' for="f_buscar">Find</label>
                      <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('producto')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>

                  </div>
                  <div class="form-group col-md-5">
                      <label style='color:#0080FF'  for="f_apellidos">Descripción:</label>
                      <input style='color:#0080FF' type="text" class="form-control" id="NombreProducto" name='NombreProducto' readonly="yes">
                  </div>
                  <div class="form-group col-md-1">
                      <label style='color:#0080FF'  for="f_apellidos">Cant:</label>
                      <input style='color:#0080FF' type="number" step='0.1' onkeypress="return pulsar(event)" class="form-control" id="Cantidad" name='Cantidad' value='1.0'  >
                  </div>
                  <div class="form-group col-md-2">
                      <label style='color:#0080FF'  for="f_apellidos">PVP:</label>
                      <input style='color:#0080FF' type="text" class="form-control" id="Precio" name='Precio' readonly="yes">
                  </div> 
                  <div class="form-group col-md-1">
                    <label style='color:#FFFFFF' for="f_add">add</label>
                    <input type='button' name='btnAgregar' id='add' class='btn btn-primary btn-sm' value='Add' onclick="addFilasFacturaProveedor();" >
                  </div>
               </div>
 
           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   
            <?php
               $iconoEliminar = 'glyphicon glyphicon-trash';
               $codigoHtml= "<span class='".$iconoEliminar."'></span>";
            ?>
            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Item</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Barra</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='30%'><b><center>Descripción</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Cant.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Precio.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Descuento</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Subtotal</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>I.V.A.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Costo Unitario</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center><?php echo $codigoHtml;?></center></b></th>
              </tr>
            </thead>
            <tbody id='respuesta'>
            </tbody>
        </table>    
     </div>
  </div>
</div>

 </form>
</section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


<script type="text/javascript">
   var xhr;
   var existeProducto=0;

      function VerificaProductoCompra(){

      var datosString ='';
      var datosArray ='';   
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= ObtenerDatosCompra;
      xhr.open('POST','RetornaDatosProductoCompra.php',false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("Codigo="+document.getElementById('Codigo').value);

      function ObtenerDatosCompra()
      {
         if(xhr.readyState==4)
            {
              if(xhr.status==200)
                {
                  datosString    = this.responseText;
                  if(datosString==0)
                  {
                    existeProducto = 0;
                    //document.getElementById('Codigo').focus();
                  }
                  else
                  { 
                    datosArray  =  datosString.split('_;_');      
                    existeProducto = 1;
                    document.getElementById('IdReferencia').value   = datosArray[0];
                    document.getElementById('Codigo').value         = datosArray[1];
                    document.getElementById('NombreProducto').value = datosArray[2];
                    document.getElementById('Precio').value         = datosArray[3];

                    document.getElementById('CargaIva').value       = datosArray[4];
                    document.getElementById('Iva').value            = datosArray[5];
                  //alert('eciste por si'+document.getElementById('Existe').value);
                  } 
                }
            }
      }
   }


   function capturaKey(event){
     var tecla= event.which|| event.keyCode;
     if (tecla==13){
       VerificaProductoCompra();
          if(existeProducto==1)
          {
             document.getElementById('add').focus();    
          }
          else
          {
            alert('Item no existe');
            document.getElementById('Codigo').value=null;
            document.getElementById('Codigo').focus();
          }
          existeProducto=0;
        }
  
     
     if(tecla==113){
        addFilasFacturaProveedor();
     }
   }


function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
} 

var i=0;

//#-----------------recalcula totales ------------------#
function recalculaTotal(){
    var xTotalBruto=0;
    var xTotalFactura=0;
    var xSubTotal=0;
    var xDescuento=0;
    var xIva = 0;
    $(this).closest('tr').remove();
    nfilas = $('#NumeroFilas').val();
    //alert('nfilas '+nfilas);
    for(i=1;i<=nfilas;i++){
         var elementoTotalBruto=0;
         var elementoDescuento=0;
         var elementoSubTotal=0;
         var elementoIva=0;
         var elementoTotalLinea=0;
         elementoTotalBruto='TotalBruto'+i;
         elementoDescuento ='Descuento'+i;
         elementoSubTotal = 'SubTotal'+i;
         elementoIva = 'Iva'+i;
         elementoTotalLinea='TotalLinea'+i;
         if(document.getElementById(elementoTotalBruto))
         {
           xTotalBruto=xTotalBruto+ parseFloat(document.getElementById(elementoTotalBruto).value);
         }
         if(document.getElementById(elementoDescuento))
         {
           xDescuento=xDescuento+ parseFloat(document.getElementById(elementoDescuento).value);
         }
         xSubTotal=xSubTotal+(xTotalBruto - xDescuento);
         if(document.getElementById(elementoIva))
         {
            xIva=xIva+ parseFloat(document.getElementById(elementoIva).value);
         }
         if(document.getElementById(elementoTotalLinea))
         {
            xTotalFactura=xTotalFactura+ parseFloat(document.getElementById(elementoTotalLinea).value);
         }                                                      
       }
       $('#SubTotalPrincipal').val(xTotalBruto.toFixed(2));
       $('#DescuentoPrincipal').val(xDescuento.toFixed(2));
       $('#IvaPrincipal').val(xIva.toFixed(2));
       $('#TotalFactura').val(xTotalFactura.toFixed(2));
  }

  //######----- Eliminar filas ------------#
  $(document).on('click','.eliminar',function(event){
      event.preventDefault();
      var xTotalBruto=0;
      var xTotalFactura=0;
      var xSubTotal=0;
      var xDescuento=0;
      var xIva = 0;
      $(this).closest('tr').remove();
      nfilas = $('#NumeroFilas').val();
     //alert('nfilas '+nfilas);
      for(i=1;i<=nfilas;i++){
        var elementoTotalBruto=0;
        var elementoDescuento=0;
        var elementoSubTotal=0;
        var elementoIva=0;
        var elementoTotalLinea=0;
        elementoTotalBruto='TotalBruto'+i;
        elementoDescuento ='Descuento'+i;
        elementoSubTotal = 'SubTotal'+i;
        elementoIva = 'Iva'+i;
        elementoTotalLinea='TotalLinea'+i;
        if(document.getElementById(elementoTotalBruto))
        {
           xTotalBruto=xTotalBruto+ parseFloat(document.getElementById(elementoTotalBruto).value);
        }
        if(document.getElementById(elementoDescuento))
        {
           xDescuento=xDescuento+ parseFloat(document.getElementById(elementoDescuento).value);
        }
        xSubTotal=xSubTotal+(xTotalBruto - xDescuento);
        if(document.getElementById(elementoIva))
        {
           xIva=xIva+ parseFloat(document.getElementById(elementoIva).value);
        }
        if(document.getElementById(elementoTotalLinea))
        {
           xTotalFactura=xTotalFactura+ parseFloat(document.getElementById(elementoTotalLinea).value);
        }                                                      
      }
      $('#SubTotalPrincipal').val(xTotalBruto.toFixed(2));
      $('#DescuentoPrincipal').val(xDescuento.toFixed(2));
      $('#IvaPrincipal').val(xIva.toFixed(2));
      $('#TotalFactura').val(xTotalFactura.toFixed(2));
    }
  );

function trampa()
{
  $('#Codigo').val('0');
}

function desabilita()
{
  $('#Codigo').val('0');
}


           

</script>
</html> 

   