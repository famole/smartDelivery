<?php


?>



<table id ="personalTable" class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Seleccionar</th>
            
          </tr>
        </thead>
        <tbody>
            
            
        </tbody>
</table>

<button type="button" class="btn btn-success" onclick="getSelectedPersonal()" data-dismiss="modal">Guardar</button>

<script>
    
var personal = eval(<?php echo $personalJson?>);
selectedPersonal =[];
    for (i=0; i<personal.length; i++){
        
        $('#personalTable tr:last').after('<tr><td id= "personalID">'+personal[i].per_id+'</td><td>'+personal[i].per_nom+
          '</td><td>'+personal[i].per_priape+'</td><td>'+personal[i].per_tel+'</td><td><input type="checkbox" name = "check"></td></tr>');
        
    }
    
    $('td:nth-child(1),th:nth-child(1)').hide();


  


function getSelectedPersonal(){
    $('#personalTable tr').filter(':has(:checkbox:checked)').each(function() {
        var row = ($(this).index());
        console.log(row);
        val = $('#personalTable tr:eq('+row+') td:eq(0)').text();
        selectedPersonal.push(val);
        console.log(selectedPersonal);
    
    });
    

}
    
</script>