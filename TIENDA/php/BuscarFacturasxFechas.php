
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
          $strSQl="SELECT  DescripcionAlmacen,TipDoc,DescripcionTipoDocumento,movta.aud_fecha_proc aud_fecha_proc,FactSri, IdMov , SubTotal , Descuento, Impuesto, Total as Total FROM movta, tipodocumento,almacenes ".
                    " WHERE movta.TipDoc = tipodocumento.IdTipoDocumento  and movta.Fecha >='$xFechaInicio' AND movta.Fecha <='$xFechaFin' ".
                    "   AND movta.IdAlmacen = almacenes.IdAlmacen Order By movta.Fecha "; 
                   // echo $strSQl;
          $rs = mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {
            $arreglo['DescripcionAlmacen'][]= $reg['DescripcionAlmacen'];
            $arreglo['TipDoc'][]= $reg['TipDoc'];
            $arreglo['DescripcionTipoDocumento'][]= $reg['DescripcionTipoDocumento'];
            $arreglo['Fecha'][]= $reg['aud_fecha_proc'];
            $arreglo['FactSri'][]= $reg['FactSri'];
            $arreglo['IdMov'][]= $reg['IdMov'];            
            $arreglo['SubTotal'][]= $reg['SubTotal'];
            $arreglo['Descuento'][]= $reg['Descuento'];
            $arreglo['Impuesto'][]= $reg['Impuesto'];      
            $arreglo['Total'][]= $reg['Total'];              
          }
          echo json_encode($arreglo);

      }


