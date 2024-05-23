<?php 

           $rutaArchivo = "../xml/01.XML";
           $archivo = fopen($rutaArchivo, "w");

           fwrite($archivo,"w");
           fclose($archivo);	
           echo "archivo creado"." ".$rutaArchivo;
           //$array_archivos[$contadorArchivos-1]=$puroarchivo; //$arr [$contadorArchivos-1]=$rutaArchivo;
           //$array_archivos

           /*for($j=0;$j<$contadorArchivos;$j++)
           {
              //echo $array_archivos[$j];
              header("Content-disposition: attachment; filename=".$array_archivos[$j]);
              header("Content-type: MIME");
              readfile($array_archivos[$j]);   

           }

         // header('Location:Mensajes.php?mensaje=XML generados exitosamente&Destino=../inicio/menu.php' );*/



