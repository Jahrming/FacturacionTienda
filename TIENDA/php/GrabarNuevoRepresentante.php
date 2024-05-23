<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
 
            $v_usuario=$_SESSION["user"];
            $v_Cedula=$_POST['Cedula'];
            $v_Apellidos=$_POST['Apellidos'];
            $v_Nombres=$_POST['Nombres'];
            $v_Direccion=$_POST['Direccion'];
            $v_Telefonos=$_POST['Telefonos'];
            $v_Celular=$_POST['Celular'];
            $v_Email=$_POST['Email'];
            $v_Estado=$_POST['Estado'];
        

            $SqlInsertRepresentantes="insert into representantes values(0,'$v_Cedula', 
                    '$v_Apellidos','$v_Nombres','$v_Direccion', 
                    '$v_Telefonos','$v_Celular','$v_Email','$v_Estado')";
                 

            if ($conexion->query($SqlInsertRepresentantes)==TRUE)
            {    
                 header('Location:Mensajes.php?mensaje=Representante grabado exitosamente&Destino=ConsultaRepresentantes.php' );
            }
            else
            {
                echo "Error: ".$SqlInsertRepresentantes."<br>".$conexion->error;
            }
            
            $conexion->close();
        }
       