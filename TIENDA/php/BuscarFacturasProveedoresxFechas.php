
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
                    " FROM  factprov,proveedores,estadofinancierofacturaproveedor,almacenes"
                    " WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' ".
                    "   AND factprov.IdAlmacen = almacenes.IdAlmacen  "; 
                   echo $strSQl;
          $rs = mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {
            $arreglo['DescripcionAlmacen'][]= $reg['DescripcionAlmacen'];
            $arreglo['Fecha'][]= $reg['Fecha'];
            $arreglo['RUC'][]= $reg['RUC'];
            $arreglo['DescripcionProveedor'][]= $reg['DescripcionProveedor'];
            $arreglo['IdFacturaProveedor'][]= $reg['IdFacturaProveedor'];
            $arreglo['IFacturaProveedorSRI'][]= $reg['IFacturaProveedorSRI'];            
            $arreglo['Subtotal'][]= $reg['Subtotal'];
            $arreglo['Descuento'][]= $reg['Descuento'];
            $arreglo['Iva'][]= $reg['Iva'];      
            $arreglo['Total'][]= $reg['Total'];     
            $arreglo['DescripcionEstadoFinanciero'][]= $reg['DescripcionEstadoFinanciero'];          
          }
          echo json_encode($arreglo);

      }


