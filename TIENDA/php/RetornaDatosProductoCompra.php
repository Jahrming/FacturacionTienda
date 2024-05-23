

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
        $sql   ="select IdReferencia, CodigoBarra,DescripcionReferencia,IFNULL(UltimoCosto,0),CargaIva,Iva from referencias,systemprofile where IdReferencia='$v_criterio'";  
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        if($registro['IdReferencia']==null)
        {
            $sql         = "select IdReferencia, CodigoBarra,DescripcionReferencia,IFNULL(UltimoCosto,0),CargaIva,Iva from referencias,systemprofile where CodigoBarra='$v_criterio'"; 
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
      

