gr<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba         =   $_SESSION['user'];
        $IdUsuario           =   $_REQUEST['IdUsuario'];
          
        $SqlUpdate="update admusuarios set  EstadoUsuario             =      'X'  ,                         
        aud_usuario_proc        =       '$v_usuarioGraba',
        aud_fecha_proc          =        now()  where IdUsuario = $IdUsuario  ";


            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Usuario eliminado exitosamente&Destino=ConsultaUsuarios.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
    