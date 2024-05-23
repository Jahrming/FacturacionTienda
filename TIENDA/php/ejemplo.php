

<?php  
   $arreglos = $_POST['arreglo'];
   $contador = $_POST['numero'];
   $i=0;
   for($i=0;$i<$contador;$i++)
   {
     echo $arreglos[$i];
   }
   $i=3;
   echo 'hola'.$arreglos[$i]; 
?>

 