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
       $IdProveedor   = $_REQUEST['IdProveedor'];

       $v_usuarioGraba         =   $_SESSION['user'];

        $SqlUpdate="update proveedores set  EstadoProveedor = 'X',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdProveedor = $IdProveedor ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Proveedor eliminado exitosamente&Destino=ConsultaProveedores.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       