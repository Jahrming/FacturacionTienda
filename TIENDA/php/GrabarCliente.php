<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba=$_SESSION['user'];

        $v_TipDoc               = $_POST['IdTipDoc'];
        $v_CedulaRuc            = $_POST['NumDoc'];
        $v_Apellidos            = $_POST['Apellidos'];
        $v_Nombres              = $_POST['Nombres']; 
        $v_NombreComercial      = $_POST['RazonSocial'];
        $v_FechaNac             = $_POST['FecNac'];
        $v_Telefonos            = $_POST['Telefonos'];
        $v_Direccion            = $_POST['Direccion'];
        $v_Ciudad               = $_POST['Ciudad'];
        $v_IdPais               = $_POST['IdPais'];
        $v_Email                = $_POST['Email'];
        $v_Estado               = $_POST['Estado'];
        if($v_NombreComercial =null)
        {
            $v_NombreComercial='';
        }
        $SqlInsert="insert into clientes values('0',
                                                '$v_TipDoc',
                                                '$v_CedulaRuc',
                                                '$v_Apellidos',
                                                '$v_Nombres',
                                                '$v_NombreComercial',
                                                '$v_FechaNac',
                                                '$v_Telefonos',
                                                '$v_Direccion',
                                                '$v_Ciudad',
                                                '$v_IdPais',
                                                '$v_Email',
                                                '$v_Estado',
                                                '$v_usuarioGraba',
                                                now())";


            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Cliente grabado exitosamente&Destino=ConsultaClientes.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       