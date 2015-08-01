<?php

    use kartik\sidenav\SideNav;
    use kartik\date\DatePicker;
    use kartik\sortinput\SortableInput;
    use yii\helpers\Html; 
    use yii\widgets\ActiveForm;



    $fecha = date("Y-m-d");
    
    Yii::error($fecha);
    Yii::error($entregasJson);


   
?>


<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<!--<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>-->
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.7.0/ol.js"></script>
<style>
  .map {
    height: 400px;
    width: 100%;
  }
  #popup {
    padding-bottom: 45px;
    
  }
  .popover-content {
    min-width: 230px;
  }
   #scrolly{
    width: 1000px;
    height: 190px;
    overflow: auto;
    overflow-y: hidden;
    margin: 0 auto;
    white-space: nowrap
    }
</style>
            
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

       <div class="form-group">
          <?php
            echo SortableInput::widget([
                'name'=> 'sort_list_1',
                'items' => $SorteableItems,
                'hideInput' => false,
            ]);
          ?>
        </div>
    </div>
    
    <div id="map" class="col-md-9 guide-content"><div id="popup" style ="with:100px"></div></div>
    
    <div id="scrolly">
        
        <p>adadasdsddsfsfdfdsfsfdsfsfsd</p>
    </div>
</div>


<!--<div class="container">
      
     
    <div id="map" class="map"></div>

</div>   -->
    
<script type="text/javascript">
    
    // The transform funcion needs lat/long instead of long/lat
    
//    var point = new OpenLayers.LonLat(-56.1220166,-34.8370893);
//    var point2 = point;
//    point2.transform('EPSG:4326','EPSG:3857');
//    
//    console.log(point);
//    console.log(point2);
    var indice;
    var poligonos = eval(<?php echo $zonasJson; ?>) ;
    var entregas = eval(<?php echo $entregasJson; ?>) ;   
    var map = createMap(-6252731.917154272,-4150822.2589118066,14,'map');
    var vectors = new Array();
    
    for (indice = 0; indice < poligonos.length; ++indice) {
        
        var latlongfeature= createLayer(poligonos[indice]);
        map.addLayer(latlongfeature.vector);
        vectors.push(latlongfeature.vector);
        
        
    }
    
    //console.log(vectors[0].getSource().getFeatures()[0].getGeometry().getCoordinates());
    for (indice = 0; indice < entregas.length; ++indice) {
       
        var point = new OpenLayers.LonLat(entregas[indice].lon,entregas[indice].lat);
        var point2 = point;
        point2.transform('EPSG:4326','EPSG:3857');
        var pointLayer = dibujarIcono(point2.lon,point2.lat,entregas[indice]);
        for (index = 0; index < vectors.length; ++index){
          var inside =vectors[index].getSource().getFeaturesAtCoordinate( pointLayer.getSource().getFeatures()[0].getGeometry().getCoordinates());
          if (inside.length >0){
            console.log("Zona: "+vectors[index].getSource().getFeatures()[0].get("Nombre") + " - PointId:"+ pointLayer.getSource().getFeatures()[0].get('name') + " - Direccion:"+pointLayer.getSource().getFeatures()[0].get('direccion'));
              
          }
            
        } 
        map.addLayer(pointLayer);
    }
    
    
    
    popup(map);

    

    

 </script>

