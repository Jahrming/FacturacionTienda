<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
            


           $v_IdNivel     = $_POST['IdNivel'];
           $v_DescNivel   = $_POST['DescripcionNivel'];
           $v_Matricula   = $_POST['ValorMatricula'];
           $v_Pension     = $_POST['ValorPension'];
           $v_Estado      = $_POST['Estado'];           
            
            
 
            $SqlUpdate="Update niveles set  NivelDescripcion ='$v_DescNivel',
                                            ValorMatricula=$v_Matricula,
                                            ValorPension=$v_Pension,
                                            Estado='$v_Estado' 
                                     where  IdNivel =".$v_IdNivel;
           
            if ($conexion->query($SqlUpdate)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=Nivel actualizado exitosamente&Destino=ConsultaNiveles.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
       