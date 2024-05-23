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
      }

  

      
if(isset($_POST['NumeroCedula']))
{
   $v_numCedula  =$_POST['NumeroCedula'];     
}


?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA COMERCIAL </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
    <link href="../css_temas/helper.css" rel="stylesheet">
    <link href="../css_temas/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 
        input{
          padding: 3px;
          margin: 3px;
        }
        ul{
          float: left;
          background-color: #eee;
          cursor:pointer;
        }
        li{
          float: left;
          padding: 12px;
        }
        #sugerencias {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
        #filtrarProductos {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
 
        #sugerencias .suggest-element {
                background-color: #EEEEEE;
                border-top: 1px solid #d6d4d4;
                cursor: pointer;
                padding: 8px;
                width: 400%;
                float: left;
        }

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">                      
  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>
  <form id='formulario' name='formulario' role='form' method='POST' enctype='multipart/form-data' >

        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">ESTADO DE CUENTA POR CLIENTE
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button class='btn btn-primary btn-sm' id='btn-imprimir' title='Imprimir Estado de Cuenta' type="submit" disabled="true" style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>    
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
          </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                  <div class="form-row"  >
                      <input type='hidden' id='IdRepresentante' name='IdRepresentante' value=''>
                      <input type='hidden' id='numeroFilas' name='numeroFilas' >
                      <input type='hidden' id='cobraIva' name='cobraIva' value='<?php echo $cobraIva;?>' >
                      <input type='hidden' id='ivaActual' name='ivaActual' value='<?php echo $ivaActual;?>' >
                      <input type='hidden' id='periodoLectivo' name='periodoLectivo' value='<?php echo $periodoLectivo;?>' >
                      <input type='hidden' id='IdRegistroMatricula' name='IdRegistroMatricula' value='' >
                      <input type='hidden' id='IdCurso' name='IdCurso' value='' >
                      <div class="form-group col-md-2" style='padding: 4px;margin: 0px;'>
                          <label style='color:#0080FF;padding: 0px;margin: 0px;' for="f_cedula">Cédula/RUC:</label>
                          <input style='color:#0080FF;padding: 4px;margin: 0px;' type="text" class="form-control" id="Cedula" name='Cedula' placeholder="Cédula o RUC" onkeypress="buscarCliente(event)" onkeydown="buscarClienteTab(event)">
                      </div> 
                      <div class="form-group col-md-6" style='padding: 4px;margin: 0px;'>
                         <label style='color:#0080FF;padding: 0px;margin: 0px;'  for="f_apellidos">Nombre Cliente:</label>
                         <input style='color:#0080FF;padding: 4px;margin: 0px;' type="text" class="form-control" id="NombreCliente" name='NombreCliente' autocomplete="no">
                            <div id="sugerencias" class='list-group'></div>
                      </div>                       
                      <div class="form-group col-md-5">
                        <label style='color:#0080FF' for='inicio' class=''>Fecha Inicio: </label>
                        <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="FechaInicio" name='FechaInicio' required="yes">
                      </div>
                      <div class="form-group col-md-5">
                        <label style='color:#0080FF' for='fin' class=''>Fecha Fin: </label>
                        <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="FechaFin" name='FechaFin' required="yes">
                      </div>                          

                  </div>
              </div>
          </div>            
        </div>   


  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >DETALLE DE PAGOS</div>
       <div class="panel-body">
           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   

            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='16%'><b><center>#</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='16%'><b><center>No.Fact</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='16%'><b><center>Fecha</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Pagado</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Pendiente</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='18%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Detalle</center></b></th>
              </tr>
            </thead>
            <tbody id='respuesta'>
            </tbody>
        </table>   











           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   
            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='3%'><b><center>#</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='12%'><b><center>Tipo</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='5%'><b><center>Sec.</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='12%'><b><center>Obligación</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='12%'><b><center>Valor</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='10%'><b><center>Pagado</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='10%'><b><center>Pendiente</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='10%'><b><center>Fecha Pago</center></b></th>
              </tr>
            </thead>
            <tbody id='respuesta'>
            </tbody>
        </table>    
     </div>
  </div>
