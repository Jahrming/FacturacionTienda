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
        $v_Nombrebanco         = $_POST['nombrebanco'];
        $v_Estadobanco         = $_POST['estadobanco']; 
        $v_idbanco              = 0;
        $sqlConsulta="select max(IdBanco) maxbanco from bancos ";
        $ResultSet=  mysqli_query($conexion, $sqlConsulta);
        $reg = mysqli_fetch_assoc($ResultSet);
        $v_idbanco = $reg["maxbanco"]+1;

        $SqlInsert="insert into bancos values($v_idbanco,
                                                 '$v_Nombrebanco',
                                                 '$v_Estadobanco')";

            if ($conexion->query($SqlInsert)==TRUE)
            {
               header('Location:Mensajes.php?mensaje=banco grabado exitosamente&Destino=ConsultaBancos.php' );
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       