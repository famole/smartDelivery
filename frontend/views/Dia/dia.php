<?php
    use frontend\models\zona;
    
    
    $model = new zona();
    $nullId = 0;
    $rows = Zona::find()
    ->where('z_id > :nullId',[':nullId' => $nullId])
    ->orderBy('z_id')
    ->all();
    $count = count($rows);
    echo Yii::trace('123');
    echo Yii::trace($count);
        
?>

<script>
    var countt = "<?php echo $count; ?>" ;
    console.log(countt);
</script>>
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<style>
  .map {
    height: 400px;
    width: 100%;
  }
</style>
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>


<div class="container">
      <input type="text" class="form-control" placeholder="Text input">
     
    <div id="map" class="map"></div>
      
    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.transform([37.41, 8.82], 'EPSG:4326', 'EPSG:3857'),
          zoom: 4
        })
      });
    </script>

</div>
