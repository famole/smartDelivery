<?php
    use frontend\models\zona;
    
//    $zonas= array();
//    $model = new zona();
//    $nullId = 0;
//    $rows = Zona::find()
//    ->select('z_wkt')
//    ->where('z_id > :nullId',[':nullId' => $nullId])
//    ->orderBy('z_id')
//    ->all();
//    
//    for ($index = 0; $index < count($rows); ++$index) {
//        $zonas[$index] = $rows[$index]->z_wkt;
//        
//    }
//    $zonasJson = json_encode($zonas);
       
?>


<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
<style>
  .map {
    height: 400px;
    width: 100%;
  }
</style>
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>


<div class="container">
      
     
    <div id="map" class="map"></div>
      
 </div>   
    
<script type="text/javascript">
    
    var indice;
    var poligonos = eval(<?php echo $zonasJson; ?>) ;
       
    var map = createMap(-6252731.917154272,-4150822.2589118066,14,'map');
    
    for (indice = 0; indice < poligonos.length; ++indice) {
        
        var latlongfeature= createLayer(poligonos[indice]);
        map.addLayer(latlongfeature.vector);

//        
//        var vector = new ol.layer.Vector({
//          source: new ol.source.Vector({
//            features: [feature]
//          }),
//          style: new ol.style.Style({
//              stroke: new ol.style.Stroke({color: 'red', width: 2}),
//              fill: new ol.style.Fill({color:'green'})
//            }),
//          opacity:0.5,
//         
//        });

    }

 </script>

