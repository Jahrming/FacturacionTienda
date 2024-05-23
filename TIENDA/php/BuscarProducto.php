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
        


        $x_usuario    =   $_SESSION['user'];
        $x_IdAlmacen  =   $_SESSION['idalmacen'];
        $sql="SELECT * from systemprofile where IdEmpresa=$x_IdAlmacen";        
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 

        $IconoCrear='';
        $IconoModificar='';
        $PermisoCrear='';
        $PermisoModificar='';
        $PermisoEliminar='';
        $sqlattrib="select * from admusuarios a,admtipousuario b,admpermisosprogramas c
                    where a.UserName = '$x_usuario' 
                      and a.IdTipoUsuario = b.IdTipoUsuario
                      and b.IdTipoUsuario = c.IdTipoUsuario";
        $rsAttrib= mysqli_query($conexion,$sqlattrib);
        $reg = mysqli_fetch_assoc($rsAttrib);
        if($reg['Crear']=='S')
        {
          $PermisoCrear='S';
          $sqlIconos="select * from iconosatributos where IdAtributo='C'";
          $rsIcono=mysqli_query($conexion,$sqlIconos);
          $regIcono= mysqli_fetch_assoc($rsIcono);
          $IconoCrear=$regIcono['IconAtributo'];
        }
        if($reg['Modificar']=='S')
        {
          $PermisoModificar='S';
          $sqlIconos="select * from iconosatributos where IdAtributo='U'";
          $rsIcono=mysqli_query($conexion,$sqlIconos);
          $regIcono= mysqli_fetch_assoc($rsIcono);
          $IconoModificar=$regIcono['IconAtributo'];
        }
        if($reg['Eliminar']=='S')
        {
          $PermisoEliminar='S';
          $sqlIconos="select * from iconosatributos where IdAtributo='D'";
          $rsIcono=mysqli_query($conexion,$sqlIconos);
          $regIcono= mysqli_fetch_assoc($rsIcono);
          $IconoEliminar=$regIcono['IconAtributo'];
        }        

      }
      header('Content-Type: text/html; charset=UTF-8');  
  
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('head.php'); ?>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
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
                    <?php include('headmsg.php'); ?>
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
                        <option value='C'>Codigo Barra</option>
                        <option value='N'>Descripción</option>
                      </select>
                     </div>
                     <div class="form-group col-md-5">
                         <label style='color:#FFFFFF' for='buscar' class=''>texto</label>
                         <input style='color:#0080FF' id='query' type='text' name='query' size='25' class='form-control' onkeyup="buscarRegistros();" >
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
                <th bgcolor='#FFFF00' style='color: #0080FF' width='4%' align="center"><b><center>#</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>Id</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='9%'><b><center>Barras</center></b></th>                
                <th bgcolor='#FFFF00' style='color: #0080FF' width='40%'><b><center>Descripción</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>P.V.Pdd.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Marca</center></b></th>

                <?php
                    //$strsql     =  "select * from almacenes where EstadoAlmacen='A'"; 
                    echo $strsql;
                    $rs         =  mysqli_query($conexion,$strsql);
                    while ($regBodegas =  mysqli_fetch_array($rs))
                    {
                      echo "<th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Stock ".$regBodegas['IdBodega']."</center></b></th>";
                    }

                 ?>

                <th bgcolor='#FFFF00' style='color: #0080FF' width='9%' ><b><center>Acciones</center></b></th>

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
     var fila = 1;

     var j=0;
    // alert(numFilas);
      //    
    // alert('hola');
    // alert(numFilas);
    //alert(numFilas);
     if(numFilas>1){
           for(j=1;j<numFilas;j++)
          {
             document.getElementById('tabla1').deleteRow(fila);
          }

     }
     //buscarRegistros();
                
   }
   function buscarRegistros(){
     // alert('presiona');
      setearTabla();
      var Criterio;
      var longitud =$('#query').val().length;
      //var Criterio=$('#query').val();
      var buscarPor= $('#BuscarPor').val();
      var numFilas =   document.getElementById('tabla1').rows.length;
      //alert('buscandio refosotros');
   //   alert('presiono00');

     if(longitud > 3) 
     {


        Criterio=  $('#query').val();
        Criterio= Criterio.trim();
        //alert('criterio '+Criterio);
        $.ajax({

                  url: 'BuscarRegistros.php',
                  data: {'criterio': Criterio,'BuscarPor': buscarPor},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i        =   0;
                   var html     =   '';
                   var contador =   0;
                   var nregs    =   data.IdReferencia.length;

                   for(i=0;i<nregs;i++)
                   {
                     contador++;
                    // alert(contador);
                    html="<tr><td style='color:#000000'>"+contador+"</td>"+
                          "<td style='color:#000000'>"+data.IdReferencia[i]+"</td>"+
                          "<td style='color:#000000'>"+data.CodigoBarra[i]+"</td>"+
                          "<td style='color:#000000'>"+data.Descripcion[i]+"</td>"+
                          "<td style='color:#000000'>"+data.Pvp[i]+"</td>"+
                          "<td style='color:#000000'>"+data.Marca[i]+"</td>"+     
                          "<td style='color:#000000'>"+data.SaldoLocal1[i]+"</td>"+                          
                          "<td style='color:#000000'>"+data.SaldoLocal2[i]+"</td>"+
                          "<td style='color:#000000'><a href=ModificarProducto.php?IdReferencia="+data.IdReferencia[i]+"><span title='Modificar'><img src='../img/editar.gif'></span></a><a href='#' onClick=popup_detalle('"+data.IdReferencia[i]+"') ><span title='Detalle del Prodcuto'><img src='../img/detallepro.png'></span></a></td></tr> ";
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
    /*$(document).ready(function() {

       // $('#query').keydown(buscarRegistros);
         //$('#query').onchange(buscarRegistros);
         //$('#query').keypress(buscarRegistros); 
         //$('#query').keyup(buscarRegistros);
       
          

    })*/

</script>
