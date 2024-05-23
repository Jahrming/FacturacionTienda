
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




          $strSQl="SELECT DescripcionAlmacen,movta.aud_fecha_proc aud_fecha_proc, DescripcionTipoDocumento,FactSri,movref.IdReferencia,DescripcionReferencia,".
                        "Cantidad,Precio,CostoVenta FROM movta, movref,tipodocumento ,referencias, almacenes".
                  " WHERE movta.TipDoc = tipodocumento.IdTipoDocumento and  movta.IdMov = movref.IdMov ".
                  "  and movref.IdReferencia = referencias.IdReferencia ".
                    " and  Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin'  ".
                   " AND movta.IdAlmacen = almacenes.IdAlmacen ".
                   " order by fecha ";
                    //echo $strSQl;
          $rs =  mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {

            $arreglo['DescripcionAlmacen'][]=$reg['DescripcionAlmacen'];   
            $arreglo['fecha'][]=$reg['aud_fecha_proc'];      
            $arreglo['DescripcionTipoDocumento'][]=$reg['DescripcionTipoDocumento'];      
            $arreglo['FactSri'][]=$reg['FactSri'];      
            $arreglo['IdReferencia'][]=$reg['IdReferencia'];      
            $arreglo['DescripcionReferencia'][]=$reg['DescripcionReferencia'];      
            $arreglo['Cantidad'][]=$reg['Cantidad'];      
            $arreglo['Precio'][]=$reg['Precio'];      
            $arreglo['CostoVenta'][]=$reg['CostoVenta'];      

           }
          echo json_encode($arreglo);

      }


