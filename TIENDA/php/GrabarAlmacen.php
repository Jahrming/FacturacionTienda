<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba          = $_SESSION['user'];
        $v_NombreAlmacen         = $_POST['NombreAlmacen'];
        $v_IdPunto               = $_POST['IdPunto']; 
        $v_Direccion             = $_POST['Direccion']; 
         $v_Telefonos            = $_POST['Telefonos']; 
         $v_estado               = $_POST['Estado'];

        $SqlInsert="insert into almacenes values('0',
                                                 '$v_NombreAlmacen',
                                                 '$v_IdPunto',
                                                 '$v_Direccion',
                                                '$v_Telefonos',
                                                 '$v_estado',
                                                 '$v_usuarioGraba',
                                                  now())";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Autor grabado exitosamente&Destino=ConsultaAlmacenes.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       