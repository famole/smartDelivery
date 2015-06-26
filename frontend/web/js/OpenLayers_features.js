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
            var wktwriter=new OpenLayers.Format.WKT();
            var wkt=wktwriter.write(obj.feature);
            var geom = obj.feature.geometry;
            //var geom2 = wktwriter.writeGeometry(obj.feature);
            
          //  poly.push(wkt);
            
            $('#zona-z_zona').val("geom");
            console.log(geom);
            console.log(wkt);
            //console.log(geom2);
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
    var geoJSON = new OpenLayers.Format.GeoJSON();
    var geometry = geoJSON.read(str, 'Geometry');
    console.log(geometry);
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