<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
            $v_usuario=$_SESSION['user'];
            $v_ClaveActual=$_POST['claveactual'];
            $v_ClaveNueva=$_POST['clavenueva'];
            $v_ClaveConfirma=$_POST['confirmaclave'];
            
       $SqlDatosUsuario="Select * from admusuarios where UserName='$v_usuario'";

      
       $ResultSet=  mysqli_query($conexion,$SqlDatosUsuario);
       $reg_usuario=mysqli_fetch_assoc($ResultSet);
       $v_clave=  $reg_usuario['Password'];
       if ($v_clave ==$v_ClaveActual)
       {
            if($v_ClaveNueva ==$v_ClaveConfirma)
            {
                 $SqlUpdateClave="update admusuarios set Password='".$v_ClaveNueva."' ".
                                                            " WHERE UserName ='".$v_usuario."'";
                 if ($conexion->query($SqlUpdateClave)==TRUE)
                 {
                      header('Location:Mensajes.php?mensaje=Clave actualizado exitosamente&Destino=../inicio/menu.php' );
                 }
                 else
                 {
                     echo "Error: ".$SqlUpdateClave."<br>".$conexion->error;
                 }           
             }
              // header('Location:Mensajes.php?mensaje=Contraseñas ingresadas no coinciden&Destino=CambiarClave.php' );
            else
            {  header('Location:Mensajes.php?mensaje=Claves no coinciden&Destino=CambiarClave.php' );
            }           
           
           
           
           
       }
           else // header('Location:Mensajes.php?mensaje=Clave ingresada no es la correcta&Destino=CambiarClave.php' );
       {
           header('Location:Mensajes.php?mensaje=Clave ingresada no es la correcta&Destino=CambiarClave.php' );
       }

            

            $conexion->close();
        }
       