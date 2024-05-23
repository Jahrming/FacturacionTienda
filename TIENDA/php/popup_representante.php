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
			<strong>Buscar por Apellidos y Nombres: </strong>
			<input type="text" name="q" id="q" size="40" />
			<input type="submit" name="enviar" id="enviar" value="Buscar" />
		</form>
		<form onkeypress="javascript:return WebForm_FireDefaultButton(event, &#39;ctl00_ContentPlaceMain_btnBuscar&#39;)">
			<table   border="1" cellspacing="0" cellpadding="0">
				<tr bgcolor= '#3B83BD' style='color: rgb(246, 246, 246)'>
					<td width="10"> <b> &nbsp Cedula </b> &nbsp</td>
				    <td width="66"> <b> &nbsp Cedula </b> &nbsp</td>
				    <td width="238"> <b> &nbsp Nombres </b> &nbsp</td>
				</tr>
				<?php
					if(isset($_GET['q']))
					{ 
					    if($_GET['q']<>"")
					    {
					    	$i=0;
							include("Conexion.php");
							$query = "SELECT * FROM representantes WHERE Apellidos LIKE '%".$_GET['q']."%' 
										OR nombres LIKE '%".$_GET['q']."%' ORDER BY Apellidos, Nombres";
				
							$r_query = mysqli_query($conexion,$query);
							while ($reg=mysqli_fetch_array($r_query) )
					        {
					           // $i++;
					        	$v_Id= $reg['IdRepresentante'];
								$v_Cedula= $reg['cedula'];
					            $v_Nombres= $reg['apellidos'].' '.$reg['nombres'];
					            $v_Nombres=str_replace(" ","&nbsp;", $v_Nombres);
					            //$id=$row{'id'};
					            echo "<tr OnMouseOver='Resaltar_On(this);' 
					                      OnMouseOut='Resaltar_Off(this);' 
					                      OnClick=datos_representantes($v_Id,'$v_Cedula','$v_Nombres')> 
					                      <td> &nbsp $v_Id 		&nbsp </td>
					                      <td> &nbsp $v_Cedula 		&nbsp </td>
					                      <td> &nbsp $v_Nombres 	&nbsp </td>
					                   </tr>";
					      	}
					    }
					  }  
				?>
			</table>
		</form>
	</body>
</html>