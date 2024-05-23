
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

          $strSQl="SELECT f.*,p.DescripcionProveedor,p.RUC FROM factprov f, proveedores p".
                    " WHERE f.IdProveedor = p.IdProveedor ".
                    " AND f.Fecha >='$xFechaInicio' AND f.Fecha <='$xFechaFin' ORDER BY Fecha "; 
          $rs = mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {
            $arreglo['Fecha'][]= $reg['Fecha'];
            $arreglo['IdFacturaProveedorSRI'][]= $reg['IdFacturaProveedorSRI'];
            $arreglo['IdFacturaProveedor'][]= $reg['IdFacturaProveedor'];    
            $arreglo['RUC'][]= $reg['RUC'];    
            $arreglo['DescripcionProveedor'][]= $reg['DescripcionProveedor'];          
            $arreglo['SubTotal'][]= $reg['SubTotal'];
            $arreglo['Descuento'][]= $reg['Descuento'];
            $arreglo['Iva'][]= $reg['Iva'];
            $arreglo['Total'][]= $reg['Total'];              
          }
          echo json_encode($arreglo);

      }


