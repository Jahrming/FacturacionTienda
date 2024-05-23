<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

       $IdAutor    = $_POST['IdAutor'];
       $DescAutor  = $_POST['nombreautor'];
       $Estado         = $_POST['EstadoAutor'];
       $v_usuarioGraba = $_SESSION['user'];

        $SqlUpdate="update autores set DescripcionAutor                    =       '$DescAutor',
                                            EstadoAutor         =       '$Estado',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdAutor = $IdAutor ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Autor actualizado exitosamente&Destino=ConsultaAutores.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       