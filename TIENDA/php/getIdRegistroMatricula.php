

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
        $sql="SELECT * from systemprofile ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        $periodoLectivo = $registro['PeriodoLectivoActual'];
        /*********************************        
        *   Obtener IdRegistroMatricula
        *********************************/
        $v_criterio= $_POST['IdEstudiante'];
        $sql   ="select a.IdRegistroMatricula as IdRegMat,a.IdCurso as IdCurso,".
                    "   d.NivelDescripcion as DescNiveles,concat('[',a.IdCurso,']-',d.NivelDescripcion,' ',b.IdParalelo) ".
                    "   from registromatricula a ,cursos b ,systemprofile c,niveles d ".
                "  where a.IdAlumno =".$v_criterio.
                "  and a.IdCurso = b.IdCurso ".
                "  and b.IdNivel = d.IdNivel ".
                "  and b.IdPeriodoLectivo = c.PeriodoLectivoActual ";
      
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        
        echo implode("_;_", $registro);
 
      }
      

