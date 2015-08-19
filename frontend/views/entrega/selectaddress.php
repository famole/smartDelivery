<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<?php
use kartik\sidenav\SideNav;
use frontend\enum\EnumPinType;

$this->registerJsFile(Yii::$app->request->BaseUrl . '/js/alert.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->title = 'Seleccionar Direccion';
$this->params['breadcrumbs'][] = ['label' => 'Entregas', 'url' => ['index']];
?>
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>

 
<style>
  .map {
    height: 80%;
    width: 90%;
  }
  
  .inline-button{
    margin-top:20px;
  }
</style>

<div id="alert" class="msg-top"></div>
<div id="main" class="row">
    <?php
        if(count($items>0)){
            echo '<h4>No  fue posible resolver la direcci&oacute;n<small><br>Seleccione la ubicaci&oacute;n exacta en el mapa o una direcci&oacute;n de la lista</small></h4>';
            echo '<div class="col-md-8"><div id="map"></div></div>';
            echo '<div class="col-md-4">';
            echo SideNav::widget([
                'type' => SideNav::TYPE_DEFAULT,
                'encodeLabels' => false,
                'heading' => "Direcciones",
                'containerOptions' => ['id'=>'vhmenu'],
                'items' => $items,
            ]);
            echo '</div>';
            
        }else{
            echo '<h4>No  fue posible resolver la direcci&oacute;n<small><br>Seleccione la ubicaci&oacute;n exacta en el mapa</small></h4>';
            echo '<div class="map" id="map"></div>';
        }
    ?>
</div>

<div id="buttons" clas="row">
    <div class="form-inline" >
        <div class="form-group">
            <a id="confirm" tabindex="0" class="btn btn-success btn-sm inline-button" role="button" placement="top" data-toggle="popover" data-trigger="focus" title="Confirmar" data-content="Para confirmar los cambios es necesario seleccionar una direcci&oacute;n o la ubicaci&oacute;n en el mapa.">Confirmar</a>       
        </div>
        <div class="form-group">
            <div id="resetSelection" class="inline-button"><button id="removeLocation" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-screenshot"></span> Corregir Selecci&oacute;n</button></div>
        </div>
    </div>
</div>

<script>
    $('#resetSelection').hide(); 
    
    $(document).ready(function(){
        var idEntrega = eval(<?php echo $id;?>);
        var defLat = eval(<?php echo $deflat;?>);
        var defLon = eval(<?php echo $deflon;?>);
        var pinType = <?php echo '"' .EnumPinType::Blue . '"';?>;
        var jsonList = <?php echo $address;?>;
        var map = createNiceMap(defLat,defLon,14,'map');
        var source = new ol.source.Vector();
        var drawInteraction = addInteractionPoint(map, source);
        var pointLayer;
        var drawend;
        var globalLat;
        var globalLon;
        
        //Draw point based on list of address.
        $("li").click(function(){
            if(!drawend){
                var listId=this.id;

                pointLayer = addLocation(map, jsonList[listId]["lat"],jsonList[listId]["long"], pinType);
                map.removeInteraction(drawInteraction);
                $('#resetSelection').show();
                drawend = true;
                globalLat=jsonList[listId]["lat"];
                globalLon=jsonList[listId]["long"];
            }
        });
        
        //Remove location button click event.
        $("#removeLocation").click(function(){
            map.removeLayer(pointLayer);
            $('#resetSelection').hide();
            map.addInteraction(drawInteraction);
            drawend = false;
        });
        
        //After draw point
        drawInteraction.on('drawend', function(e) {
            var feature = e.feature; 

            // remove draw interaction:
            map.removeInteraction(drawInteraction);

            //Enable button to remove interaction and reenable it.
            $('#resetSelection').show();

            // clone feature:
            var featureClone = feature.clone();
            // transform cloned feature to WGS84:
            featureClone.getGeometry().transform('EPSG:3857', 'EPSG:4326');
            // update WKT string:
            var wktwriter2=new ol.format.WKT();
            var wkt3=wktwriter2.writeFeature(featureClone);
            
            var latlon = getLatLonFromPoint(wkt3);
            //draw point on map.
            pointLayer = addLocation(map, latlon[0], latlon[1],pinType);
            drawend = true;
            globalLat = latlon[0];
            globalLon = latlon[1];
                
        });
        
        $("#confirm").click(function(){
            
            if(drawend){
                //send address
                $('#confirm').popover('hide');
                
                $.get('index.php?r=entrega/save-lat-lon', {id : idEntrega,lat: globalLat, lon: globalLon}, function(data){
                    
                    showMessage('error', data, true);
                    
                });
            }else{
                $('#confirm').popover('show');
            }
        });
    });
</script>
