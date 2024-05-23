<!DOCTYPE html>
<html>
<head>
<title>

</title>
</head>
<body>
<?php

   $Servidor="localhost";
   $Base_Datos="importbooks";
   $usuario="xsaltos";
   $clave = "d3v3cua";

   $conexion = new mysqli($Servidor,$usuario,$clave);
   mysqli_select_db($conexion,$Base_Datos);
    if(!$conexion)
    {

       die('Error en la comunicación con la base de datos');
    }

    $j=0;
    $sql = 'select * from referencias ';
    $rs  = mysqli_query($conexion,$sql);

    while($reg = mysqli_fetch_array($rs))
    {
          echo 'Procesando';echo '<br>';
          echo $reg['IdReferencia'];echo '<br>';
      $sql2="select * from stock where IdReferencia = ".$reg['IdReferencia'];
      echo $sql2;
      $rs2 = mysqli_query($conexion,$sql2);
      $reg2 = mysqli_fetch_assoc($rs2);
      echo $reg2['IdReferencia'];
      if($reg2['IdReferencia']==null)
      {
        $sqlInsert="insert into stock values(1,1,".$reg['IdReferencia'].",0)";
        $resultado=mysqli_query($conexion,$sqlInsert);
        echo "Grabado en stock ".$reg['IdReferencia'];
        $j++;
        echo $j;
      }
      else
      {
        echo "ya existia Grabado en stock ".$reg['IdReferencia'];
      }
    }
    echo '<br>';
    echo $j." Articulos grabados";


 ?>
</body>
</html>
