<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");    
       $html ='';
       $xIdMov     =   $_REQUEST['IdMov'];
       $xUsuario   =   $_SESSION["user"];

       $sql="Select * from movta where IdMov=$xIdMov ";
       $rs = mysqli_query($conexion,$sql);
       $regMovta= mysqli_fetch_assoc($rs);
       $xIdCliente = $regMovta['IdCliente'];
       $xIdCaja =  $regMovta['IdCaja'];
       $xFecha =  $regMovta['Fecha'];
       $xSubTotalCab= $regMovta['SubTotal'];
       $xDescuentoCab= $regMovta['Descuento'];
       $xImpuestoCab= $regMovta['Impuesto'];
       $xTotalCab= $regMovta['Total'];
       $xIdAsginacion= $regMovta['IdAsignacion'];
       $xIdAlmacen= $regMovta['IdAlmacen'];
       $xIdEmpresa= $regMovta['IdEmpresa'];
       $xSri= $regMovta['FactSri'];
       $xUsuario= $regMovta['aud_usuario_proc'];

       $sql="Select * from colegios where IdColegio=$xIdEmpresa ";
       $rs1 = mysqli_query($conexion,$sql);
       $regColegio= mysqli_fetch_assoc($rs1);
       $xNombreColegio = $regColegio['DescripcionColegio'];
      
       $sql="Select * from clientes where IdCliente=$xIdCliente ";
       $rs2 = mysqli_query($conexion,$sql);
       $regCliente= mysqli_fetch_assoc($rs2);
       $xNombreCliente = $regCliente['Apellidos'].' '.$regCliente['Nombres'];

       $sql="Select * from movref where IdMov=$xIdMov ";
       $rs3 = mysqli_query($conexion,$sql);
       while($regDetalle= mysqli_fetch_array($rs3))
       {
          $xItem = $regDetalle['IdReferencia'];
          $xPrecio =   $regDetalle['Precio'];
          $xCantidad = $regDetalle['Cantidad'];
          $xSubTotal = $regDetalle['TotalBruto'];
          $xDescuento = $regDetalle['Descuento'];
          $xImpuesto = $regDetalle['ValorImpto'];
          $xTotal = $regDetalle['TotalLinea'];
            $sql="Select * from referencias where IdReferencia=$xItem ";
            $rs4 = mysqli_query($conexion,$sql);
            $regProductos= mysqli_fetch_assoc($rs4);
            $xNombreItem = $regProductos['DescripcionReferencia'];
            $html.="<tr><td>$xItem</td><td>$xNombreItem</td><td>$xPrecio</td><td>$xCantidad</td><td>$xSubTotal</td><td>$xDescuento</td><td>$xImpuesto</td><td>$xTotal</td></tr>";
       }
      }
?>

       
<!DOCTYPE html>
<html>
<head>
      <title> SISTEMA IMPORTBOOKS</title>
      <script type='text/javascript' src='../js/funciones.js'>          </script>
      <script type='text/javascript' src='../js/alertifyjs/alertify.js'>  </script>
      <script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
      <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
      <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
      <link rel='stylesheet' href='../css/estilos.css' >
      <link rel='stylesheet' href='../css/bootstrap.min.css'>
      <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='#'>  
      <div class='container'>
          <div class='panel panel-default'>
            <?php echo "<div class='panel-heading' style='font-size: 12px;color:#0080FF;font-weight:bold;'>CONSULTA DE FACTURA [DETALLE] ";?>  
          </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="IdProducto">No. Mov</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="IdProducto" name="IdProducto" readonly="yes" value='<?php echo $xIdMov;?>' >
                  </div>
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="codigoBarra">Fecha:</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" name='codigoBarra' class="form-control" id="codigoBarra"  value='<?php echo $xFecha;?>' readonly="yes">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px'  for="f_apellidos">Sec. SRI: </label>
                    <input style='color:#0080FF;font-size: 12px' type="text" onkeypress="return pulsar(event)" class="form-control" id="nombreProducto" name='nombreProducto' value='<?php echo $xSri;?>' readonly="yes">
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px'  for="f_ISBN">Cliente: </label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="isbn" name='isbn' readonly="yes" value='<?php echo $xNombreCliente;?>' >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="estado">Colegio:</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="isbn" name='isbn' readonly="yes" value='<?php echo $xNombreColegio;?>' >       
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="estado">SubTotal:</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="isbn" name='isbn' readonly="yes" value='<?php echo $xSubTotalCab;?>' >       
                  </div>
                </div>               
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="estado">Descuento:</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="isbn" name='isbn' readonly="yes" value='<?php echo $xDescuentoCab;?>' >       
                  </div>
                </div>                  
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="estado">Impuesto:</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="isbn" name='isbn' readonly="yes" value='<?php echo $xImpuestoCab;?>' >       
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF;font-size: 12px' for="estado">Total:</label>
                    <input style='color:#0080FF;font-size: 12px' type="text" class="form-control" id="isbn" name='isbn' readonly="yes" value='<?php echo $xTotalCab;?>' >       
                  </div>
                </div> 
              </div>                      
              <div class="form-group col-md-12">
                    <table class='table table-bordered table-hover' style='font-size: 12px' >
                      <thead class='fixedHeader' >
                          <tr >
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Id Producto</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Descripción</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Precio</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Cantidad</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Subtotal</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Descuento</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Impuesto</center></b></th>
                              <th  bgcolor='#FFFF00' style='color: #0080FF;font-size: 12px'><b><center>Total</center></b></th>
                          </tr>
                       </thead>
                          <?php echo $html;?>
                    </table>                        
              </div>
          </div>
        </div>
      </div>
   </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   