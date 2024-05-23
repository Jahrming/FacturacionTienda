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
        $IdTurno           =   $_REQUEST['IdTurno'];
     
        $SqlUpdate="update turnos set  EstadoTurno            =      'X'                            where IdTurno = $IdTurno ";

            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Turno eliminado exitosamente&Destino=ConsultaTurnos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
    