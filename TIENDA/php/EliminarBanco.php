<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

       $IdBanco    = $_REQUEST['IdBanco'];
       $v_usuarioGraba = $_SESSION['user'];

        $SqlUpdate="update bancos set   EstadoBanco         =       'X'
                                where IdBanco = $IdBanco ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Banco eliminado exitosamente&Destino=ConsultaBancos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       