<?php
    SESSION_START();
    $v_Mensaje=$_REQUEST['mensaje'];
    $destino=$_REQUEST['Destino'];
    $destino2=$_REQUEST['Destino2'];
    //$accion="window.location=\"".$destino."\"";
	//$accion2="window.location=\"".$destino2."\"";
 //   $accion="window.location=\"".$destino."\"";
    //$accion="window.location=(\"".$destino."\"";
	$accion="window.location=\"".$destino."\"";
	$accion2="window.open(\"".$destino2."\")";

     
     //window.open('pagpdf.php', '_blank');
    
     echo "<br>";
     $codigoHtml="  
   

<html lang='es'>";
echo $codigoHtml;       
  include('headmen.php');
 $codigoHtml="
  <body onload='foco();'>
  <link href='../assets/css/style.css' rel='stylesheet'>    
        <div class='container-fluid'>
            <br>
            <div class='row'>
                <div class='col-md-4'>
                    <div class='alert alert-success'>".$v_Mensaje."</div>
                </div>
            </div>
            <div class='row'>            
              <div class='col-md-4'>
                  <button class='btn btn-md btn-primary btn-block' onclick=".$accion2.";".$accion." type='button' >Aquí para continuar</button>
              </div>
            </div>
        </div>
  </body>
<script type='text/javascript'>
  function foco()
  {
    document.getElementById('aceptar').focus();
  }
</script>
 </html>";

echo $codigoHtml;
           

