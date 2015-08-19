<?php

use kartik\sidenav\SideNav;
use frontend\enum\EnumPinType;

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>   
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<!--<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>-->
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.7.0/ol.js"></script>
<script type="text/javascript" src="js/sortable/Sortable.js"></script>

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
    <div class ="col-md-2">
     <?php   
     $items = array();
     Yii::error($SideNavItems);
     echo SideNav::widget([
                'type' => SideNav::TYPE_DEFAULT,
                'encodeLabels' => false,
                'heading' => "Entregas",
                'containerOptions' => ['id'=>'vhmenu'],
                'items' => $SideNavItems,
            ]);
     ?>
    </div>
    <div class ="col-md-10">
        <div id="map">
            
                
        </div>
    </div>
</div>

<script type="text/javascript">

var entregas = eval(<?php echo $entregasJson; ?>) ; 
var pinType = <?php echo '"' .EnumPinType::Yellow. '"';?>;

var map = createMap(-6252731.917154272,-4150822.2589118066,14,'map');
for (indice = 0; indice < entregas.length; ++indice) {
       
    var point = new OpenLayers.LonLat(entregas[indice].lon,entregas[indice].lat);
    var point2 = point;
    point2.transform('EPSG:4326','EPSG:3857');
    console.log(point2.lon);
    console.log(point2.lat);
    var pointLayer = dibujarIcono(point2.lon,point2.lat,entregas[indice],pinType);
    map.addLayer(pointLayer);

} 



</script>