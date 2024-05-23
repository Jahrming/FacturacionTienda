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
    <title> SISTEMA ACADEMICO </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 
    </style>
  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabaRegistrosPago.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">REGISTRO DE PAGOS
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <?php echo "<button id='btn_grabar' class='btn btn-primary btn-sm' title='Grabar' onclick='' type='submit' style='font-size:12px;color:#0080FF;background-color:#FFBF00;border:none';border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFBF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
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
                      <div class="form-group col-md-3">
                          <label style='color:#0080FF' for="f_cedula">&nbsp&nbspCédula Representante:&nbsp&nbsp</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="CedulaRepresentante" name='CedulaRepresentante' placeholder="CedulaRepresentante">
                      </div>
                  </div>
                  <div class="form-group col-md-1">
                      <label style='color:#FFFFFF' for="f_buscar">Bus</label>
                      <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('representante')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
                  </div>
                  <div class="form-group col-md-8">
                      <label style='color:#0080FF'  for="f_apellidos">&nbsp&nbspNombres Respresentante: </label>
                      <input style='color:#0080FF' type="text" class="form-control" id="NombreRepresentante" name='NombreRepresentante' readonly="yes">
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label style='color:#0080FF'  for="f_apellidos">&nbspEstudiante: </label>
                          <select id='IdEstudiante' name='IdEstudiante' class='form-control'  required  onchange='getIdRegistroMatricula()'>
                          </select>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label style='color:#0080FF'  for="f_apellidos">&nbspCurso: </label>
                          <input style='color:#0080FF' type="text" class="form-control" id="Curso" name='Curso' readonly="yes">
                      </div>
                  </div>
              </div>

                <div class="panel-heading" style="width:25%; float:left; display:block;
                                background:#FFBF00;font-size: 18px;font-weight:bold;border-color:#0080FF;">
                    <table  style='font-size: 18px;border: hidden;' >
                      <tr style="font-size: 20px;color:#0080FF;font-weight:bold;"><td>Subtotal:</td><td align="right"><input type='numeric' step='0.01' id='subtotal' name='subtotal' readonly="yes" size='5'></tr>
                      <tr><td>&nbsp</td><td>&nbsp</tr>
                      <tr style="font-size: 20px;color:#0080FF;font-weight:bold;"><td>I.V.A.:</td><td align="right"><input type='numeric' id='iva'step='0.01' name='iva' readonly="yes" size='5'> </tr>
                      <tr><td>&nbsp</td><td>&nbsp</tr>
                      <tr style="font-size: 20px;color:#0080FF;font-weight:bold;"><td>Total:</td><td align="right"><input type='numeric' id='total' step='0.01' name='total' readonly="yes" size='5'></tr>
                    </table>
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
                <th bgcolor='#FFBF00' style='color: #0080FF' width='3%'><b><center>#</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='12%'><b><center>Tipo</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='5%'><b><center>Sec.</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='10%'><b><center>Obligación</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='15%'><b><center>Valor</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='15%'><b><center>Pagado</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='15%'><b><center>Pendiente</center></b></th>
                <th bgcolor='#0080FF' style='color: #FFBF00' width='15%'><b><center>Fecha Pago</center></b></th>
                <th bgcolor='#FFBF00' style='color: #0080FF' width='15%'><b><center>Seleccionar</center></b></th>
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
              var criterio1= document.getElementById('IdRepresentante').value;
              var criterio2= document.getElementById('IdEstudiante').value;

              $.ajax({
                url: 'getObligaciones.php',
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
                    html="<tr ><td>"+contador+"</td>"+    
                        "<td><input type='text' value='"+data.data[i].NombreObligacion+"' id='TipoObligacion"+contador+"' name='TipoObligacion"+contador+"' size=12 class='sinborde' readonly></td>"+
                        "<td><input type='text' value='"+data.data[i].Secuencia+"' id='Secuencia"+contador+"' name='Secuencia"+contador+"' size=3 readonly class='sinborde'></td>"+
                        "<td><input type='text' value='"+data.data[i].DescripcionObligacion+"' id='NombreObligacion"+contador+"' name='NombreObligacion"+contador+"' size=9 readonly class='sinborde'</td>"+
                        "<td><input type='text' value='"+data.data[i].Valor+"' id='Valor"+contador+"' size=4 name='Valor"+contador+"' readonly class='sinborde'></td>"+
                        "<td><input type='text' value='"+data.data[i].valorPagado+"' id='ValorPagado"+contador+"' name='ValorPagado"+contador+"' size=4 readonly class='sinborde'></td>"+
                        "<td><input type='text' value='"+data.data[i].valorPendiente+"' id='ValorPendiente"+contador+"' name='ValorPendiente"+contador+"' size=4 readonly class='sinborde'></td>"+
                        "<td><input type='text' value='"+fechaPago+"' id='FechaPago"+contador+"' name='FechaPago"+contador+"' size=7 readonly class='sinborde'></td>"+
                        "<td><input type='checkbox' id='chkbox"+contador+"' value='1' name='chkbox"+contador+"' onchange='calculos(this);'></td></tr>";
                        //alert(document.getElementById('TipoObligacion1').value);
                          $('#respuesta').append(html);                        
                  }

                } 
              })
              .done(function() {
                console.log("success");
              })
              .fail(function(xhr,tst,err) {
                console.log("error");
                alert(xhr.status + err);
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

   