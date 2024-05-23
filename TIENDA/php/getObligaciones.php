
<?php
    SESSION_START();
    header("Content-type: text/javascript; charset=iso-8859-1");
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
       $_usuario=$_SESSION['user'];
       $v_criterio1= $_POST['IdRepresentante'];
       $v_criterio2= $_POST['IdEstudiante'];

       $Sql="SELECT c.DescripcionTipoObligacion as NombreObligacion,
                    b.SecuencialObligacion as Secuencia,
                    b.DescripcionObligacion as DescripcionObligacion,
                    b.valor as Valor,
                    b.ValorPagado as valorPagado,
                    b.ValorPendiente as valorPendiente,
                    b.FechaRegistroPago as FechaPago
               from registromatricula a, registroobligaciones b, tipoobligacion c 
              where a.idRegistroMatricula = b.IdRegistroMatricula 
                and a.IdRepresentante= $v_criterio1 
                AND  a.IdAlumno   =    $v_criterio2 
                and b.IdTipoObligacion = c.IdTipoObligacion
                and b.estado = 'P' ";
                
            

       $rs =  mysqli_query($conexion,$Sql);
       while ($reg= mysqli_fetch_assoc($rs) ) 
       {
          $arreglo['data'][]= $reg;       

       }
       ///echo rawurldecode(utf8_decode($arreglo)
       echo json_encode($arreglo);

      } 
 

