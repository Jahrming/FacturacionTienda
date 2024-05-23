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
        $v_DescripcionCategoria     = $_POST['nombresubcategoria'];
        $v_EstadoCategoria          = $_POST['estadocategoria']; 

        $SqlInsert="insert into subcategorias values('0',
                                                 '$v_DescripcionCategoria',
                                                 '$v_EstadoCategoria',
                                                 '$v_usuarioGraba',
                                                  now())";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Sub Categoria grabado exitosamente&Destino=ConsultaSubCategorias.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       