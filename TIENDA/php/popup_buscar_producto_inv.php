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
		<title> Búsqueda de Productos</title>
	</head>

	<body>
		<form id="form1" name="form1" method="GET" action="?">
			<strong style="font-family: 'Poppins', sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 12px;color: #0040FF;" >Buscar por Descripción: </strong>
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
					<td width="4%"  style='padding: 5px;'><center> <b> Id Item </b></center></b> </td>
					<td width="10%" style='padding: 5px;'><center>  <b> Cod Barras </b></center></td>
				    <td width="30%" style='padding: 5px;'><center>  <b> Descripción </b></center></td>
				</tr>
				<?php
					if(isset($_GET['q']))
					{ 
					    if($_GET['q']<>"")
					    {
					    	$i=0;
							include("Conexion.php");
							$query = "SELECT * FROM referencias WHERE DescripcionReferencia LIKE '%".$_GET['q']."%' 
										 ORDER BY DescripcionReferencia";
				
							$r_query = mysqli_query($conexion,$query);
							while ($reg=mysqli_fetch_array($r_query) )
					        {
					           // $i++;
					        	$v_Id      	 	= $reg['IdReferencia'];
								$v_CodigoBarra  = $reg['CodigoBarra'];
					            $v_Nombres 	 	= $reg['DescripcionReferencia'];
					            $v_Nombres   = str_replace(" ","&nbsp;", $v_Nombres);
					            

					            //$id=$row{'id'};
					            echo "<tr OnMouseOver='Resaltar_On(this);' 
					                      OnMouseOut='Resaltar_Off(this);' 
					                      OnClick=datos_referencia_inv($v_Id,'$v_CodigoBarra','$v_Nombres')> 
					                      <td style='color: #0040FF'> &nbsp $v_Id 		    &nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_CodigoBarra 		&nbsp </td>
					                      <td style='color: #0040FF'> &nbsp $v_Nombres 	&nbsp </td>
					                   </tr>";
					      	}
					    }
					  }  
				?>
			</table>
		</form>
	</body>
</html>