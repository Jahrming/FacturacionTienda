<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

       $IdMarca    = $_POST['IdMarca'];
       $DescMarca  = $_POST['nombremarca'];
       $Estado         = $_POST['estadomarca'];
       $v_usuarioGraba = $_SESSION['user'];

        $SqlUpdate="update marcas set DescripcionMarca                    =       '$DescMarca',
                                            EstadoMarca         =       '$Estado',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdMarca = $IdMarca ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Marca actualizado exitosamente&Destino=ConsultaMarcas.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       