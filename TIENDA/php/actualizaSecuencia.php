
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
       $x_idAlmacen   = $_POST['IdAlmacen'];
       $x_IdTipDoc    = $_POST['IdTipoDoc'];
       $x_Secuencial  = $_POST['Secuencial'];

       $strsql="UPDATE srisecuencial SET SecuencialSRI=$x_Secuencial ".
               " WHERE IdTipoDocumento= $x_IdTipDoc".
               "   AND IdAlmacen =$x_idAlmacen ";

            if ($conexion->query($strsql)==TRUE)
            {
               echo 'Secuencial de Documento actualizado exitosamente';
            }
            else
            {
                echo "Error: ".$strsql."<br>".$conexion->error;
            }



      }

