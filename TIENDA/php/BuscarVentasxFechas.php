
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

          $strSQl="SELECT Fecha, SUM(SubTotal) as Subtotal, IFNULL(SUM(Descuento),0) as Descuento, SUM(Impuesto) as Impuesto, IFNULL(SUM(Total),0) as Total FROM movta ".
                    " WHERE Fecha >='$xFechaInicio' AND Fecha <='$xFechaFin' GROUP BY Fecha "; 
          $rs =  mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {

            $arreglo['data'][]= $reg;       
           }

          echo json_encode($arreglo);

      }


