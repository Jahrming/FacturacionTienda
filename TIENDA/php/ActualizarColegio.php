<?php



    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
       $xIdColegio     =   $_POST['IdInstitucion'];
       $xUsuario       =   $_SESSION["user"];

       $xDescripcionColegio  = $_POST['nombre'];
       $xContactoColegio     = $_POST['nombreContacto'];
       $xCiudad              = $_POST['Ciudad']; 
       $xDireccionColegio    = $_POST['direccion'];
       $xTelefonos           = $_POST['Telefonos'];
       $xEmail               = $_POST['email'];
       $xPorcentaje          = $_POST['porcentaje'];
       $xEstado              = $_POST['Estado'];

       $SqlUpdate="update colegios set  DescripcionColegio= '$xDescripcionColegio',
                                         ContactoColegio   = '$xContactoColegio',
                                         Ciudad            = '$xCiudad',
                                         DireccionColegio  = '$xDireccionColegio',
                                         TelefonosColegio         = '$xTelefonos',
                                         Ciudad            = '$xCiudad',
                                           Email           = '$xEmail',
                                         EstadoColegio           = '$xEstado'
                                    where IdColegio        = $xIdColegio ";

            if ($conexion->query($SqlUpdate)==TRUE)
            {

                $SqlUpdateReferenciaColegio="update referenciacolegio set  PorcentajeDescuento= '$xPorcentaje'
                                            where IdColegio        = $xIdColegio ";
                if ($conexion->query($SqlUpdateReferenciaColegio)==TRUE)
                {
                  header('Location:Mensajes.php?mensaje=Colegio actualizado exitosamente&Destino=ConsultaColegios.php' );
                }
                else
                {
                   echo "Error: ".$SqlUpdateReferenciaColegio."<br>".$conexion->error;
                }
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
        ?>
      
