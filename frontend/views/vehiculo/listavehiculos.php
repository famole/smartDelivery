<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;
use yii\widgets\Pjax;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

  <div class="col-sm-3">
    
      <div class="form-group">
      <input type="text" id="searchVehicle" placeholder="Filtrar" class="form-control">
      
      </div>
      
      <div id="pjax" class="form-group">
          
      </div>
     
      
      <div class="form-group">
        <?php
            echo SideNav::widget([
               'type' => SideNav::TYPE_DEFAULT,
               'encodeLabels' => false,
               'heading' => "Vehiculos",
               'containerOptions' => ['id'=>'vhmenu'],
               'items' => $items,

            ]);
        ?>
      </div>
  </div>

<?php
$script = <<< JS
    //Filtrar Vehiculos
    $('#searchVehicle').on('input', function(e) {
        //ajax metodo que arma el menu en la busqueda
        
        var filter = $(this).val();
        $.get('index.php?r=vehiculo/get-vehiculo-by', {filter : filter}, function(data){  
            console.log(data);
            
            $('#vhmenu').each(function(){
                $(this).find('li').each(function(){
                    if (this.id != 'Todos'){
                        $(this).closest('li').remove();                        
                    }
                });
        
                $(this).find('ul').each(function(){
                    for(var i=0;i<data.length;i++){
                        var row = '<li id="' + data[i].ve_id + '"><a href="#"><span class="glyphicon glyphicon-map-marker"></span>' + data[i].ve_matricula + '(' + data[i].ve_movil + ')</a></li>';
                        $(this).append(row);
                    }
                });
            });
        },"json ");
    });
JS;
$this->registerJs($script);
?>