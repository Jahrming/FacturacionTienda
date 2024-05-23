<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
        $_usuario=$_SESSION['user'];
        $xIdPorcentaje= $_POST['IdPorcentaje'];
        $sql   ="SELECT * FROM porcentajesRetenciones ".
               " WHERE IdPorcentaje = ".$xIdPorcentaje;
        $rs   = mysqli_query($conexion, $sql);
        $row  = mysqli_fetch_assoc($rs);
        echo implode("_;_", $row);
           // echo $sql;
    }


