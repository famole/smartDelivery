<?php


?>



<table id ="vehiculosTable" class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Matricula</th>
            <th>Limite de entregas</th>
          </tr>
        </thead>
        <tbody>
            
            
        </tbody>
</table>

<script>
    var vehiculos = eval(<?php echo $vehiculosJson; ?>);
    for (i=0; i<vehiculos.length; i++){
        
        $('#vehiculosTable tr:last').after('<tr><td>'+vehiculos[i].ve_matricula+'</td><td>'+vehiculos[i].ve_entregaslimite+'</td></tr>');
        
    }
    
</script>