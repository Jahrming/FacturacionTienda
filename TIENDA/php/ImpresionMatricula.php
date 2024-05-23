<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       $v_usuario=$_SESSION['user'];
       include("Conexion.php");  
        $v_IdRegistroMatricula=$_REQUEST['IdRegistroMatricula'];
        
        
        $StrSql="select * from registromatricula where  idRegistroMatricula=".$v_IdRegistroMatricula;
        $ResultSet= mysqli_query($conexion,$StrSql);
        $regMatricula= mysqli_fetch_assoc($ResultSet);
        $v_IdAlumno = $regMatricula['IdAlumno'];
        $v_cedula=$regMatricula['AlumnoCedula'];
        $v_curso=$regMatricula['IdCurso'];
        $v_FechaRegistro=$regMatricula['FechaRegistro'];
        
        $SqlCursos="select * from cursos where IdCurso=".$v_curso;
        $RSCursos=mysqli_query($conexion,$SqlCursos);
        $regCursos=  mysqli_fetch_assoc($RSCursos);
        $v_IdNivel=$regCursos['IdNivel'];
        $v_Paralelo=$regCursos['IdParalelo'];
        
        $SqlNiveles="select * from niveles where idNivel=".$v_IdNivel;
        $RSNiveles=mysqli_query($conexion,$SqlNiveles);
        $regNiveles=  mysqli_fetch_assoc($RSNiveles);
        $v_NombreNivel=$regNiveles['NivelDescripcion'];     
        
        $SqlAlumnos="select * from Alumnos where IdAlumno=".$v_IdAlumno;
        $RSALumnos=mysqli_query($conexion,$SqlAlumnos);
        $regAlumnos=  mysqli_fetch_assoc($RSALumnos);
        $Nombres=$regAlumnos['Apellidos'].' '.$regAlumnos['Nombres'];
        
        $NombreCurso= $v_NombreNivel.' '.$v_Paralelo;
        

        $CodigoHtml="   
    <!DOCTYPE html>
    <html>
    <head>

            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <title>SISTEMA DE ACADEMICO | REGISTRO DE MATRICULACION </title>
            <style>
            @page { margin: 180px 50px; }
                    #header { position: fixed; left: 0px; top: -200px; right: 0px; height: 200px; text-align: center; }
                    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; text-align: center;}
            #footer .page:after { content: counter(page, upper-arial); }
            </style>
            <center>REGISTRO DE MATRICULACION</CENTER>
    </head>

    <body>
              <br><br><br><br>
                 Registro de Matricula No $v_IdRegistroMatricula
              <br><br>
                <p>Habiendo cumplido los requisitos necesarios y amparado en las leyes se informa que el(la) </p>
                <p>Estudiante $Nombres con cédula de ciudadanía No. $v_cedula  ha sido </p>
                <p>matriculado en el $NombreCurso del presente periodo lectivo 2019-2020   </p>
                <p>Tal como registrado en los libros del Colegio Pilar Roos. </p>
                <p> </p>
                <br><br><br><br>
                Fecha: $v_FechaRegistro
                <br><br><br><br>
                --------------------------
                <br>
                Firma del Rector

    </body>
</html>";
              



    }

	require_once("dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
$documentopdf= new DOMPDF();
$documentopdf->setPaper('A4','PORTRAIT');
//$documentopdf->loadHtml($purocodigo);
$documentopdf->loadHtml(ob_get_clean());
$documentopdf->loadHtml($CodigoHtml);
	//    $dompdf->load_html(utf8_encode($purocodigo));
	  //  ini_set("memory_limit","128M");
	    $documentopdf->render();
	 //   $documentopdf->stream("Li.pdf",array("Attachment"=>0));
$documentopdf->stream("RegistroMatricula.pdf",array("Attachment"=>0));
    
