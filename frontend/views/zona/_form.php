<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */
/* @var $form yii\widgets\ActiveForm */
?>

<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.jcarousel.pack.js"></script>
        <script type="text/javascript" src="js/func.js"></script>
        
      

        
        <style type="text/css">
        .smallmap {
        width: 929px;
        height: 300px;
        }
        </style>
        
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
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


<body>



<div id="wktwrapper">
<input type="text" id="wkt" value="">    
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
<script type="text/javascript">
function addInteraction() {
        // reset interaction:
        if(typeof drawInteraction != 'undefined') map.removeInteraction(drawInteraction);
	if(typeof selectInteraction != 'undefined') map.removeInteraction(selectInteraction);
	if(typeof modifyInteraction != 'undefined') map.removeInteraction(modifyInteraction);
        // get type:
	var type = 'Polygon';
	// Create a draw interaction and add it to the map:
	drawInteraction = new ol.interaction.Draw({ source:source, type:type });
	map.addInteraction(drawInteraction);
	// Update geometry and change mode to modify after drawing is finished:
	drawInteraction.on('drawend', function(e) {
		var feature = e.feature; 
		// remove draw interaction:
		map.removeInteraction(drawInteraction);
		// Create a select interaction and add it to the map:
		selectInteraction = new ol.interaction.Select();
		map.addInteraction(selectInteraction);
		// select feature:
		selectInteraction.getFeatures().push(feature);
		// clone feature:
		var featureClone = feature.clone();
		// transform cloned feature to WGS84:
		featureClone.getGeometry().transform('EPSG:3857', 'EPSG:4326');
		// update WKT string:
		document.getElementById("wkt").value = wkt.writeFeature(featureClone);
		// Create a modify interaction and add to the map:
		modifyInteraction = new ol.interaction.Modify({
			features: selectInteraction.getFeatures()
		});
		map.addInteraction(modifyInteraction);  
		// set listener to update geometry when feature is changed:
		feature.on('change', function() {
			// clone feature: 
		        var featureClone = feature.clone();
		        // transform cloned feature to WGS84:
		        featureClone.getGeometry().transform('EPSG:3857', 'EPSG:4326');			
			// set modified WKT string:
			modifiedWKT = wkt.writeFeature(featureClone);
			// set update trigger flag:
			triggerUpdate=true; 
		}); 
	});
}

// update WKT on mouseup when geometry was modified:
document.body.onmouseup = function() {
	if(typeof modifiedWKT != 'undefined' && triggerUpdate)	{
		// update WKT string:
		document.getElementById("wkt").value = modifiedWKT;
		// unset update trigger flag:
		triggerUpdate=false;
	}
};

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
 
<div class="zona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'z_id')->textInput() ?>

    <?= $form->field($model, 'z_nombre')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'z_zona')->textInput() ?>

    <?= $form->field($model, 'z_wkt')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>


</div>

 <div id="map"></div>

                 
               <div id="main">
                  <div id="content" class="left">
                    <div class="highlight">

                    <table width="80%">
                            <tr>
                                <td align="center">
                                    <button type="button" id="crearFeature"  class="btn btn-primary" autocomplete="off" onclick="activarDrawFeacture()" >
                                        Crear Zona
                                    </button>    
                                    
                                </td>
                            <td align="center">
                                    <button type="button" id="editarFeature"  class="btn btn-primary" autocomplete="off" onclick="activarModifyFeacture()" >
                                        Editar Zona
                                    </button> 
                                    
                            </td>
                            
                            </tr>
                    </table>


                        
                    <p align="center"><strong>Coordenadas Zona</strong></p>
                    <div align="center">
                      <textarea name="coordenadasZona" cols="80" rows="10" id="coordenadasZona"></textarea>
                      </input>                
                    </div>  
                      </div>
                  </div>
                  <div class="cl">&nbsp;</div>
                </div>
                <div class="shadow-l"></div>
                <div class="shadow-r"></div>
                <div class="shadow-b"></div>
              </div>

            </div>
            </div>
    </body>
</html>
