<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $v_numCedula='';
        $v_nombres='';
        $v_valor='';
        
        $sql="SELECT * from systemprofile ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 
        $periodoLectivo = $registro['PeriodoLectivoActual'];

       $ListaColegio='';
       $SqlColegios="Select * from colegios ";
       $ResultColegios=  mysqli_query($conexion, $SqlColegios);
       while($reg_Colegios=  mysqli_fetch_array($ResultColegios))
       {
           $IdColegio=$reg_Colegios['IdColegio'];
           $DescColegio=$reg_Colegios['DescripcionColegio'];
           $ListaColegio.=
              "<option value='".$IdColegio."'>".$DescColegio."</option>";
       }  


      }
      header('Content-Type: text/html; charset=UTF-8');  
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA IMPORTBOOKS </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">


  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' >  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">BUSCAR PRODUCTO
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                  <div class="form-row"  >
                    <div class="form-group col-md-5">
                      <label style='color:#0080FF' for='buscar' class=''>Buscar por: </label>
                      <select style='color:#0080FF' id='BuscarPor' name='BuscarPor' class='form-control'  required >         
                        <option value='' >Seleccionar</option>
                        <option value='C'>ISBN</option>
                        <option value='N'>Descripción</option>
                      </select>
                     </div>
                     <div class="form-group col-md-5">
                         <label style='color:#FFFFFF' for='buscar' class=''>texto</label>
                         <input style='color:#0080FF' id='query' type='text' name='query' size='25' class='form-control' >
                     </div>
                     <input type='hidden' id='NumeroFilas' name='NumeroFilas' value='0'/>
                   </div>            
               </div>          
          </div>              
       </div>            
    </div>   

  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >RESULTADOS BÚSQUEDA</div>
       <div class="panel-body" style="width:100%; display:block;">

           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   

            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>#</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>Id</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='13%'><b><center>ISBN</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='45%'><b><center>Descripción</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Stock</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>P.V.P.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Año</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Barras</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='4%'><b><center>Detalles</center></b></th>
              </tr>
            </thead>
            <tbody id='respuesta'>
            </tbody>
        </table>    
     </div>
  </div>
</div>

 </form>
</section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


<script type="text/javascript">
   function setearTabla(){
     var numFilas =   document.getElementById('tabla1').rows.length;
     var j=0;
    // alert(numFilas);
     if(numFilas>1){
           for(j=1;j<numFilas;j++)
          {
             document.getElementById('tabla1').deleteRow('1');
          }
     }
        buscarRegistros();
   }
   function buscarRegistros(){
      var longitud =$('#query').val().length;
      var Criterio=$('#query').val();
      var buscarPor= $('#BuscarPor').val();
          
      if(longitud >= 4)
      { 
        //setearTabla();
        $.ajax({
                  url: 'BuscarRegistros.php',
                  data: {'criterio': Criterio,'BuscarPor': buscarPor},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i=0;
                   var html='';
                   var contador=0;
                   var nregs=data.data.length;
                   for(i=0;i<nregs;i++)
                   {
                     contador++;
                     html='<tr><td>'+contador+'</td>'+
                           '<td>'+data.data[i].Refe+'</td>'+
                          '<td>'+data.data[i].Isbn+'</td>'+
                          '<td>'+data.data[i].Descripcion+'</td>'+
                          '<td>'+data.data[i].saldo+'</td>'+
                          '<td>'+data.data[i].pvp+'</td>'+
                          '<td>'+data.data[i].Anio+'</td>'+
                          '<td>'+data.data[i].Barra+"</td>"+
                          "<td><a href='#' onClick=popup_detalle('"+data.data[i].Refe+"') ><span title='Detalle del Prodcuto'><img src='../img/detalle.png'></span></a></td></tr> ";
                         $('#respuesta').append(html);
                   }

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
    }
 
  
    $(document).ready(function() {
        $('#query').keyup(setearTabla);

    })

</script>
