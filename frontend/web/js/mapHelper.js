var drawP,editP,vectors,select,formats,poly;

//Funcion se encarga de agregar los controles para poder dibujar y editar polygonos
function iniciarDrawFeacture()
{
	//poly = new Array();
	vectors = new OpenLayers.Layer.Vector("Capa Vectorial");
	mapa.addLayer(vectors);
	drawP=new OpenLayers.Control.DrawFeature(vectors,OpenLayers.Handler.Polygon)
	mapa.addControl(drawP);
	editP= new OpenLayers.Control.ModifyFeature(vectors);
	mapa.addControl(editP);
        
        vectors.events.register('featureadded', this, function(obj){
            var feature = obj.feature;
            
            console.log(feature.getGeometry());
            var wktwriter=new OpenLayers.Format.WKT();
            var wkt=wktwriter.write(obj.feature);
            
            var geom = obj.feature.geometry;
          //  poly.push(wkt);
            $('#zona-z_zona').val(geom);
            $('#zona-z_wkt').val(geom);
            console.log(geom);
            console.log(wkt);
          //  console.log(poly.length);
        });
        
	updateFormats();
	var options = 
	{
        hover: true,
        onSelect: serialize
    };
    select = new OpenLayers.Control.SelectFeature(vectors, options);
	mapa.addControl(select);
	
}
//Esta funcion permite dibujar un feature()
function activarDrawFeacture()
{
	editP.deactivate();
	drawP.activate();
	select.activate();

}
//Esta funcion permite obtener el codigo de un poligono y mostrarlo en un string
function serialize(feature) 
{
    var type = "geojson";
    // second argument for pretty printing (geojson only)
    var pretty = 1;
    var str = formats['out'][type].write(feature, pretty);
    
    // not a good idea in general, just for this demo
    str = str.replace(/,/g, ', ');
    $("#coordenadasZona").html('Codigo Zona: '+str);
    return str;
}
//Esta funcion es para tener unos formatos estandar de codificacion
function updateFormats() 
{
		var in_options = {
                'internalProjection': mapa.baseLayer.projection,
                'externalProjection': new OpenLayers.Projection("EPSG:4326")
            };   
            var out_options = {
                'internalProjection': mapa.baseLayer.projection,
                'externalProjection': new OpenLayers.Projection("EPSG:4326")
            };
            var gmlOptions = {
                featureType: "feature",
                featureNS: "http://example.com/feature"
            };
            var gmlOptionsIn = OpenLayers.Util.extend(
                OpenLayers.Util.extend({}, gmlOptions),
                in_options
            );
            var gmlOptionsOut = OpenLayers.Util.extend(
                OpenLayers.Util.extend({}, gmlOptions),
                out_options
            );
            var kmlOptionsIn = OpenLayers.Util.extend(
                {extractStyles: true}, in_options);
            formats = {
              'in': {
                wkt: new OpenLayers.Format.WKT(in_options),
                geojson: new OpenLayers.Format.GeoJSON(in_options),
                georss: new OpenLayers.Format.GeoRSS(in_options),
                gml2: new OpenLayers.Format.GML.v2(gmlOptionsIn),
                gml3: new OpenLayers.Format.GML.v3(gmlOptionsIn),
                kml: new OpenLayers.Format.KML(kmlOptionsIn),
                atom: new OpenLayers.Format.Atom(in_options),
                gpx: new OpenLayers.Format.GPX(in_options),
                encoded_polyline: new OpenLayers.Format.EncodedPolyline(in_options)
              },
              'out': {
                wkt: new OpenLayers.Format.WKT(out_options),
                geojson: new OpenLayers.Format.GeoJSON(out_options),
                georss: new OpenLayers.Format.GeoRSS(out_options),
                gml2: new OpenLayers.Format.GML.v2(gmlOptionsOut),
                gml3: new OpenLayers.Format.GML.v3(gmlOptionsOut),
                kml: new OpenLayers.Format.KML(out_options),
                atom: new OpenLayers.Format.Atom(out_options),
                gpx: new OpenLayers.Format.GPX(out_options),
                encoded_polyline: new OpenLayers.Format.EncodedPolyline(out_options)
              }
            };
}

function activarModifyFeacture()
{
	editP.activate();
	drawP.deactivate();
	select.deactivate();
	editP.mode = OpenLayers.Control.ModifyFeature.RESHAPE;
	editP.createVertices = true;
}

function mostrarArray(){
// for (var item in poly) {
//        console.log(item);
//    }
//console.log(poly[1])
alert(poly);
}

function createMap(lat, long, pzoom, ptarget){
    var raster = new ol.layer.Tile({
        source: new ol.source.OSM()
    });
    
    var map = new ol.Map({
        layers: [raster],
        target: ptarget,
        projection: new OpenLayers.Projection("EPSG:900913"),//EPSG:900913
        view: new ol.View({
          center: [lat, long],
          zoom: pzoom
        })
    });
    
    return map;
}

function createLayer(wkt){
    var format = new ol.format.WKT();
    var feature = format.readFeature(wkt);
    feature.getGeometry().transform('EPSG:4326', 'EPSG:3857');

    var vector = new ol.layer.Vector({
        source: new ol.source.Vector({
        features: [feature]
        })
    });
    
    var lat = feature.getGeometry().getCoordinates()[0][0][0];
    var long = feature.getGeometry().getCoordinates()[0][0][1];
    var latlongfeature = new Array();
    latlongfeature.lat = lat;
    latlongfeature.long = long;
    latlongfeature.vector = vector;
    
    return latlongfeature;
}

function addLayer(map,layer){
    map.addLayer(layer);
    
  }
  
 function dibujarIcono(lat,long){
    
     var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point([lat,long]),
//        geometry:new ol.geom.Point(ol.proj.transform([lat, long], 'EPSG:3857',     
//        'EPSG:4326')),
        name: 'Null Island',
        population: 4000,
        rainfall: 500
      });
      
    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon( ({
        anchor: [0.5, 10],
        anchorXUnits: 'fraction',
        anchorYUnits: 'pixels',
        opacity: 0.75,
        src: 'images/icon2.png'
      }))
      });
      
    iconFeature.setStyle(iconStyle);
    //iconFeature.getGeometry().transform('EPSG:4326','EPSG:900913')
    var vectorSource = new ol.source.Vector({
      features: [iconFeature]
    });

    var vectorLayer = new ol.layer.Vector({
      source: vectorSource
    });
     
     return vectorLayer;
 } 



function addInteraction() {
        // reset interaction:
        if(typeof drawInteraction != 'undefined') map.removeInteraction(drawInteraction);
	if(typeof selectInteraction != 'undefined') map.removeInteraction(selectInteraction);
	if(typeof modifyInteraction != 'undefined') map.removeInteraction(modifyInteraction);
        // get type:
	var type = "Polygon";
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
                var wktwriter2=new ol.format.WKT();
                var wkt3=wktwriter2.writeFeature(featureClone);
                var geom2 = featureClone.getGeometry();
                console.log(wkt3);
                
		$('#zona-z_zona').val(wkt3);
                $('#zona-z_wkt').val(wkt3);
                
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