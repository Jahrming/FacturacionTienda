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
        $IdReferencia           =   $_POST['IdProducto'];
          
        $SqlUpdate="update referencias set  IdReferencia             =      'X'                            where IdReferencia = $IdReferencia 
        aud_usuario_proc        =       '$v_usuarioGraba',
        aud_fecha_proc          =        now() ";


            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Producto eliminado exitosamente&Destino=ConsultaReferencias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
    