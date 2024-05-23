<?php

    SESSION_START();
      include("Conexion.php");    
        $Alumno=$_POST["Alumno"];
        $contador=0;
        $Respuesta = null;   
        $regId=null;
        $StrUsuario='';
        $Sql="select * from alumnos where cedula='".$Alumno."'";
                          $Result= mysqli_query($conexion, $Sql);
        while($reg=  mysqli_fetch_array($Result))
        {
            $regCedula=$reg["cedula"];
            $StrEstudiante=$reg["Apellidos"].' '.$reg["Nombres"];
            $contador++;
           
        }


           if($contador==0)
            { 
              $StrUsuario='';
            }
           else{

           }

          echo $StrUsuario;
  
            
    
    