<?php
    $html = "";
    include('Conexion.php');
    $nombre = $_POST["nombre"];
   //$nombre ="SALTOS";
    $sql = "SELECT idCliente,concat(nombresCliente,' ',apellidosCliente) cliente FROM clientes where nombresCliente like '%".$nombre."%' union " .
    " SELECT idCliente,concat(nombresCliente,' ',apellidosCliente) cliente FROM clientes where apellidosCliente like '%".$nombre."%'  " ;

 
        $rs = mysqli_query($conexion,$sql);
        while($row= mysqli_fetch_array($rs))
        { //$html = "<a href='#' class='list-group-item' idCliente='cli1' value='cli2'>ahora si</a>";
          $html.="<a href='#' class='list-group-item' idCliente='".$row['idCliente']."' value='".$row['cliente']."' onclick=\"retornaDatosCliente(".$row['idCliente'].",'".$row['cliente']."')\">".$row['cliente']."</a>";
        }
    echo $html;
