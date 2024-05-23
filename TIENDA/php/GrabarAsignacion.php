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
        $xIdCaja                = $_POST['IdCaja'];
        $xIdCajero              = $_POST['IdCajero'];
        $xIdTurno               = $_POST['IdTurno'];
        $xFechaAsignacion       = $_POST['FechaAsignacion']; 
        $xBase                  = $_POST['base'];
        $xIdAlmacen             = 1;
        $xEstado                = "A";
        $SqlInsert="insert into controlcaja values(     '0',
                                                        $xIdCaja,
                                                        $xIdTurno,
                                                        $xIdCajero,
                                                        $xIdAlmacen,
                                                        '$xFechaAsignacion',
                                                        $xBase,
                                                        '$xEstado',
                                                         now(),
                                                        '$v_usuarioGraba')";


            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Asignacion grabado exitosamente&Destino=ConsultaAsignacion.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       