<?php


?>



<table id ="personalTable" class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Seleccionar</th>
            
          </tr>
        </thead>
        <tbody>
            
            
        </tbody>
</table>

<input type="text" id="out">

<button type="button" class="btn btn-success" onclick="getSelectedPersonal()">Guardar</button>

<script>
    
var vehiculos = eval(<?php echo $vehiculosJson?>);
var vehiculo;    
    for (i=0; i<vehiculos.length; i++){
        
        $('#personalTable tr:last').after('<tr><td id= "personalID">'+vehiculos[i].ve_id+'</td><td>'+vehiculos[i].ve_matricula+
          '</td><td>'+vehiculos[i].ve_entregaslimite+'</td><td><input type="checkbox" name = "check"></td></tr>');
        
    }
    
    $('td:nth-child(1),th:nth-child(1)').hide();
    
$('#personalTable tr').filter(':has(:checkbox:checked)').each(function() {
 $('#out').append($(this).index());
});
  

function getVehiculoId(){
    var val;
    $('#vehiculosTable').find('tr').click( function(){
       var row;
       row = ($(this).index());
       val = $('#vehiculosTable tr:eq('+row+') td:eq(0)').text();
       vehiculoId = val;
  
    });
}
function getSelectedPersonal(){
    $('#personalTable tr').filter(':has(:checkbox:checked)').each(function() {
        var row = ($(this).index());
        console.log(row);
        val = $('#vehiculosTable tr:eq('+row+') td:eq(0)').text();
        personal.push(val);
    
    });

}
    
</script>