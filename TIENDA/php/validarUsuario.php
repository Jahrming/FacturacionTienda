<?php
  session_start();

  $_usuario=$_POST['usuario'];
  $_clave= $_POST['inputPassword'];
  $_idalmacen = $_POST['almacen'];
  $_SESSION['idalmacen']=$_idalmacen;
  include('Conexion.php');
  if($_usuario!='' && $_clave!='')
  { 
   


      $_SESSION["user"]= $_usuario;  
      $StrSql="select * from admusuarios ".
              " where UserName='".$_usuario."'".
              " and Password='".$_clave."'";

      $ResultSet= mysqli_query($conexion,$StrSql);
      $nreg= mysqli_num_rows($ResultSet);
      if ($nreg>0)
      {  
       // echo 'fweewewf'. $GLOBALS['ID_ALMACEN'];
        echo '<script>location.href="../inicio/menu.php" </script>';
      }      
      //echo 'vali tripa';
 } /*      else
         header('Location:Mensajes.php?mensaje=Usuario o password incorrecto&Destino=../index.html' );
      mysqli_free_result($ResultSet);
      mysqli_close($conexion);**/
  

   //   header("location:../index.html");
  