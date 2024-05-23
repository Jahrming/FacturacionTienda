<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
       $rs        = mysqli_query($conexion,$sql);
       $reg       = mysqli_fetch_assoc($rs);
       $IdSubCategoria   = $_REQUEST['IdSubCategoria'];

       $v_usuarioGraba         =   $_SESSION['user'];

        $SqlUpdate="update subcategorias set  EstadoSubCategoria = 'X',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdSubCategoria = $IdSubCategoria ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=SubCategoria eliminado exitosamente&Destino=ConsultaSubCategorias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       