</div>





     
     
 
  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >DETALLE DE PAGOS</div>
       <div class="panel-body">
 
           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   
            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='3%'><b><center>#</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='12%'><b><center>Tipo</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='5%'><b><center>Sec.</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='12%'><b><center>Obligación</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='12%'><b><center>Valor</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='10%'><b><center>Pagado</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='10%'><b><center>Pendiente</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='10%'><b><center>Fecha Pago</center></b></th>
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
   var xhr;
   var registroMatricula;
   function getIdRegistroMatricula(){
      var datosString='';
      var datosArray='';
      if(window.XMLHttpRequest){
        xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject)
      {
        xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange=ObtieneValor;
      xhr.open('POST','getIdRegistroMatricula.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdEstudiante="+document.getElementById('IdEstudiante').value);
      function ObtieneValor(){
        if(xhr.readyState==4){
          if(xhr.status==200){
            //document.getElementById('IdRegistroMatricula').value= this.responseText;
            datosString = this.responseText;
            datosArray = datosString.split('_;_');
            document.getElementById('IdRegistroMatricula').value= datosArray[0];
            registroMatricula= document.getElementById('IdRegistroMatricula').value;
            document.getElementById('IdCurso').value= datosArray[1];
            document.getElementById('Curso').value= datosArray[3];
            //alert(document.getElementById('IdRegistroMatricula').value);
            //alert(document.getElementById('IdCurso').value);
            //alert(document.getElementById('Curso').value);
          }
        }
      }



   } 

   function getCurso(){
 
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= muestraMultiplicador;
      xhr.open('POST','getCurso.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdEstudiante="+document.getElementById('IdEstudiante').value);
      function muestraMultiplicador(){
        if(xhr.readyState==4 && xhr.status==200){
          document.getElementById('Curso').value=this.responseText;
        }
      } 
   }

      function getIdCurso(){

      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= muestraMultiplicador;
      xhr.open('POST','getIdCurso.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdEstudiante="+document.getElementById('IdEstudiante').value);
      function muestraMultiplicador(){
        if(xhr.readyState==4 && xhr.status==200){
          document.getElementById('IdCurso').value=this.responseText;
        }
      } 
      
   }

   function obtieneListaEstudiantes(){
      var datosString ='';
      var datosArray ='';
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= ListaEstudiantes;
      xhr.open('POST','ListaEstudiantes.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdRepresentante="+document.getElementById('IdRepresentante').value);
      function obtieneListaEstudiantes(){
        if(xhr.readyState==4 && xhr.status==200){
          datosString= this.responseText;
          datosArray = datosString.splice('|');
          document.getElementById('Id').value=datosArray[0];
          document.getElementById('IdCurso').value=datosArray[1];
          document.getElementById('Curso').value=datosArray[3];
        }
      }
   }

//document.getElementById("IdRepresentante").onchange =obtieneListaEstudiantes;
//document.getElementById("IdVigencia").onchange=obtieneMultiplicador;
//var nfilas=document.getElementById('NumeroFilas').value;
//   /############ Carga combo de Estudiantes ###################
            function cargaEstudiantes(){
              var Criterio= document.getElementById('IdRepresentante').value;
              $.ajax({
                url: 'getEstudiantesxRepresentantes.php',
                type: 'POST',
                data: {'IdRepresentante': Criterio},
                success: function(respuesta){
                  $('#IdEstudiante').html(respuesta).fadeIn();
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

            $(document).ready(function(){
              $('#CedulaRepresentante').blur(cargaEstudiantes);
            });

            //############ Carga tabla obligaciones ###################

            function datosMatricula(){
              var RegistroMatricula = document.getElementById('IdRegistroMatricula').value;
              var strAction='';
              var criterio1= document.getElementById('IdRepresentante').value;
              var criterio2= document.getElementById('IdEstudiante').value;
              var SubtotalPagado = 0;
              var SubtotalPendiente = 0;
              $.ajax({
                url: 'getEstadoDeCuenta.php',
                type: 'POST',
                data: {'IdRepresentante': criterio1,'IdEstudiante': criterio2},
                dataType: 'JSON',
                success: function(data){
                  var i=0;
                  var html='';
                  var contador=0;
                  var nregs=data.data.length;
                  var fechaPago='';
                  for(i=0;i<nregs;i++)
                  {
                    
                    contador++;
                    $('#numeroFilas').val(contador);

                    if(data.data[i].FechaPago==null){
                      fechaPago='No registra';
                    }
                    else
                    {
                      fechaPago=data.data[i].FechaPago;
                    }
                    if(data.data[i].valorPendiente==0){
                      SubtotalPagado = SubtotalPagado+ parseFloat(data.data[i].valorPagado);
                    }
                    else
                    {
                      SubtotalPendiente = SubtotalPendiente + parseFloat(data.data[i].Valor);
                    }
                    
                    html=html+"<tr ><td>"+contador+"</td>"+    
                        "<td>"+data.data[i].NombreObligacion+"</td>"+
                        "<td>"+data.data[i].Secuencia+"</td>"+
                        "<td>"+data.data[i].DescripcionObligacion+"</td>"+
                        "<td>"+data.data[i].Valor+"</td>"+
                        "<td>"+data.data[i].valorPagado+"</td>"+
                        "<td>"+data.data[i].valorPendiente+"</td>"+
                        "<td>"+fechaPago+"</td></tr>";
                        //alert(document.getElementById('TipoObligacion1').value);
                        
                  }
                  html=html+"<tr><td colspan='7' align='right' style='font-size: 16px;'>Pagado    : </td><td style='font-size: 16px;background-color:#58FA82'>"+SubtotalPagado+"</td></tr>";
                  html=html+"<tr><td colspan='7' align='right' style='font-size: 16px;'>Pendiente : </td><td style='font-size: 16px;background-color:#FA5858'>"+SubtotalPendiente+"</td></tr>";
                  $('#respuesta').append(html);  
                  $('#btn-imprimir').removeAttr('disabled');
                  strAction="ImprimeEstadoCuenta.php?IdRegistroMatricula="+registroMatricula;
                  formulario.setAttribute('action', strAction);
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
            $(document).ready(function(){
              $('#IdEstudiante').change(datosMatricula);
            });

   //,getIdCurso
            
//######################################################333
//    codigo de ejemplo
//*********************************************************
/*        $(document).on('click','.eliminar',function(event){
            event.preventDefault();
            var v_TotalContrato=0;
            $(this).closest('tr').remove();
               nfilas = $('#NumeroFilas').val();
               for(i=1;i<=nfilas;i++){
                 var elemento;
                 elemento='Valor'+i;
                  if(document.getElementById(elemento))
                  {
                     v_TotalContrato=v_TotalContrato+ parseFloat(document.getElementById(elemento).value);
                  }
               }
               $('#TotalContrato').val(v_TotalContrato);
            ;
         }
        );*/
//**********************************************************


function calculos(Objeto){
var row = $(Objeto).parent().children().index($(Objeto)); 
//var col = $(Objeto).parent().parent().children().index($(Objeto).parent());
var fila=0;
//var campo='';
//var secuencial=0;
var nRegs='';
var i=0;
//var controlCheck='';
var elementoCheck='';
var elementoValor='';
var elementoSecuencia='';
var subtotalPago=0;
var valorIva=0;
var totalvalorPago=0;
var cobraIva='';
var ivaActual=0;
var filasSeleccionadas=0;
  
    cobraIva=document.getElementById('cobraIva').value;
    ivaActual=document.getElementById('ivaActual').value;
    fila=row+1;
    campo1= 'Valor'+fila;
    campo2 = "Secuencia"+ fila;
    check  = 'chkbox'+fila;

    nRegs=parseInt($('#numeroFilas').val());
   // alert(nRegs);

    for(i=1;i<=nRegs;i++)
    {
      elementoCheck='chkbox'+i;
      elementoValor='Valor'+i;
      elementoSecuencia='Secuencia'+i;
      /*controlCheck='chkbox'+i;
      //alert(elementoCheck);
      alert(controlCheck);*/
      if(document.getElementById(elementoCheck).checked==true)
      {
        //alert('valor a pagar '+document.getElementById(elementoValor).value);
        //alert('secuencial '+document.getElementById(elementoSecuencia).value);
        subtotalPago= subtotalPago+parseFloat(document.getElementById(elementoValor).value);
        
        if(cobraIva=='S'){
          valorIva= document.getElementById('valorIva').value;
          document.getElementById('subtotal').value=subtotalPago;
          valorIva=subtotalPago*(valorIva/100);
          document.getElementById('iva').value=valorIva;
          totalvalorPago=totalvalorPago+subtotalPago+valorIva;
          document.getElementById('total').value=totalvalorPago;
        }
        else
        {
          document.getElementById('subtotal').value=subtotalPago;
          valorIva=0;
          document.getElementById('iva').value=valorIva;
          totalvalorPago=subtotalPago;
          document.getElementById('total').value=totalvalorPago;    
        }
        filasSeleccionadas++;
      }
      if(filasSeleccionadas==0){
          document.getElementById('subtotal').value=0.00;
          document.getElementById('iva').value=0.00;
          document.getElementById('total').value=0.00;          
      }
    }

}

           

</script>
</html> 

   