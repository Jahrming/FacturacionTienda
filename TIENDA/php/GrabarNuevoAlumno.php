<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
 
            $v_usuario                  = $_SESSION["user"];
            $v_Cedula                   = $_POST['Cedula'];
            $v_Apellidos                = $_POST['Apellidos'];
            $v_Nombres                  = $_POST['Nombres'];
            $v_LugarNacimiento          = $_POST['LugarNacimiento'];
            $v_FechaNacimiento          = $_POST['FechaNacimiento'];
            $v_IdRepresentante          = $_POST['IdRepresentante'];
            $v_IdParentesco             = $_POST['Parentesco'];
            $v_Sexo                     = $_POST['Sexo'];
            $v_Direccion                = $_POST['Direccion'];
            $v_Telefono                 = $_POST['TelefonoConvencional'];
            $v_TelefonoMovil            = $_POST['Celular'];
            $v_PersonaContacto          = $_POST['PersonaContacto'];
            $v_PersonaContactoTelefono  = $_POST['telefonoContacto'];
            $v_Email                    = $_POST['Email'];
            $v_Etnia                    = $_POST['Etnia'];
            $v_foto                     = '';
            $v_Enfermedad               = $_POST['Enfermedad'];
            $v_beca                     = $_POST["beca"];
            
            
            

            $SqlInsertAlumnos="insert into alumnos values(0,'$v_Cedula', 
                    '$v_Apellidos',
                    '$v_Nombres',
                    '$v_LugarNacimiento', 
                    '$v_FechaNacimiento', 
                     $v_IdRepresentante,
                     $v_IdParentesco,
                    '$v_Sexo',
                    '$v_Direccion', 
                    '$v_Telefono',  
                    '$v_TelefonoMovil',
                    '$v_PersonaContacto', 
                    '$v_PersonaContactoTelefono', 
                    '$v_Email',
                    '$v_foto',
                     $v_Etnia,
                     $v_beca,
                    '$v_Enfermedad',
                    '$v_usuario',
                     now(),
                    'A')" ;
                 

            if ($conexion->query($SqlInsertAlumnos)==TRUE)
            {    
                 header('Location:Mensajes.php?mensaje=Alumno grabado exitosamente&Destino=../inicio/menu.php' );
            }
            else
            {
                echo "Error: ".$SqlInsertAlumnos."<br>".$conexion->error; echo 'represen ' .$v_IdRepresentante;
            }
            
            $conexion->close();
        }
       