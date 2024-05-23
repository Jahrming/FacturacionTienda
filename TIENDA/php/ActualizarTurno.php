<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
            

        $v_IdTurno     = $_POST['IdTurno'];
        $v_usuarioGraba      = $_SESSION['user'];
        $v_turnoinicio       = $_POST['horainicio'];
        $v_turnofin          = $_POST['horafin'];
        $v_estadoturno       = $_POST['estadoturno']; 
            
            
 
            $SqlUpdate="Update turnos set  HoraInicio ='$v_turnoinicio',
                                           HoraFin    ='$v_turnofin',
                                           EstadoTurno='$v_estadoturno' 
                                    where  IdTurno =$v_IdTurno";
           
            if ($conexion->query($SqlUpdate)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Turno actualizado exitosamente&Destino=ConsultaTurnos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       