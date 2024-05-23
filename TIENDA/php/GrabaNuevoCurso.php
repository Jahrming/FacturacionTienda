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
            $v_Paralelo=$_POST['IdParalelo'];
            $v_Nivel=$_POST['IdNivel'];
            $v_Estado=$_POST['Estado'];
            $v_Formacion=$_POST['IdFormacion'];
            
            
            
 
            $SqlInsertCursos="insert into cursos values(0,".$v_Formacion.",". $v_Nivel.",".$v_PeriodoLectivo.",'"
                    . $v_Paralelo."',50,50,1,'A')";
            echo $SqlInsertCursos;
            if ($conexion->query($SqlInsertCursos)==TRUE)/////
            {
                 header('Location:Mensajes.php?mensaje=Curso grabado exitosamente&Destino=ConsultaCursos.php' );
            }
            else
            {
                echo "Error: ".$SqlInsertCursos."<br>".$conexion->error;
            }
            $conexion->close();
        }
       