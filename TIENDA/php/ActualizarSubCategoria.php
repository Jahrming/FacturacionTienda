<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

       $IdSubCategoria    = $_POST['IdSubCategoria'];
       $DescSubCategoria  = $_POST['nombresubcategoria'];
       $Estado         = $_POST['estadosubcategoria'];
       $v_usuarioGraba = $_SESSION['user'];

        $SqlUpdate="update subcategorias set DescripcionSubCategoria                    =       '$DescSubCategoria',
                                            EstadoSubCategoria         =       '$Estado',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdSubCategoria = $IdSubCategoria ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Sub Categoria actualizado exitosamente&Destino=ConsultaSubCategorias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       