<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        
       $IdCentroCosto    = $_POST['IdCentroCosto'];
       $Codificacion     = $_POST['CodigoCentroCosto'];
       $DescCentroCosto  = $_POST['DescripcionCentroCosto'];
       $Estado         = $_POST['EstadoCentroCosto'];
       $v_usuarioGraba = $_SESSION['user'];

        $SqlUpdate="update admcentrocosto set   CodificacionCentroCosto   = '$Codificacion' ,
                                                DescripcionCentroCosto    = '$DescCentroCosto',
                                                EstadoCentroCosto         = '$Estado'
                                where IdCentroCosto = $IdCentroCosto ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Centro Costo actualizado exitosamente&Destino=ConsultaCentroCosto.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       