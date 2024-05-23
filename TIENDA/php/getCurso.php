

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
        *   Obtener Datos Curso
        *********************************/
        $v_criterio= $_POST['IdEstudiante'];
        $sql   ="select b.IdCurso as IdCurso,d.NivelDescripcion as Nivel,b.IdParalelo as Paralelo ".
                "  from registromatricula a ,cursos b ,systemprofile c,niveles d ".
                " where a.IdAlumno =".$v_criterio.
                " and   a.IdCurso = b.IdCurso ".
                " and b.IdPeriodoLectivo = c.PeriodoLectivoActual ".
                " and b.IdNivel = d.idNivel ";
        //echo $sql;
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        $Curso = '['.$registro['IdCurso'].']'.'-'.$registro['Nivel'].' '.$registro['Paralelo'];
 
      }
      echo $Curso;

