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
       $IdProveedor   = $_POST['IdProveedor'];
       $ruc           = $_POST['ruc'];
       $DescProveedor = $_POST['nombre'];
       $Direccion     = $_POST['direccion'];
       $IdCiudad      = $_POST['ciudad'];
       $Email         = $_POST['email'];
       $Telefonos     = $_POST['Telefonos'];
       $Estado        = $_POST['Estado'];
       $v_usuarioGraba         =   $_SESSION['user'];

        $SqlUpdate="update proveedores set  RUC                     =       '$ruc',
                                            DescripcionProveedor    =       '$DescProveedor',
                                            Direccion               =       '$Direccion',
                                            IdCiudad                =        $IdCiudad,
                                            Email                   =       '$Email',
                                            Telefonos               =       '$Telefonos',
                                            EstadoProveedor         =       '$Estado',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now()
                                where IdProveedor = $IdProveedor ";



            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Proveedor actualizado exitosamente&Destino=ConsultaProveedores.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       