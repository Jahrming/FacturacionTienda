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
            $v_PeriodoLectivo=$_POST['IdPeriodoLectivo'];
            $v_anioInicial=$_POST['anioInicial'];
            $v_anioFinal=$_POST['anioFinal'];
            $v_Estado = $_POST['Estado'];

            
 
            $SqlUpdate="Update periodoslectivo set   anioInicial =$v_anioInicial,anioFinal = $v_anioFinal, Estado='$v_Estado' 
                                     where IdPeriodoLectivo =".$v_PeriodoLectivo; 
           
            if ($conexion->query($SqlUpdate)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Periodos Lectivos actualizado exitosamente&Destino=ConsultaPeriodosLectivos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       