<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba         = $_SESSION['user'];
        $v_turnoinicio          = $_POST['horainicio'];
        $v_turnofin          = $_POST['horafin'];
        $v_estadoturno          = $_POST['estadoturno']; 

        $SqlInsert="insert into turnos values('0',
                                                 '$v_turnoinicio',
                                                 '$v_turnofin', 
                                                 '$v_estadoturno')";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Turno grabado exitosamente&Destino=ConsultaTurnos.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       