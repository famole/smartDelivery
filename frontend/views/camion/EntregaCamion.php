<?php


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

              </tr>

              <tr>
                  <th>Estado</th>

              </tr>

            </thead>
            <tbody>


            </tbody>
    </table>
</div>    
<textarea id="idEntrega" style="display:none;"> test </textarea>

<button type="button" class="btn btn-success" onclick="getSelectedPersonal()" data-dismiss="modal">Entregado</button>
<button type="button" class="btn btn-danger" onclick="getSelectedPersonal()" data-dismiss="modal">Cancelado</button>
<script>
    
    
    
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
        $('#entregaTable #entregaID').val(id);
//        $('#entregaTable').find('th').eq(1).after('<td>'+data['direccion']+'</td>');
//        $('#entregaTable').find('th').eq(2).after('<td>'+data['estado']+'</td>');
        
        
        },"json ");
        //$('#entregaTable').find('th').eq(0).after('<th>'+id+'</th>');

    };
</script>