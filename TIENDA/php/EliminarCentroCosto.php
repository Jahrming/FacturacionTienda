<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

        $x_usuario = $_SESSION['user'];
        $x_IdCentroCosto = $_REQUEST['IdCentroCosto'];

        $SqlUpdate="update admcentrocosto set EstadoCentroCosto = 'X' 
                        where IdCentroCosto = $x_IdCentroCosto ";




            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Centro Costo Eliminado exitosamente&Destino=ConsultaCentroCosto.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       