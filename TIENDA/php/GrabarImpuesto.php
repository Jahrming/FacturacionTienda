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
        $v_CodigoSRI            = $_POST['CodigoSRI'];
        $v_porcentaje             = $_POST['porcentaje'];
        $v_Estado          = $_POST['Estado']; 
        $v_DescripcionImpuesto          = $_POST['Descripcion']; 

        $SqlInsert="insert into porcentajesRetenciones (idPorcentaje,ValorPorcentaje,CodigoSRI,Descripcion,Estado) values('0',
                                                 '$v_porcentaje',
                                                 '$v_CodigoSRI',
                                                 '$v_DescripcionImpuesto',
                                                  '$v_Estado')";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Impuesto grabado exitosamente&Destino=ConsultaImpuestos.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       