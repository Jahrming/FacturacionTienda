
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
          $strSQl="SELECT  TipDoc,DescripcionTipoDocumento Desc,Fecha, IdMov , FactSri,SubTotal , Descuento, Impuesto, ".
        //$strSQl="SELECT Fecha, IdMov , FactSri,SubTotal , Descuento, Impuesto, ".
                        " Total FROM movta ,tipodocumento ".
                    " WHERE movta.TipDoc =tipodocumento.IdTipoDocumento ".
                    " and movta.Fecha >='$xFechaInicio' AND movta.Fecha <='$xFechaFin' ORDER BY movta.Fecha "; 

          $rs =  mysqli_query($conexion,$strSQl);
          while ($reg= mysqli_fetch_assoc($rs) ) 
          {

            $arreglo['data'][]= $reg;       
           }

          echo json_encode($arreglo);

      }


