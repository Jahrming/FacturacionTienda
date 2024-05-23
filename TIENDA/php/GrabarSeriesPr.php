<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
       // include('generaXML.php');
        #---- Datos del sistema --------------------------#
        $xUsuario         = $_SESSION['user'];    
        $xIdAlmacen       = $_SESSION['idalmacen'];
        $xSeries          = $_POST['NumerosSerie'];
        $xCodigoItem      = $_POST['CodigoItem'];
        $xCantFilas       = $_POST['Cantidad'];
        $xIdCaja          = 1;
        $i                = 0;
        $flagError        = '';
        $msgError ='';
        echo $xCantFilas;

        for($i=0;$i<$xCantFilas;$i++)
        {
          echo $i;
          $sqlInsertSN="INSERT INTO tmp_numeros_serie_co VALUES($xIdAlmacen,$xIdCaja,'$xUsuario',$xCodigoItem,'$xSeries[$i]')";
          echo  $sqlInsertSN;

                  
                if($conexion->query($sqlInsertSN)==TRUE)
                    {
                    }   
                else
                    {
                      $flagError=1;
                      $msgError.= "Error al grabar numeros de serie: .<br> ".$sqlInsertSN.'--'.$conexion->error;
                    }
        }

        if($flagError==1)
        {
           $conexion->rollback();
        }
        echo $msgError;
    }
  
    
