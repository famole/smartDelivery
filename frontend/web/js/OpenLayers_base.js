var mapa,capa,controls,markers;
var centerWGS84, centerOSM;
var projWGS84, projSphericalMercator;
var activarMensaje=0,activarMarcadores=0;
function iniciar()
{
	//Para tener coordenadas estandar
	projWGS84 = new OpenLayers.Projection("EPSG:4326");
	projSphericalMercator = new OpenLayers.Projection("EPSG:900913");
	//Centrar el mapa en el punto dado	
	centerWGS84=new OpenLayers.LonLat(-56.16341,-34.90721);
	//Transformar coordenadas anteriores
	centerOSM = transformToSphericalMercator(centerWGS84);
	//Creacion del mapa
	mapa=new OpenLayers.Map("mapa");
	//Creacion de capas
	capa=new OpenLayers.Layer.OSM("Capa OSM");
	markers= new OpenLayers.Layer.Markers( "Marcadores" );
	//Adicion de capas al mapa
	mapa.addLayer(capa);
	mapa.addLayer(markers);
	//Centro el mapa en la posicion dada
	mapa.setCenter(centerOSM, 15);
	//Adicion de controles al mapa	
	//Evento para el movimiento del mouse
	mapa.events.register("mousemove", mapa, mouseMoveHandler);
	//Control para el click del mouse en el mapa
	var click = new OpenLayers.Control.Click();
    mapa.addControl(click);
    click.activate();
	mapa.addControl(new OpenLayers.Control.LayerSwitcher());
}
//Funcion que registrar el movimiento del mouse
function mouseMoveHandler(e) 
{
    var position = this.events.getMousePosition(e);
    var lonlat = mapa.getLonLatFromPixel(position);
	//Tras obtener las coordenadas, podemos hacer lo que deseemos
    
	$("#coordenadas").attr('value','Evento MouseMove: '+transformMouseCoords(lonlat));
	

}

function transformMouseCoords(lonlat) 
{
        	var newlonlat=transformToWGS84(lonlat);
			var x = Math.round(newlonlat.lon*10000)/10000;
			var y = Math.round(newlonlat.lat*10000)/10000;
			newlonlat = new OpenLayers.LonLat(x,y);
			return newlonlat;
}
function transformToWGS84( sphMercatorCoords) 
{
        	// Transforma desde SphericalMercator a WGS84
        	// Devuelve un OpenLayers.LonLat con el pto transformado
        	var clon = sphMercatorCoords.clone(); // Si no uso un clon me transforma el punto original
        	var pointWGS84= clon.transform(
                    new OpenLayers.Projection("EPSG:900913"), // to Spherical Mercator Projection;
        			new OpenLayers.Projection("EPSG:4326")); // transform from WGS 1984
        	return pointWGS84;
}
function transformToSphericalMercator( wgs84LonLat) 
{
        	// Transforma desde SphericalMercator a WGS84
        	// Devuelve un OpenLayers.LonLat con el pto transformado
        	var clon = wgs84LonLat.clone(); // Si no uso un clon me transforma el punto original
        	var pointSphMerc= clon.transform(
                    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                    new OpenLayers.Projection("EPSG:900913")); // to Spherical Mercator Projection;
        	return pointSphMerc;
}
//Es un evento que se activa cuando se da clic sobre el mapa
OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, 
{                
     defaultHandlerOptions: 
	 {
        'single': true,
        'double': false,
        'pixelTolerance': 0,
        'stopSingle': false,
        'stopDouble': false
     },
	initialize: function(options) 
	{
        this.handlerOptions = OpenLayers.Util.extend({}, this.defaultHandlerOptions);
        OpenLayers.Control.prototype.initialize.apply(this, arguments); 
        this.handler = new OpenLayers.Handler.Click(this,{'click': this.trigger}, this.handlerOptions);
    }, 
	trigger: function(e) 
	{
        //Convierto la posicion del mouse, a coordenadas
		var lonlat = mapa.getLonLatFromPixel(e.xy);
		//Luego de obtener las coordenadas, podemos hacer lo que deseemos, en este caso, para mantener la compatibilidad con los ejemplos anteriores, se crea variables para saber que hacer al momento de dar un click, si se muestra un mensaje o se agrega un marcador
		if(activarMensaje==1){
			alert("Evento MouseClick: "+transformMouseCoords(lonlat));
		}
		//INICIO AGREGAR MARCADORES
		if(activarMarcadores==1)
		{
			var htmlStr='<div style="height: 200px; width: 400px; border: 1px 	solid black;"> Titulo</br> Contenido, puedo digitar lo que desee y lo mejor es que puede ser codigo html, asi que podemos colocar imagenes, fondos, links, etc </div>';
			//Esta funcion se encuentra en el archivo OpenLayers_marcadores
			agregarMarcador(lonlat.lon,lonlat.lat,htmlStr,true,true);
		}
		//FIN AGREGAR MARCADORES
		
    }
});