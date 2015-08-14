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
        maxResolution : 'auto',
        minResolution : 'auto',
        projection: new OpenLayers.Projection("EPSG:900913"),//EPSG:900913
        view: new ol.View({
          center: [lat, long],
          zoom: pzoom
        })
    });
    
    return map;
}

function createNiceMap(lat, lon, pzoom, ptarget){
    var rasterLayer = new ol.layer.Tile({ source: new ol.source.MapQuest({layer: 'osm'}) });
    var source = new ol.source.Vector();
    var vectorLayer = new ol.layer.Vector({	source:source });
    var wkt = new ol.format.WKT();

    var map = new ol.Map({
    target: ptarget,
    controls: ol.control.defaults().extend([ new ol.control.ScaleLine({ units:'metric' }) ]),
    layers: [ rasterLayer, vectorLayer ],
        view: new ol.View({
            center: [lat,lon],
            zoom: pzoom
        })
    });
    
    return map;
}
function createLayer(zona){
    var format = new ol.format.WKT();
    var feature = format.readFeature(zona.wkt);
    feature.getGeometry().transform('EPSG:4326', 'EPSG:3857');

    var vector = new ol.layer.Vector({
        source: new ol.source.Vector({
        features: [feature]
        })
    });
    feature.set("Id",zona.z_id);
    feature.set("Nombre",zona.z_nombre);
    
    var content = "<b>ZonaId</b>"+": "+zona.z_id +"<br>" +"<b>Nombre</b>"+": " + zona.z_nombre;
    feature.set("content",content);
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
  
function displayMap(map){
    return map.display();
}
  
  function dibujarIconoSimple(lat,long){
    var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point([lat,long]),
//        geometry:new ol.geom.Point(ol.proj.transform([lat, long], 'EPSG:3857',     
//        'EPSG:4326')),
        name: 'test',
        
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
  
 function dibujarIcono(lat,long,entrega){
    
     var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point([lat,long]),
//        geometry:new ol.geom.Point(ol.proj.transform([lat, long], 'EPSG:3857',     
//        'EPSG:4326')),
        name: entrega.entrega,
        
        population: 4000,
        rainfall: 500
      });
      
      iconFeature.set("direccion",entrega.direccion);
      iconFeature.set("estado",entrega.estado);
      var estado;
      switch (entrega.estado){
        case "Pendiente":
            estado = "<code><b>"+iconFeature.get('estado') + "</b></code>" ;
            break;
        case "Entregado":
            estado = "<font color='green'>"+"<b>"+iconFeature.get('estado')+"</b></font>";
            break;
      }
      var content = "<b>Cliente</b>"+": "+iconFeature.get('name') +"<br>" +"<b>Dirección</b>"+": "+ iconFeature.get('direccion')
              +"<br>"+ "<b>Estado</b>"+": "+estado;
      iconFeature.set("content",content);
      
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
 
 function popup(map) {
     
     //******** Resaltar zona que se selecciona *****************************************
     
     var selectAltClick = new ol.interaction.Select({
        condition: function(mapBrowserEvent) {
          return ol.events.condition.click(mapBrowserEvent) &&
              ol.events.condition.altKeyOnly(mapBrowserEvent);
        }
    });
    
    var changeInteraction = function() {
        var select = selectAltClick;
        if (select !== null) {
            map.addInteraction(select);
            }
    };

    changeInteraction();
    //***********************************************************************************
    
    //******************* Crear Popup con info ******************************************
     var element = document.getElementById('popup');
     var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false
      });
      
      map.addOverlay(popup);
      
      // display popup on click
      map.on('click', function(evt) {
      
      var feature = map.forEachFeatureAtPixel(evt.pixel,
          function(feature, layer) {
            return feature;
          });
      if (feature) {
        var direccion = feature.get('direccion');
        var estado = feature.get('estado');
        
        var content;
        var geometry = feature.getGeometry();
        var coord; 
        var geomType = geometry.getType();
        
        switch(geomType){
            case "Polygon":
                coord = geometry.getCoordinates()[0][0];
                content =  feature.get('content');
                             
                break;
            case "Point":
                coord = geometry.getCoordinates();
                content =  feature.get('content');
                console.log(content);
                 
                break;
            
        }
        //console.log(coord);
        popup.setPosition(coord);
        $(element).attr( 'data-placement', 'top' );
        
        $(element).attr( 'data-content', content);
        
        $(element).attr( 'data-html', true );
        $(element).popover();
        
        $(element).popover('show');
      } else {
        $(element).popover('destroy');
      }
    });
      
      // change mouse cursor when over marker
    map.on('pointermove', function(e) {
      if (e.dragging) {
        $(element).popover('destroy');
        return;
      }
      var pixel = map.getEventPixel(e.originalEvent);
      var hit = map.hasFeatureAtPixel(pixel);
     // map.getTarget().style.cursor = hit ? 'pointer' : '';
    });  
     
     
 }

function PointsInZone(entregas,vectors,map,feature){
    
    var ret = new Array();
    if (feature){
        for (index = 0; index < vectors.length; index++){

            if(vectors[index].getSource().getFeatures()[0].get("Id") == feature.get("Id")){
                for (indice = 0; indice < entregas.length; indice++) {
                    var point = new OpenLayers.LonLat(entregas[indice].lon,entregas[indice].lat);
                    var point2 = point;
                    point2.transform('EPSG:4326','EPSG:3857');
                    var pointLayer = dibujarIcono(point2.lon,point2.lat,entregas[indice]);
                    var inside2 =vectors[index].getSource().getFeaturesAtCoordinate(pointLayer.getSource().getFeatures()[0].getGeometry().getCoordinates()); 
                    if (inside2.length >0){
                        console.log("Zona: "+vectors[index].getSource().getFeatures()[0].get("Nombre") + " - PointId:"+ pointLayer.getSource().getFeatures()[0].get('name') + " - Direccion:"+pointLayer.getSource().getFeatures()[0].get('direccion'));
                        var zp = {};
                        zp.z_id =  vectors[index].getSource().getFeatures()[0].get("Id");
                        zp.ent_id = pointLayer.getSource().getFeatures()[0].get('name');
                        zp.ent_dir = pointLayer.getSource().getFeatures()[0].get('direccion');
                        
                        ret.push(zp);

                    }
                }
            }  
        }
    }
    console.log(ret)      
    return ret;
}      
      //});
       
     
    
    
    


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