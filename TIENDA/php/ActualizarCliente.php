<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
       $xIdCliente     =   $_REQUEST['IdCliente'];
       $xUsuario       =   $_SESSION["user"];
       $xTipDoc               = $_POST['IdTipoDocumento'];
       $xCedulaRuc            = $_POST['CedulaRUC'];
       $xApellidos            = $_POST['Apellidos'];
       $xNombres              = $_POST['Nombres']; 
       $xNombreComercial      = $_POST['RazonSocial'];
       $xFechaNac             = $_POST['FecNac'];
       $xTelefonos            = $_POST['Telefonos'];
       $xDireccion            = $_POST['Direccion'];
       $xCiudad               = $_POST['Ciudad'];
       $xIdPais               = $_POST['IdPais'];
       $xEmail                = $_POST['Email'];
       $xEstado               = $_POST['Estado'];

        $SqlUpdate="update clientes set  Apellidos            = '$xApellidos',
                                         Nombres              = '$xNombres',
                                         NombreComercial      = '$xNombreComercial',
                                         FechaNacimiento      = '$xFechaNac',
                                         Telefonos            = '$xTelefonos',
                                         Direccion            = '$xDireccion',
                                         Ciudad               = '$xCiudad',
                                         Pais                 = $xIdPais,
                                         Email                = '$xEmail',
                                         aud_usuario_proc     = '$xUsuario',
                                         aud_fecha_proc       = now()
                                where IdCliente = $xIdCliente ";


            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Cliente actualizado exitosamente&Destino=ConsultaClientes.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       