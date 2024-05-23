


 <!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<?php
   $Servidor="localhost";
   $Base_Datos="importbooks";
   $usuario="xsaltos";
   $clave = "d3v3cua";
   $flagError=0;

   $conexion = new mysqli($Servidor,$usuario,$clave);
   mysqli_select_db($conexion,$Base_Datos);
    if(!$conexion)
    {

       die('Error en la comunicación con la base de datos');
   }
   else  {
    
       $conexion->autocommit(FALSE);
       $nombreusuario ="usuario345";
       $sql="select count(*) as cantidad from usuarios";
       
       $rs= mysqli_query($conexion,$sql);
       $reg=mysqli_fetch_assoc($rs);
       echo 'numero de usuarios antes de insertar '.$reg["cantidad"];
       $sqlinsert="insert into usuarios values(0,'$nombreusuario')";
       if($conexion->query($sqlinsert)==true)
       {
          echo 'graba usuarios sin problema';

          $sql="select count(*) as cantidad from usuarios";
       
          $rs1= mysqli_query($conexion,$sql);
          $reg1=mysqli_fetch_assoc($rs1);
          echo 'numero de usuarios despues de insertar '.$reg1["cantidad"];
       }
       else
       {
          $flagError=1;
          echo "Error al grabar usuarios: .<br>".$conexion->error;
       } 

       $sqlinsert="insert into customer values('USUARIO6')";
       //$rs= mysqli_query($conexion,$sqlInsert);
       if($conexion->query($sqlinsert)==true)
       {
          echo 'graba customer sin problema';
          
       }
       else
       {
         $flagError=1;
          echo "Error al grabar customer: .<br>".$conexion->error;
          
       } 
       if($flagError==0)
       {
        echo 'terminada correctamente';
        $conexion->commit();
       }
       else
       {
        $conexion->rollback();
        echo 'se reverso todo';
       }
      
          $sql="select count(*) as cantidad from usuarios";
       
          $rs2= mysqli_query($conexion,$sql);
          $reg2=mysqli_fetch_assoc($rs2);
          echo 'numero de usuarios al terminar  '.$reg2["cantidad"];
       
    }
    mysqli_close($conexion);
 ?>
       
</body>
</html>