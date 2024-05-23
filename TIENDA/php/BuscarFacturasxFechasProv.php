
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
          $strSQl="SELECT  Fecha,FactSri, IdMov , SubTotal , Descuento, Impuesto, IFNULL(Total,0) as Total FROM movta ".
                    " WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' ORDER BY IdMov, Fecha "; 
          $rs = mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {
            $arreglo['Fecha'][]= $reg['Fecha'];
            $arreglo['FactSri'][]= $reg['FactSri'];
            $arreglo['IdMov'][]= $reg['IdMov'];            
            $arreglo['SubTotal'][]= $reg['SubTotal'];
            $arreglo['Descuento'][]= $reg['Descuento'];
            $arreglo['Impuesto'][]= $reg['Impuesto'];      
            $arreglo['Total'][]= $reg['Total'];              
          }
          echo json_encode($arreglo);

      }


