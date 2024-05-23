<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("conexion.php");
            $v_usuarioGraba=$_SESSION['user'];
            $v_anioInicial=$_POST['anioInicial'];
            $v_anioFinal=$_POST['anioFinal'];
            $v_Estado=$_POST['Estado'];

            $SqlInsert="insert into periodoslectivo values(0,$v_anioInicial,$v_anioFinal,'$v_Estado')";
         
            echo $SqlInsert;
            if ($conexion->query($SqlInsert)==TRUE)/////
            {
                 header('Location:Mensajes.php?mensaje=Periodo Lectivo grabado exitosamente&Destino=ConsultaPeriodoslectivos.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       