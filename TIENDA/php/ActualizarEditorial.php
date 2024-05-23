<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

       $IdEditorial    = $_POST['IdEditorial'];
       $DescEditorial  = $_POST['nombreeditorial'];
     //  $Estado         = $_POST['Estado'];
       $v_usuarioGraba = $_SESSION['user'];
        #       EstadoEditorial         =       '$Estado',
        $SqlUpdate="update editorial set DescripcionEditorial                    =       '$DescEditorial',
                                     
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdEditorial = $IdEditorial ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Editorial actualizado exitosamente&Destino=ConsultaEditoriales.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       