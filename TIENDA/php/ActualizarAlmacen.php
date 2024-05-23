<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $IdAlmacen               = $_POST['IdAlmacen'];
        $v_usuarioGraba          = $_SESSION['user'];
        $v_NombreAlmacen         = $_POST['NombreAlmacen'];
        $v_IdPunto               = $_POST['IdPunto']; 
        $v_Direccion             = $_POST['Direccion']; 
        $v_Telefonos            = $_POST['Telefonos']; 
        $v_estado               = $_POST['Estado'];

        $SqlUpdate="update almacenes set      DescripcionAlmacen=     '$v_NombreAlmacen',
                                            IdPunto           =     '$v_IdPunto',
                                            DireccionAlmacen  =     '$v_Direccion',
                                            TelefonosAlmacen  =     '$v_Telefonos',
                                            EstadoAlmacen     =     '$v_estado',
                                            aud_usuario_proc  =     '$v_usuarioGraba',
                                            aud_fecha_proc    =      now()
                                where IdAlmacen  = $IdAlmacen ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Autor actualizado exitosamente&Destino=ConsultaAlmacenes.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       