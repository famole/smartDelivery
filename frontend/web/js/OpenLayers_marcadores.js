//Variable para determinar el tamaño de los popup
	AutoSizeAnchoredMinSize = OpenLayers.Class(OpenLayers.Popup.Anchored, {
            'autoSize': true, 
            'minSize': new OpenLayers.Size(400,400)
        });
		
//Se encarga de agregar un marcador en la posicion dada
/**
Longitud: Longitud en el mapa
Latitud: Latitud en el mapa
MensajeHtml: Codigo html que se mostrara en el popup
*/
function agregarMarcador(longitud,latitud,mensajeHtml,closeBox,overflow)
{
	ll = new OpenLayers.LonLat(longitud,latitud);
	var popupClass = AutoSizeAnchoredMinSize;
	var popupContentHTML = mensajeHtml;
	
	var feature = new OpenLayers.Feature(markers, ll); 
    feature.closeBox = closeBox;
    feature.popupClass = popupClass;
    feature.data.popupContentHTML = popupContentHTML;

	
    feature.data.overflow = (overflow) ? "auto" : "hidden";
                    
    var marker = feature.createMarker();

    var markerClick = function (evt) {
    if (this.popup == null) 
	{
        this.popup = this.createPopup(this.closeBox);
        mapa.addPopup(this.popup);
        this.popup.show();
    } else {
        this.popup.toggle();
    }
		currentPopup = this.popup;
		OpenLayers.Event.stop(evt);
    };
    marker.events.register("mousedown", feature, markerClick);
	markers.addMarker(marker);
}

		
