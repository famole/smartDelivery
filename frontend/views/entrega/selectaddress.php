<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<?php
use kartik\sidenav\SideNav;
$this->title = 'Seleccionar Direccion';
?>
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
 
<style>
/*  .map {
    height: 80%;
    width: 90%;
  }*/
</style>



<div class="container">
    <h4>No  fue posible resolver la direcci&oacute;n<small><br>Seleccione la ubicaci&oacute;n exacta en el mapa</small></h4>
    <div class="col-md-8"> 
        <div class="map" id="map"></div>
    </div>
    <div class="col-md-4">
        <?php
          echo SideNav::widget([
             'type' => SideNav::TYPE_DEFAULT,
             'encodeLabels' => false,
             'heading' => "Direcciones",
             'containerOptions' => ['id'=>'vhmenu'],
             'items' => $items,

          ]);
        ?>
    </div>
</div>

<script>
    var map=createMap(-6252731.917154272,-4150822.2589118066,14,'map');
    $(document).ready(function(){
       var jsonList = <?php echo $address;?>;
       
       $("li").click(function(){
            var listId=this.id;
            //alert(jsonList[listId]["display_name"]);
            var point = new OpenLayers.LonLat(jsonList[listId]["long"],jsonList[listId]["lat"]); 
            point.transform('EPSG:4326','EPSG:3857');
            console.log(point.lat);
            console.log(point.lon);
            var pointLayer = dibujarIcono(point.lon,point.lat,'');
            console.log(pointLayer);
            map.addLayer(pointLayer);
       }) ;
    });
</script>
