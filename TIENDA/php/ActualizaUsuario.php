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
        $v_IdUsuario = $_POST['IdUsuario'];
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


        $SqlUpdateUsuarios="update admusuarios set  CedulaUsuario    ='$v_CedulaUsuario',
                                                    NombresUsuario   ='$v_NombresUsuario',
                                                    ApellidosUsuario ='$v_ApellidosUsuario',
                                                    Password         ='$v_Password',
                                                    EmailUsuario     ='$v_EmailUsuario',
                                                    IdArea           =$v_IdArea,
                                                    IdTipoUsuario    =$v_IdTipoUsuario,
                                                    Telefonos        ='$v_Telefonos',
                                                    Direccion        ='$v_Direccion',
                                                    FechaNacimiento  ='$v_FechaNacimiento',
                                                    LugarNacimiento  ='$v_LugarNacimiento',
                                                    EstadoUsuario    ='$v_EstadoUsuario',
                                                    aud_usuario_proc ='$v_usuarioGraba',
                                                    aud_fecha_proc   =now() 
                                        where IdUsuario = $v_IdUsuario ";

            if ($conexion->query($SqlUpdateUsuarios)==TRUE)
            {    
                 header('Location:Mensajes.php?mensaje=Usuario grabado exitosamente&Destino=ConsultaUsuarios.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdateUsuarios."<br>".$conexion->error;
            }
            
            $conexion->close();
        }
       