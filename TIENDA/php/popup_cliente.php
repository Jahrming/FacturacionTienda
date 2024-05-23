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
		<title> Búsqueda de Clientes</title>
	</head>

	<body>
		<form id="form1" name="form1" method="GET" action="?">
			<strong style="font-family: 'Poppins', sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 12px;color: #0040FF;" >Buscar por Apellidos y Nombres: </strong>
			<input type="text" name="q" id="q" size="40" />
			<input type="submit" name="enviar" id="enviar" value="Buscar" />
		</form>
		<form onkeypress="javascript:return WebForm_FireDefaultButton(event, &#39;ctl00_ContentPlaceMain_btnBuscar&#39;)">
			<table   border="1" cellspacing="0" cellpadding="0">
	          <style>
                table {
                    font-family: 'Poppins', sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 12px;
                }
              </style>	
				<tr  style='color: #0040FF;background-color:#FFFF00;'>
					<td width="4%"  style='padding: 5px;'><center> <b> Id </b></center></b> </td>
					<td width="10%" style='padding: 5px;'><center>  <b> Cedula </b></center></td>
				    <td width="30%" style='padding: 5px;'><center>  <b> Nombres </b></center></td>
				    <td width="10%" style='padding: 5px;'><center>  <b> Teléfonos </b></center></td>
				    <td width="20%" style='padding: 5px;'><center>  <b> Email </b></center></td>
				    <td width="36%" style='padding: 5px;'><center>  <b> Dirección </b></center></td>
				</tr>
				<?php
					if(isset($_GET['q']))
					{ 
					    if($_GET['q']<>"")
					    {
					    	$i=0;
							include("Conexion.php");
							$query = "SELECT * FROM clientes WHERE Apellidos LIKE '%".$_GET['q']."%' 
										OR Nombres LIKE '%".$_GET['q']."%' ORDER BY Apellidos, Nombres";
				
							$r_query = mysqli_query($conexion,$query);
							while ($reg=mysqli_fetch_array($r_query) )
					        {
					           // $i++;
					        	$v_Id      	 	= $reg['IdCliente'];
								$v_Cedula  	 	= $reg['CedulaRUC'];
					            $v_Nombres 	 	= $reg['Apellidos'].' '.$reg['Nombres'];
					            $v_Telefonos 	= $reg['Telefonos'];
					            $v_Email 		= $reg['Email'];
					            $v_Direccion 	= $reg['Direccion'];
					            $v_Nombres   = str_replace(" ","&nbsp;", $v_Nombres);
					            //$id=$row{'id'};
					            echo "<tr OnMouseOver='Resaltar_On(this);' 
					                      OnMouseOut='Resaltar_Off(this);' 
					                      OnClick=datos_clientes($v_Id,'$v_Cedula','$v_Nombres','$v_Telefonos','$v_Email','$Direccion')> 
					                      <td style='color: #0040FF'> &nbsp $v_Id 		    &nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_Cedula 		&nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_Nombres 	&nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_Telefonos 	&nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_Email 	    &nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_Direccion 	&nbsp </td>
					                   </tr>";
					      	}
					    }
					  }  
				?>
			</table>
		</form>
	</body>
</html>