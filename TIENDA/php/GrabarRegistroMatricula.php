<?php
	SESSION_START();
	if(!isset($_SESSION['user']))
	{
		header("location:../index.php");
	}
	else
	{ 
            include("Conexion.php");
            $v_usuario          = $_SESSION['user'];
            $v_IdCurso          = $_POST['Curso'];  
            $v_IdRepresentante  = $_POST['IdRepresentante'];  
            $v_IdEstudiante     = $_POST['IdEstudiante'];  
            $v_CedulaEstudiante = $_POST['CedulaEstudiante'];
            $v_PersonaInscribe  = $_POST['PersonaMatricula'];

            $SqlProfile= "SELECT * FROM systemprofile";
            $rs                 = mysqli_query($conexion,$SqlProfile);
            $reg                = mysqli_fetch_assoc($rs);
            $v_numMeses         = $reg['MesesEscolares'];

            ############################
            # Obtiene valor de la beca
            #############################
            $v_valorMatricula   = 0;
            $v_valorPension     = 0;
                   
            $sqlCursos="select * from cursos where idcurso=".$v_IdCurso;
            
            $rs = mysqli_query($conexion,$sqlCursos);
            $reg = mysqli_fetch_assoc($rs);
            $idNivel = $reg['IdNivel'];
            $sqlNiveles='select * from niveles where idNivel='.$idNivel;
            
            $rs = mysqli_query($conexion,$sqlNiveles);
            $reg=mysqli_fetch_assoc($rs);
            $v_valorMatricula   = $reg['ValorMatricula'];
            $v_valorPension     = $reg['ValorPension'];  
            #---Obtiene valores de la becas si tuviese---------------
            $sqlAlumno="select IdBeca from alumnos where IdAlumno=".$v_IdEstudiante;
            
            $rs = mysqli_query($conexion,$sqlAlumno);
            $reg_alumnos= mysqli_fetch_assoc($rs);
            $IdBeca = $reg_alumnos['IdBeca'];

            #----- beca ------------------------------------------
            $sqlbeca = "select * from becas where idbeca=".$IdBeca;
            $rsbeca = mysqli_query($conexion,$sqlbeca);
            $reg_beca = mysqli_fetch_assoc($rsbeca);
            $v_DescuentoBeca=$reg_beca['porcentaje'];
            echo 'descuento de la beca '.$v_DescuentoBeca;
            
            #---------calcula valores ya con descuentos de la beca------------
            $v_vDescuentoMatricula=0;
            $v_vDescuentoPension=0;

            $v_vDescuentoMatricula=$v_valorMatricula*($v_DescuentoBeca/100);
            $v_valorMatricula=$v_valorMatricula-$v_vDescuentoMatricula;

            $v_vDescuentoPension=$v_valorPension*($v_DescuentoBeca/100);
            $v_valorPension=$v_valorPension-$v_vDescuentoPension;            
            #---------Graba en tabla registro_matricula--------------------
            $SqlGrabaTabla1="insert into registromatricula values (0,$v_IdRepresentante,$v_IdEstudiante,
                                                                    '$v_CedulaEstudiante',$v_IdCurso,now(),
                                                                    '$v_PersonaInscribe','A','$v_usuario',now())";
            echo $SqlGrabaTabla1;
            if ($conexion->query($SqlGrabaTabla1)==TRUE)
            {
                $IdRegistroMatricula=  mysqli_insert_id($conexion);    
                $SqlGrabaTabla2="insert into registroobligaciones values($IdRegistroMatricula,$v_IdRepresentante,
                                                                         $v_IdEstudiante,'M','0','Matricula',$v_valorMatricula,
                                                                         0,$v_valorMatricula,now(),null,'P')";
                                                        
                if ($conexion->query($SqlGrabaTabla2)==TRUE){}else
                {
                     echo "Error al grabar: .<br>".$conexion->error;
                }          

                for($i=1;$i<=$v_numMeses;$i++)
                {
                    $SqlGrabaTabla2="insert into registroobligaciones values($IdRegistroMatricula,$v_IdRepresentante,$v_IdEstudiante,
                                                        'P',$i,'Pension ".$i."',$v_valorPension,0,$v_valorPension,now(),null,'P')";
                    if ($conexion->query($SqlGrabaTabla2)==TRUE){}else
                    {
                         echo "Error al grabar: .<br>".$conexion->error;
                    }

                }
              //  $headerLink='Location:Mensajes.php?mensaje=Matricula grabada exitosamente&Destino=ImpresionMatricula.php?IdRegistroMatricula='.$IdRegistroMatricula;
               // echo $headerLink;
              //  header( $headerLink);
            }
            else
            {
                 echo "Error al grabar: ".$SqlGrabaTabla1."<br>".$conexion->error;

            }

 



            $conexion->close();
        }
       
                
  
  