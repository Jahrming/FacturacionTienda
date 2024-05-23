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
        $v_IdAlmacen            = $_POST['IdAlmacen'];
        $v_DescCaja             = $_POST['DescripcionCaja'];
        $v_EstadoCaja          = $_POST['EstadoCaja']; 

        $SqlInsert="insert into cajas values($v_IdAlmacen,'0',
                                                 '$v_DescCaja',
                                                 '$v_EstadoCaja')";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Caja grabado exitosamente&Destino=ConsultaCajas.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       