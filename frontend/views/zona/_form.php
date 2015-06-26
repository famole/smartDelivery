<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */
/* @var $form yii\widgets\ActiveForm */
?>

<html>
    <head>
       <link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
       <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
        <script src="js/OpenLayers_features.js" type="text/javascript"></script>
       <meta charset="utf-8">


        <style>
        html              { width:100%; height:100%; margin:0; }
        body              { width:100%; height:100%; margin:0; font-family:sans-serif; }
        #map              { width:100%; height:100%; margin:0; }
        #wktwrapper       { position:absolute; display:block; bottom:20px; left:50px; right:50px; z-index:2000; }
        #wkt              { border:2px solid red; width:100%; }
        #toolbox          { position:absolute; top:8px; right:8px; padding:3px; border-radius:4px; color:#fff; background: rgba(255, 255, 255, 0.4); z-index:100; }
        #drawtoolswitcher { margin:0; padding:10px; border-radius:4px; background:rgba(0, 60, 136, 0.5); list-style-type:none; } 
        </style>
    </head>
    
<div class="zona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'z_id')->textInput() ?>

    <?= $form->field($model, 'z_nombre')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'z_zona')->textInput() ?>

    <?= $form->field($model, 'z_wkt')->textarea(['rows' => 6]) ?>
    
    <div id="map"></div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>







<script type="text/javascript">

    var rasterLayer = new ol.layer.Tile({ source: new ol.source.MapQuest({layer: 'sat'}) });
    var source = new ol.source.Vector();
    var vectorLayer = new ol.layer.Vector({	source:source });
    var wkt = new ol.format.WKT();

    var map = new ol.Map({
      target: 'map',
      controls: ol.control.defaults().extend([ new ol.control.ScaleLine({ units:'metric' }) ]),
      layers: [ rasterLayer, vectorLayer ],
      view: new ol.View({
        center: ol.proj.transform([0,10], 'EPSG:4326', 'EPSG:3857'),
        zoom: 3
      })
    });


    addInteraction();
    $("input[name=type]").change(function() { 
            vectorLayer.getSource().clear();
            document.getElementById("wkt").value = "";
            addInteraction();
    });

</script>
</body>
</html>

