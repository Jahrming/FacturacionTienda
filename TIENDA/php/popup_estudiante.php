

<?php
	SESSION_START();
	if(!isset($_SESSION['user']))
	{
		header("location:../index.php");
	} 

?>
<html>
	<head>
		<script type='text/javascript' src='../js/funciones.js'> </script>
		<title> Búsqueda </title>
	</head>

	<body>
		<form id="form1" name="form1" method="GET" action="?">
		</form>
		<form onkeypress="javascript:return WebForm_FireDefaultButton(event, &#39;ctl00_ContentPlaceMain_btnBuscar&#39;)">
			<style>
	            table {
    	            	font-family: arial, 'Times New Roman',Times, serif;
            		    border-collapse: collapse;
                		width: 100%;
                		font-size: 11px;
                      }
             </style>
			<table   border="1" cellspacing="0" cellpadding="0">
				<tr bgcolor= '#3B83BD' style='color: rgb(246, 246, 246)'>
					<td width="10"> <b> &nbsp Cedula </b> &nbsp</td>
				    <td width="30"> <b> &nbsp Cedula </b> &nbsp</td>
				    <td width="55"> <b> &nbsp Nombres </b> &nbsp</td>
				    <td width="25"> <b> &nbsp Parentesco </b> &nbsp</td>
				</tr>
				<?php
				    $v_Id= $_REQUEST['IdRepresentante'];
					include("Conexion.php");
							$query = "SELECT a.IdAlumno as idalumno,a.cedula as cedula,".
										   " concat(a.apellidos,' ',a.nombres) as nombres,".
										   " p.DescripcionParentesco as parentesco ".
									  " FROM alumnos a,representantes r,parentesco p ". 
									 " WHERE a.IdRepresentante = r.IdRepresentante ".
									 "   AND a.IdParentesco = p.IdParentesco ".
									 "   AND a.IdRepresentante = ".$v_Id;
										$r_query = mysqli_query($conexion,$query);
							while ($reg=mysqli_fetch_array($r_query) )
					        {
					           // $i++;
					        	$v_Id= $reg['idalumno'];
								$v_Cedula= $reg['cedula'];
					            $v_Nombres= $reg['nombres'];
					            $v_Parentesco = $reg['parentesco'];
					            $v_Nombres=str_replace(" ","&nbsp;", $v_Nombres);
					            //$id=$row{'id'};
					            echo "<tr OnMouseOver='Resaltar_On(this);' 
					                      OnMouseOut='Resaltar_Off(this);' 
					                      OnClick=datos_estudiantes($v_Id,'$v_Cedula','$v_Nombres')> 
					                      <td> &nbsp $v_Id 		&nbsp </td>
					                      <td> &nbsp $v_Cedula 		&nbsp </td>
					                      <td> &nbsp $v_Nombres 	&nbsp </td>
					                      <td> &nbsp $v_Parentesco 	&nbsp </td>
					                   </tr>";
					      	}
					    
					   
				?>
			</table>
		</form>
	</body>
</html>