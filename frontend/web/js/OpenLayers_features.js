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