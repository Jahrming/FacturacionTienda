<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $xUsuarioGraba          = $_SESSION['user'];
        $xNombreColegio         = $_POST['nombre'];
        $xNombreContacto        = $_POST['nombreContacto'];
        $xDireccion             = $_POST['direccion'];
        $xCiudad                = $_POST['Ciudad']; 
        $xTelefonos             = $_POST['Telefonos'];
        $xEmail                 = $_POST['email'];
        $xPorcentaje            = $_POST['porcentaje'];
        if (is_null($xPorcentaje))
        {
            $xPorcentaje=0;
        }
        $SqlInsert="insert into colegios values('0','$xNombreColegio','$xNombreContacto',
                                                '$xCiudad','$xDireccion','$xTelefonos','$xEmail','A')";
                                                echo $SqlInsert;
            if ($conexion->query($SqlInsert)==TRUE)
            {
               $lastColegio=$conexion->insert_id;
               $SqlInsertRefe= "INSERT INTO referenciacolegio VALUES($lastColegio,$xPorcentaje,'A')";
               if ($conexion->query($SqlInsertRefe)==TRUE)
               {
                  header('Location:Mensajes.php?mensaje=Colegio grabado exitosamente&Destino=ConsultaColegios.php' );
                }
                else
                {
                     echo "Error: ".$SqlInsertRefeniacolegio."<br>".$conexion->error;
                }
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       