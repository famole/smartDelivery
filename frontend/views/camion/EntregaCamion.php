<?php

$url = "'".Yii::$app->getUrlManager()->hostInfo . Yii::$app->getUrlManager()->baseUrl."'";
//$date = date_create($fecha); 
//$date = date_format($date, 'd-m-Y');
//Yii::error('date camion: '.$date);
$stringDate = "'".$fecha."'";
//Yii::error('fecha camion: '.$stringDate);
?>


<div id="camionContainer">
    <table id ="entregaTable" class="table table-striped table-bordered table-hover table-condensed">
            <thead>
              <tr>
                <th>Id</th>
                <td id="entregaID"></td>
    <!--            <th>Apellido</th>
                <th>Telefono</th>
                <th>Seleccionar</th>-->

              </tr>
              <tr>
                  <th>Dirección</th>
                  <td id="entregaDireccion"></td>
              </tr>

              <tr>
                  <th>Estado</th>
                  <td id="entregaEstado"></td>
              </tr>

            </thead>
            <tbody>


            </tbody>
    </table>
</div>    
<textarea id="idEntrega" style="display:none;"> test </textarea>

<button type="button" class="btn btn-success" onclick="updateEntregaEstado('Entregado')" data-dismiss="modal">Entregado</button>
<button type="button" class="btn btn-danger" onclick="updateEntregaEstado('Cancelado')" data-dismiss="modal">Cancelado</button>
<script>
    var url = <?php echo $url ?>;
    var vehiculoId = eval(<?php echo $vehiculoId; ?>) ; 
    
   
    $(document).ready(function(){
       
    
//    $('#entregaTable tr:last').after('<tr><td id= "personalID">'+'aaa'+'</td><td>'+'aa'+
//          '</td><td>'+'aaaa'+'</td><td>'+val+'</td><td><input type="checkbox" name = "check"></td></tr>');
    
    });
    
    function updateEntregaId(){
        var id = $('#idEntrega').val();     
        console.log(id);
        $.get('index.php?r=camion/get-entrega', {idEntrega : id }, function(data){  
        console.log(data);
        console.log(data['direccion']);
        $('#entregaTable #entregaID').html(id);
        $('#entregaTable #entregaDireccion').html(data['direccion']);
        $('#entregaTable #entregaEstado').html(data['estado']);

        
        
        },"json ");
        //$('#entregaTable').find('th').eq(0).after('<th>'+id+'</th>');

    };
    
    function updateEntregaEstado(estado){
        
         
        var entregaId = $('#idEntrega').val();  
        $.get('index.php?r=camion/set-estado-entrega', {entregaId : entregaId,estado:estado }, function(data){  
               $(location).attr('href', url +'/index.php?r=camion/camion&vehiculoId='+vehiculoId+'&fecha='+<?php echo $stringDate;?>);
        },"json ");
        
        $('ul').find('#'+entregaId).remove();
         entregas.splice(0, 1);
         console.log(repartoId);
         if (entregas.length == 0){
             $.get('index.php?r=camion/update-estado-reparto', {repartoId : repartoId}, function(data){
                 
             
         });
         
        
        }
    }
</script>