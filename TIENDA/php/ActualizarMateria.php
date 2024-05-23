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
            //$v_idNivel =  $_POST['IdNivel'];
            //$v_codigoMateria=$_POST['CodigoMateria'];
            $v_idMateria = $_POST['idmateria'];
            $v_nombreMateria=$_POST['NombreMateria'];
            $v_horasMateria=$_POST['HorasMaterias'];
            $v_Creditos=$_POST['Creditos'];
            $v_Estado=$_POST['Estado'];

            $SqlUpdate="update materias set  MateriaDescripcion ='$v_nombreMateria',
                                                MateriasHoras  = $v_horasMateria,
                                                MateriaCredito = $v_Creditos,
                                                MateriaEstado  ='$v_Estado'
                                                WHERE idMaterias =".$v_idMateria;


            if ($conexion->query($SqlUpdate)==TRUE)/////
            {
                 header('Location:Mensajes.php?mensaje=Materia actualizada exitosamente&Destino=ConsultaMaterias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       