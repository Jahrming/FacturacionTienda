
<!DOCTYPE html>
<html>
<head>
  <title>


  </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type='text/javascript' src='../js/funciones.js'>          </script>
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
</head>
<body>
    <form action='ejemplo.php'>
      <input type="text" id="numeros" name="numeros" method='post'>
      <input type="button" id="boton" name="boton" onclick="ejemploajax();">

      <input type="submit" name="envia" >
    </form>
</body>
</html>
<script type="text/javascript">
  var arreglo= new Array();
  var i=0;
  var j=0;
  function ejemploajax(){
      for(i=0;i<6;i++)
      { 
        j++
        arreglo.push(j);
        //alert(arreglo);
      }
      $.ajax({
        url: 'ejemplo.php',
        type: 'POST',
        dataType: 'text',
        data: {'arreglo': arreglo,'numero':j},
        success: function(resp){
          $('#numeros').val(resp);
          //alert(resp);
        }
      })
      .done(function() {
        console.log("success");
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    }  
  

</script>