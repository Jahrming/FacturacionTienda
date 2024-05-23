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
        $v_NombreMarca          = $_POST['nombremarca'];
        $v_EstadoMarca          = $_POST['estadomarca']; 

        $SqlInsert="insert into marcas values('0',
                                                 '$v_NombreMarca',
                                                 '$v_EstadoMarca',
                                                 '$v_usuarioGraba',
                                                  now())";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Marca grabado exitosamente&Destino=ConsultaMarcas.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       