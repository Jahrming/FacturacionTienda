<?php
    SESSION_START();
    $v_Mensaje=$_REQUEST['mensaje'];
    $destino=$_REQUEST['Destino'];

    $accion="window.location=\"".$destino."\"";
     
     //window.open('pagpdf.php', '_blank');
    
     echo "<br>";
   
?>

<!DOCTYPE html>

<html lang='es'>            
<?php 
   include("headmen.php");
 ?>
<body onload='foco();'>  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
        <div class='container-fluid'>
            <br>
            <div class='form-row'>
                <div class='col-md-4'>
                    <div class='alert alert-success'><?php echo $v_Mensaje;?></div>
                </div>
            </div>
            <div class='form-row'>            
                <div class='col-md-4'>
                  <button id='aceptar' class='btn btn-md btn-primary btn-block' onclick='<?php echo $accion; ?>' type='button' >Aquí para continuar</button>
                </div>
            </div>
        </div>    

</body>
<script type="text/javascript">
  function foco()
  {
    document.getElementById('aceptar').focus();
  }
</script>
 </html>            

       