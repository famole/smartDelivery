<?php

use kartik\sidenav\SideNav;
use kartik\date\DatePicker;

$this->registerJSFile("https://code.jquery.com/jquery-1.11.2.min.js");
$this->registerJSFile("http://openlayers.org/en/v3.0.0/build/ol.js");
$this->registerJSFile("js/OpenLayers.js");
$this->registerJSFile("js/mapHelper.js");

?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.6.0/ol.css" type="text/css">
</head>

<div class="row">
    <div class="col-sm-3">

        <div class="form-group">
            <?php

                  echo DatePicker::widget([
                      'name' => 'fecha', 
                      'value' => date('d-M-Y', time()),
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'pluginEvents' => ["changeDate" => "function(e) {  console.log(e.date); }",],
                      'options' => ['placeholder' => 'Seleccionar Fecha'],
                      'pluginOptions' => [
                      'format' => 'dd-M-yyyy',
                      'size' => 'xs',
                      'todayHighlight' => true,
                      'autoclose'=>true
                    ]
                  ]);
              ?>
        </div>

        <div class="form-group">
          <input type="text" id="searchVehicle" placeholder="Filtrar" class="form-control">
        </div>


    </div>
    <div id="mapV" class="col-md-9 guide-content">
    </div>
</div>

    

<?php
$script = <<< JS
   // $( document ).ready(function() {
        //Dibujar mapa 
        var map = createMap(-6252731.917154272,-4150822.2589118066,13,'mapV');
        
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
    //}); 
JS;
$this->registerJs($script);
?>