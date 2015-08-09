<?php


?>



<table id ="vehiculosTable" class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Id</th>
            <th>Matricula</th>
            <th>Limite de entregas</th>
            <th>Seleccionar</th>
            
          </tr>
        </thead>
        <tbody>
            
            
        </tbody>
</table>

<script>
    
var vehiculos = eval(<?php echo $vehiculosJson?>);
var vehiculo;    
    for (i=0; i<vehiculos.length; i++){
        
        $('#vehiculosTable tr:last').after('<tr><td id= "vehiculoId">'+vehiculos[i].ve_id+'</td><td>'+vehiculos[i].ve_matricula+
          '</td><td>'+vehiculos[i].ve_entregaslimite+'</td><td> <a onclick = "getVehiculoId()" data-dismiss="modal" class="glyphicon glyphicon-ok" style = "cursor: pointer;"></a></td></tr>');
        
    }
    
    $('td:nth-child(1),th:nth-child(1)').hide();
  

function getVehiculoId(){
    var val;
    $('#vehiculosTable').find('tr').click( function(){
       var row;
       row = ($(this).index());
       val = $('#vehiculosTable tr:eq('+row+') td:eq(0)').text();
       vehiculoId = val;
  
    });

}
    
</script>