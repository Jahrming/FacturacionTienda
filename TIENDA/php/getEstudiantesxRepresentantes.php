

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
       $v_criterio= $_POST['IdRepresentante'];
       
       $strSQl="SELECT * FROM alumnos, registromatricula
                   WHERE alumnos.idAlumno = registromatricula.IdAlumno 
                     AND alumnos.IdRepresentante = ".$v_criterio;
                     echo $strSQl;

       $rs =  mysqli_query($conexion,$strSQl);
       $ListAlumnos="<option value=''>Seleccionar</option>";
       while ($reg= mysqli_fetch_assoc($rs) ) 
       {
          $ListAlumnos.="<option value='".$reg['IdAlumno']."'>".$reg['Apellidos']." ".$reg['Nombres']."</option>";

       }
 
      }
      echo $ListAlumnos;

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

</body>
</html>
