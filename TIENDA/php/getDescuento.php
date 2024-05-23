

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
        //*********************************
        // Obtener periodo lectivo
        //*********************************
        //$sql="SELECT * from systemprofile ";
        //$rs       =  mysqli_query($conexion, $sql);
        //$registro =  mysqli_fetch_assoc($rs); 
        //$periodoLectivo = $registro['PeriodoLectivoActual'];
        /*********************************        
        *   Obtener IdRegistroMatricula
        *********************************/
        $descuento=0;
        $v_criterio= $_POST['IdColegio'];
        if($v_criterio==null){
            $v_criterio=0;
        }
        $sql       ="select * from referenciacolegio where IdColegio= ".$v_criterio." and EstadoReferencia='A'";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        $descuento=  $registro['PorcentajeDescuento'];
        if($descuento==null)
        {
            $descuento=0;
        }
        
        
 
      }
      echo $descuento;
      

