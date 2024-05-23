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
        $v_DescripcionEditorial     = $_POST['nombreeditorial'];
        $v_EstadoEditorial          = $_POST['Estado']; 

        $SqlInsert="insert into editorial values('0',
                                                 '$v_DescripcionEditorial',
                                                 '$v_EstadoEditorial',
                                                 '$v_usuarioGraba',
                                                  now())";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Editorial grabado exitosamente&Destino=ConsultaEditoriales.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       