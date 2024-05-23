

<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
        $_usuario=$_SESSION['user'];
        $v_criterio= $_POST['Codigo'];
        $xIdAlmacen = $_SESSION['idalmacen'];
        $sql   ="select referencias.IdReferencia, CodigoBarra,DescripcionReferencia,Pvp,CargaIva,Iva,pvpfinal from referencias,systemprofile,stock where referencias.IdReferencia='$v_criterio'".
                " and referencias.idreferencia = stock.idreferencia ".
                "   and systemprofile.idempresa= $xIdAlmacen".
                "   and stock.idalmacen = systemprofile.idempresa ";

        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        if($registro['IdReferencia']==null)
        {
            $sql         = "select referencias.IdReferencia, CodigoBarra,DescripcionReferencia,Pvp,CargaIva,Iva,pvpfinal from referencias,systemprofile,stock where CodigoBarra='$v_criterio'".
                " and referencias.idreferencia = stock.idreferencia ".
                "   and systemprofile.idempresa= $xIdAlmacen".
                "   and stock.idalmacen = systemprofile.idempresa ";
            $rs2         =  mysqli_query($conexion, $sql);
            $registro2   =  mysqli_fetch_assoc($rs2); 
            if($registro2['IdReferencia']==null)
            {
                echo 0;
            }
            else
            {
                echo implode("_;_", $registro2);
            }
        }
        else
        {
            echo implode("_;_", $registro);

        }
        
 
  }
      

