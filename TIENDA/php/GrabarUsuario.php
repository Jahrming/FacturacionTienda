<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba=$_SESSION['user'];
        $v_UserName=$_POST['Usuario'];
        $v_CedulaUsuario=$_POST['Cedula'];
        $v_NombresUsuario= $_POST['Nombres'];
        $v_ApellidosUsuario= $_POST['Apellidos']; 
        $v_Password=$_POST['Clave'];
        $v_EmailUsuario=$_POST['email'];
        $v_IdArea=$_POST['cc'];
        $v_IdTipoUsuario=$_POST['TipoRol'];
        $v_Telefonos=$_POST['Telefonos'];
        $v_Direccion=$_POST['Direccion'];
        $v_FechaNacimiento=$_POST['fechaNac'];
        $v_LugarNacimiento=$_POST['LugarNacimiento'];
        $v_EstadoUsuario=$_POST['Estado'];

        $SqlInsert="insert into admusuarios values('0','$v_UserName',
                                                                '$v_CedulaUsuario',
                                                                '$v_NombresUsuario',
                                                                '$v_ApellidosUsuario',
                                                                '$v_Password',
                                                                '$v_EmailUsuario',
                                                                $v_IdArea,
                                                                $v_IdTipoUsuario,
                                                                '$v_Telefonos',
                                                                '$v_Direccion',
                                                                '$v_FechaNacimiento',
                                                                '$v_LugarNacimiento',
                                                                '$v_EstadoUsuario',
                                                                '$v_usuarioGraba',
                                                                now())";


            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Usuario grabado exitosamente&Destino=ConsultaUsuarios.php' );
            }
            else
            {
                echo "Error: ".$SqlInsertUsuario."<br>".$conexion->error;
            }
            $conexion->close();
        }
       