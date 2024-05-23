<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
 

            $v_IdRepresentante=$_POST['IdRepresentante'];
            $v_Cedula=$_POST['Cedula'];
            $v_Apellidos=$_POST['Apellidos'];
            $v_Nombres=$_POST['Nombres'];
            $v_Direccion=$_POST['Direccion'];
            $v_Telefonos=$_POST['Telefonos'];
            $v_Celular=$_POST['Celular'];
            $v_Email=$_POST['Email'];
            $v_Estado=$_POST['Estado'];
            
            $SqlUpdate="update representantes set apellidos='".$v_Apellidos."'," .
                                                   " nombres='" .$v_Nombres."'," .
                                                   " direccion='" . $v_Direccion."'," .
                                                   " telefonos='" .$v_Telefonos."'," .
                                                   " celular='"  .$v_Celular."'," .
                                                   " estado='"  .$v_Estado."'," .
                                                   " mail='" .$v_Email."'".
                                                   " where IdRepresentante=".$v_IdRepresentante;

                    
            if ($conexion->query($SqlUpdate)==TRUE)
            {    
                 header('Location:Mensajes.php?mensaje=Representante actualizado exitosamente&Destino=ConsultaRepresentantes.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            
            $conexion->close();
        }
       