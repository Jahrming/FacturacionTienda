
<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       header('Content-Type: text/html; charset=UTF-8');  
       include("Conexion.php");  
       $_usuario=$_SESSION['user'];
       $xFechaInicio = $_POST['fechaInicio'];
       $xFechaFin    = $_POST['fechaFin'];
       //$v_buscarPor='A';
       //########## buscar por Apellidos ##################
          $strSQl="SELECT   DescripcionAlmacen,Fecha,RUC,DescripcionProveedor,IdFacturaProveedor,IdFacturaProveedorSRI,".
                         "  Subtotal,Descuento,Iva,Total,DescripcionEstadoFinanciero ".
                    " FROM  factprov,proveedores,estadofinancierofacturaproveedor,almacenes".
                    " WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' ".
                    "   AND factprov.IdAlmacen = almacenes.IdAlmacen  ".
                    "   AND factprov.IdProveedor = proveedores.IdProveedor".
                    "   AND estadofinancierofacturaproveedor.IdEstadoFinanciero= factprov.EstadoFinancieroFactura";
                  //echo $strSQl;
         $rs = mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_array($rs) ) 
          {
            $arreglo['DescripcionAlmacen'][]= $reg['DescripcionAlmacen'];
            $arreglo['Fecha'][]= $reg['Fecha'];
            $arreglo['RUC'][]= $reg['RUC'];
            $arreglo['DescripcionProveedor'][]= $reg['DescripcionProveedor'];
            $arreglo['IdFacturaProveedor'][]= $reg['IdFacturaProveedor'];
            $arreglo['IdFacturaProveedorSRI'][]= $reg['IdFacturaProveedorSRI'];            
            $arreglo['Subtotal'][]= $reg['Subtotal'];
            $arreglo['Descuento'][]= $reg['Descuento'];
            $arreglo['Iva'][]= $reg['Iva'];      
            $arreglo['Total'][]= $reg['Total'];     
            $arreglo['DescripcionEstadoFinanciero'][]= $reg['DescripcionEstadoFinanciero'];          
          }
          echo json_encode($arreglo);

      }



