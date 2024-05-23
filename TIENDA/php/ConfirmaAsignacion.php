

<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
        
        $_usuario= $_SESSION['user'];
        $xusuario= $_POST['Usuario'];
        $retorno=0;

        $sql="select * from admusuarios where UserName ='$xusuario'";
        $rsUsuario=mysqli_query($conexion,$sql);
        $regUsuario=mysqli_fetch_assoc($rsUsuario);
        $xIdUsuario= $regUsuario['IdUsuario'];
        $xUserName = $regUsuario['UserNmae'];
        //echo $sql;
        #---- comprueba ----------------------
        $sql2="select * from controlcaja where IdCajero=$xIdUsuario and EstadoAsignacion='A'";
        $rs2=mysqli_query($conexion,$sql2);
        $regControl=mysqli_fetch_assoc($rs2);
        //$xregIdUsuario=$regControl['IdCajero'];
        //echo $sql2;
        if($regControl['IdCajero']==null)
        {
           echo 0;
        }
        else
        {
           echo 1;
        }         
  }
