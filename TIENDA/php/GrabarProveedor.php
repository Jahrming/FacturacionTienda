<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba         = $_SESSION['user'];
        $v_RUC                  = $_POST['ruc'];
        $v_DescripcionProveedor = $_POST['nombre'];
        $v_Direccion            = $_POST['direccion'];
        $v_IdCiudad             = $_POST['ciudad']; 
        $v_Email                = $_POST['email'];
        $v_Telefonos            = $_POST['Telefonos'];
        $v_EstadoProveedor      = $_POST['Estado'];

        $sqlVerifica="select * from proveedores where RUC= '$v_RUC'";
        $rs         = mysqli_query($conexion,$sqlVerifica);
        $sqlNumReg  = mysqli_num_rows($rs);
        if ($sqlNumReg > 0) 
        {
            $regProv= mysqli_fetch_assoc($rs);
            header('Location:Mensajes.php?mensaje=RUC '.$regProv['RUC'].'-'.$regProv['DescripcionProveedor'].' ya existe ingresado&Destino=ConsultaProveedores.php' );
        }
        else
        {
                $SqlInsert="insert into proveedores values(     '0',
                                                                '$v_RUC',
                                                                '$v_DescripcionProveedor',
                                                                '$v_Direccion',
                                                                 $v_IdCiudad,
                                                                '$v_Email',
                                                                '$v_Telefonos',
                                                                '$v_EstadoProveedor',
                                                                '$v_usuarioGraba',
                                                                 now())";


                    if ($conexion->query($SqlInsert)==TRUE)
                    {
                       header('Location:Mensajes.php?mensaje=Usuario grabado exitosamente&Destino=ConsultaProveedores.php' );
                    }
                    else
                    {
                        echo "Error: ".$SqlInsertUsuario."<br>".$conexion->error;
                    }
                    $conexion->close();
        }
     }
       