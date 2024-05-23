<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       ###############################################################################
       #Obtener datos de las Etnia                                                   #
       ###############################################################################
       $sql="select * from  precios";
       $rs = mysqli_query($conexion,$sql);
       while($reg =mysqli_fetch_array($rs))
       {
          $sql="update referencias set Pvp=".$reg['PVP']." where Isbn='".$reg['ISBN']."'";
          echo $sql;
          mysqli_query($conexion,$sql);
          echo ' graba exitosamete ';
       }


    }