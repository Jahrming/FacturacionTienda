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
        $v_NombreHabilidad          = $_POST['descripcionSkill'];
        $v_EstadoHabilidad          = $_POST['IdStatus']; 

        $SqlInsert="insert into ADM_HABILIDADES(DESCRIPCION_HABILIDAD,CREATE_AT,USER_CREATED,STATUS_HABILIDAD) 
                        values(           '$v_NombreHabilidad',    now(),'$v_usuarioGraba','$v_EstadoHabilidad')";
                              
            if ($conexion->query($SqlInsert)==TRUE)
            {
                
               header('Location:Mensajes.php?mensaje=Succesfull add Skill&Destino=../inicio/skills.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       