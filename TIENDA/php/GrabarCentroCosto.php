<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba             = $_SESSION['user'];
        $v_CodigoCentroCosto        = $_POST['CodigoCentroCosto'];
        $v_DescripcionCentroCosto   = $_POST['DescripcionCentroCosto']; 
        $v_EstadoCentroCosto        = $_POST['EstadoCentroCosto'];

        $SqlInsert="insert into admcentrocosto values('0','$v_CodigoCentroCosto',
                                                                '$v_DescripcionCentroCosto',
                                                                '$v_EstadoCentroCosto')";


            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Centro Costo grabado exitosamente&Destino=ConsultaCentroCosto.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       