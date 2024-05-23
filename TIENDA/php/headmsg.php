<?php 
   include("Conexion.php"); 
   $x_Usuario = $_SESSION['user'];
   //$x_Sistema = $_SESSION['sistema'];
   $x_IdAlmacen = $_SESSION['idalmacen'];
   $strSQL="select * from systemprofile, almacenes where IdEmpresa= $x_IdAlmacen";
   $rs = mysqli_query($conexion,$strSQL);
   $regProfile = mysqli_fetch_assoc($rs);
   $x_Empresa = $regProfile['NombreEmpresa'];
   $x_nombreAlmacen = $regProfile['DescripcionAlmacen'];
   #-----------usuarios---------------------
   $strSQL="select * from admusuarios where UserName= '$x_Usuario'";
   $rs = mysqli_query($conexion,$strSQL);
   $regUsuario = mysqli_fetch_assoc($rs);
   $x_NombreUsuario = $regUsuario['NombresUsuario'].' '.$regUsuario['ApellidosUsuario'];   
 ?>

               
   <div style="width:50%;font-size: 11px;color:#B40431;">
        <?php echo 'System ATICUS 1.0 - '.$x_Empresa.' '.' Almacen : '.$x_nombreAlmacen.' - '.$x_Usuario.' - '.$x_NombreUsuario ; ?>
   </div>   