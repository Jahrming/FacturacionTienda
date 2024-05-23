<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
       $xIdCliente     =   $_REQUEST['IdCliente'];
       $xUsuario       =   $_SESSION["user"];


        $SqlUpdate="update clientes set  Estado = 'X'
                                         aud_usuario_proc     = '$xUsuario',
                                         aud_fecha_proc       = now()
                                where IdCliente = $xIdCliente ";


            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Cliente eliminado exitosamente&Destino=ConsultaClientes.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       