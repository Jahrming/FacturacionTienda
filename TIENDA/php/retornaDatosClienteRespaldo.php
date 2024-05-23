


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
        $v_criterio= $_POST['CedulaCliente'];
        $sql   ="select IdCliente as Id,CedulaRUC as Ruc,concat(Apellidos,' ',Nombres) as Nombres,Telefonos as Telefono from clientes where CedulaRuc='$v_criterio'";  
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        if($registro['Id']==null)
        {
                echo 0;
        }
        else
        {
            echo implode("_;_", $registro);
        }
        
 
  }
      

