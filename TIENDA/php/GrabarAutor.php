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
        $v_NombreAutor          = $_POST['nombreautor'];
        $v_EstadoAutor          = $_POST['EstadoAutor']; 

        $SqlInsert="insert into autores values('0',
                                                 '$v_NombreAutor',
                                                 '$v_EstadoAutor',
                                                 '$v_usuarioGraba',
                                                  now())";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Autor grabado exitosamente&Destino=ConsultaAutores.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       