<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");

        $v_usuarioGraba            = $_SESSION['user'];
        $IdNivel                   = $_POST['Nivel'];
        $Prefijo                   = $_POST['prefijo'];
        $CuentaContable            = $Prefijo.$_POST['NumeroCuenta'];
        $CodigoTipoCuenta          = $_POST['TipoCuenta'];
        $CuentaDetalle             = $_POST['rs'];
        $Imputable                 = $CuentaDetalle;
        $DescripcionCuentaContable = $_POST['NombreCuentaContable'];
        $Anio                   = $_POST['anio'];
        $Saldo                  = 0;
        $Estado                 = 'A';
        $UsuarioIngreso         = $v_usuarioGraba;
        $CuentaContablePadre    = $Prefijo;


        $SqlInsert="insert into conplancuentas values(  '1',
                                                        '$IdNivel',
                                                        '$CuentaContable',
                                                        '$CodigoTipoCuenta',
                                                        '$Imputable',
                                                        '$CuentaDetalle',
                                                        '$DescripcionCuentaContable',
                                                        '$Anio',
                                                        '$Saldo',
                                                         '$Estado',            
                                                         now(),       
                                                         '$UsuarioIngreso' ,
                                                         null,  
                                                         null,  
                                                         '$CuentaContablePadre')";  
                                                       
echo $SqlInsert; 


            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Cuenta Contable grabada exitosamente&Destino=ConsultaPlanCuentas.php' );
            }
            else
            {
                echo "Error: ".$SqlInsertUsuario."<br>".$conexion->error;
            }
            $conexion->close();
        }
       