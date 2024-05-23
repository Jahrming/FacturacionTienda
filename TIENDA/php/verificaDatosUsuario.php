<?php

    SESSION_START();
      include("Conexion.php");    
		    $IdUsuario=$_POST["Usuario"];
        $contador=0;
        $Respuesta = null;   
        $regId=null;
        $StrUsuario='';
        $Sql="select * from admusuarios where UserName='".$IdUsuario."'";
                          $Result= mysqli_query($conexion, $Sql);
        while($reg=  mysqli_fetch_array($Result))
        {
            $regId=$reg["UserName"];
            $StrUsuario=$reg["ApellidosUsuario"].' '.$reg["NombresUsuario"];
            $contador++;
           
        }


           if($contador==0)
            { 
              $StrUsuario='';
            }
           else{

           }

          echo $StrUsuario;
  
            
    