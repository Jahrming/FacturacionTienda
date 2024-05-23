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
        $v_IdImpuesto            = $_POST['IdImpuesto'];
        $v_CodigoSRI            = $_POST['CodigoSRI'];
        $v_porcentaje             = $_POST['porcentaje'];
        $v_Estado          = $_POST['Estado']; 
        $v_DescripcionImpuesto          = $_POST['Descripcion']; 

        $SqlUpdate="update porcentajesRetenciones set Descripcion  = '$v_DescripcionImpuesto',".
                                   " CodigoSRI= '$v_CodigoSRI',".
                                   " ValorPorcentaje = '$v_porcentaje', ".
                                    "  Estado  =       '$v_Estado' ".
                                "where IdPorcentaje = $v_IdImpuesto ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Impuesto actualizado exitosamente&Destino=ConsultaImpuestos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       