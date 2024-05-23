<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
 
            $v_IdAlumno                 = $_POST['IdAlumno'];
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
            $v_Estado                   = $_POST['Estado'];
            $v_Beca                     = $_POST['beca'];
            
            $SqlUpdateAlumnos="update alumnos set   Apellidos              = '$v_Apellidos',
                                                    Nombres                = '$v_Nombres',
                                                    LugarNacimiento        = '$v_LugarNacimiento',
                                                    FechaNacimiento        = '$v_FechaNacimiento',
                                                    IdRepresentante        = $v_IdRepresentante,
                                                    IdParentesco           = $v_IdParentesco,
                                                    Sexo                   = '$v_Sexo',
                                                    direccion1             = '$v_Direccion',
                                                    TelefonoConvencional1  = '$v_Telefono',
                                                    TelefonoMovil          = '$v_TelefonoMovil',
                                                    PersonaContacto        = '$v_PersonaContacto',
                                                    PersonaContactoTelefono= '$v_PersonaContactoTelefono',
                                                    Mail                   = '$v_Email',
                                                    idEtnia                =  $v_Etnia,
                                                    Enfermedades           = '$v_Enfermedad',
                                                    Estado                 = '$v_Estado',
                                                    IdBeca                 =  $v_Beca
                                                      where IdAlumno       =  $v_IdAlumno " ;
                    
            if ($conexion->query($SqlUpdateAlumnos)==TRUE)
            {    
                 header('Location:Mensajes.php?mensaje=Alumno grabado exitosamente&Destino=ConsultaAlumnos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdateAlumnos."<br>".$conexion->error;
            }
            
            $conexion->close();
        }
       