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
            $v_IdCurso = $_POST['IdCurso'];
            
            
            
 
            $SqlUpdate="Update cursos set   IdPeriodoLectivo =$v_PeriodoLectivo,IdFormacion=$v_Formacion,
                                            IdParalelo='$v_Paralelo',EstadoCursos='$v_Estado' ".
                                    " where IdCurso =".$v_IdCurso;
           
            if ($conexion->query($SqlUpdate)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Curso actualizado exitosamente&Destino=ConsultaCursos.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       