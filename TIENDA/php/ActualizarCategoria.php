<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

       $IdCategoria    = $_POST['IdCategoria'];
       $DescCategoria  = $_POST['nombrecategoria'];
       $Estado         = $_POST['estadocategoria'];
       $v_usuarioGraba = $_SESSION['user'];

        $SqlUpdate="update categorias set DescripcionCategoria                    =       '$DescCategoria',
                                            EstadoCategoria         =       '$Estado',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdCategoria = $IdCategoria ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Categoria actualizado exitosamente&Destino=ConsultaCategorias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       