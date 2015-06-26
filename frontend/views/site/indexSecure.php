

<?php
use kartik\date\DatePicker;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

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
     <form class="form-inline">
        <div class="form-group">
          
            <?php

                echo DatePicker::widget([
                    'name' => 'check_issue_date', 
                    'value' => date('d-M-Y', strtotime('+2 days')),
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Seleccionar Fecha'],
                    'pluginOptions' => [
                    'format' => 'dd-M-yyyy',
                    'size' => 'xs',
                    'todayHighlight' => true
                  ]
                ]);
            ?>
        </div>
     </form>
    <div id="map" class="map"></div>
      
    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.MapQuest({layer: 'sat'})
          })
        ],
        view: new ol.View({
          center: ol.proj.transform([37.41, 8.82], 'EPSG:4326', 'EPSG:3857'),
          zoom: 4
        })
      });
    </script>

</div>
