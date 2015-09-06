<?php

    use kartik\sidenav\SideNav;
    use kartik\date\DatePicker;
    use kartik\sortinput\SortableInput;
    use yii\helpers\Html; 
    use yii\widgets\ActiveForm;
    use yii\helpers\Json;
    use yii\bootstrap\Modal;
    use yii\widgets\DetailView; 
    use frontend\models\Direccion;
    use frontend\views\vehiculo\listavehiculos;
    use frontend\enum\EnumPinType;
    use yii\helpers\BaseUrl;
    
    

    $this->params['breadcrumbs'][] = ['label' => 'Repartos', 'url' => ['reparto/index']];
    $this->params['breadcrumbs'][] = 'Nuevo';
    $fecha = date("Y-m-d");
    $url = Yii::$app->request->baseUrl;
   // $url2 = Yii::$app->request->basePath;
//    $url = Yii::$app->request->baseUrl();
    Yii::Error($url);
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>   
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<!--<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>-->
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.7.0/ol.js"></script>
<script type="text/javascript" src="js/sortable/Sortable.js"></script>

<style>
  .map {
    height: 400px;
    width: 100%;
  }
  #popup {
    padding-bottom: 45px;
    
  }
  .popover-content {
    min-width: 230px;
  }
   #scrolly{
    width: 1000px;
    height: 190px;
    overflow: auto;
    overflow-y: hidden;
    margin: 0 auto;
    white-space: nowrap
    }
</style>
            
<div class="row">
    <div class="col-sm-3">

        <div class="form-group">
            <?php 
                $fecha = date_create($date); 
                $fecha = date_format($fecha, 'd-m-Y');
                $stringDate = "'".$fecha."'";
                 Yii::error('La fecha es '.$stringDate);
                  echo DatePicker::widget([
                      'name' => 'fecha', 
                      'value' => $fecha,
                      //'value' => date('d-m-Y'),
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'pluginEvents' => ["changeDate" => "function(e) {  UpdateDia(e.currentTarget.childNodes[0].value); }",],
                      'options' => array('placeholder' => 'Seleccionar Fecha','dateFormat' => 'dd-m-yyyy',),
                      'pluginOptions' => [
                      'format' => 'dd-mm-yyyy',
                      'size' => 'xs',
                      'todayHighlight' => false,
                      'autoclose'=>true
                    ]
                  ]);
              ?>
        </div>

        <div class="form-group">
          <input type="text" id="searchVehicle" placeholder="Filtrar" class="form-control">
        </div>

       <div id= "MenuContainer" class="form-group">
            <ul id="entregaList" class="list-group sortable cursor-move">
                
            </ul>
        </div>
        
        
    </div>
    

    <div id="map" class="col-md-9 guide-content"><div id="popup" style ="with:100px"></div></div>
    
</div>

<div class="row"">
  <br><br>  
</div>
  <div class="row"">
     
    <div class ="col-md-2">   
        <?php

        Modal::begin([
            'header' => '<h4 class="modal-title">Vehículos disponibles</h4>',
            'toggleButton' => ['label' => '<i class="glyphicon glyphicon-road"></i> Seleccionar vehículo', 'class' => 'btn btn-primary']
            ]);
            echo $this->render('selectVehiculo', ['vehiculosJson'=>$vehiculosJson]);

        Modal::end();
        ?>
    </div>
    <div class ="col-md-2">    
        <?php
    
            Modal::begin([
                'header' => '<h4 class="modal-title">Personal disponible</h4>',
                'toggleButton' => ['label' => '<i class="glyphicon glyphicon-user"></i> Seleccionar personal', 'class' => 'btn btn-primary','onclick' => 'VaciarPersonal()'],
                ]);
                echo $this->render('selectPersonal', ['personalJson'=>$personalJson]);

            Modal::end();
        ?>
     </div>
      
      <div class ="col-md-2">
        <button type="button" class="btn btn-success" onclick="CreateReparto(entregasZona)">Generar reparto</button>
    </div>
  </div>






<script type="text/javascript">
    
    var indice;
    var poligonos = eval(<?php echo $zonasJson; ?>) ;
    var entregas = eval(<?php echo $entregasJson; ?>) ;   
    var map = createNiceMap(-6252731.917154272,-4150822.2589118066,14,'map');
    var vectors = new Array();
    var zpoints;
    var el = document.getElementById('entregaList');
    var sortable = Sortable.create(el);
    var listItems = <?php echo json_encode($SortableItems); ?>;
    var vehiculoId;
    var entregasZona;
    var selectedPersonal = new Array();
    var ordenEntregas;
    var pinType = <?php echo '"' .EnumPinType::Yellow. '"';?>;
    var fecha;
    
    
    for (i=0; i<listItems.length; i++){        
        var row = '<li data-key="'+ listItems[i].key +'"class="list-group-item " style="cursor: pointer;"> ☰ ' + listItems[i].content + '</li>';
        $('#entregaList').append(row);
        
    }
   
    for (indice = 0; indice < poligonos.length; ++indice) {
        
        var latlongfeature= createLayer(poligonos[indice]);
        map.addLayer(latlongfeature.vector);
        vectors.push(latlongfeature.vector);
    }
    
    //console.log(vectors[0].getSource().getFeatures()[0].getGeometry().getCoordinates());
    for (indice = 0; indice < entregas.length; ++indice) {
       
        var point = new OpenLayers.LonLat(entregas[indice].lon,entregas[indice].lat);
        var point2 = point;
        point2.transform('EPSG:4326','EPSG:3857');
        console.log(point2.lon);
        console.log(point2.lat);
        var pointLayer = dibujarIcono(point2.lon,point2.lat,entregas[indice],pinType);
        map.addLayer(pointLayer);
    
    } 
       
    map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
              function(feature, layer) {
                return feature;
              });
         if (feature) {
            zpoints = PointsInZone(entregas,vectors,map,feature);
            entregasZona = zpoints;
            console.log(zpoints);
            $('#MenuContainer').each(function(){
            $(this).find('li').each(function(){
                $(this).closest('li').remove();                        
            });
        
            $('#entregaList').each(function(){
                for(var i=0;i<entregasZona.length;i++){
                    var row = '<li data-key="'+ entregasZona[i].ent_id +'"class="list-group-item " style="cursor: pointer;"> ☰ ' + entregasZona[i].ent_dir + '</li>';
                    $(this).append(row);
                }    
            });
            
        });
            
        }
    });
    
    popup(map);
    
    function test(){
        var ordenes = new Array();
        $('#MenuContainer').each(function(){
            $(this).find('li').each(function(e){
                ordenes.push($(this).data("key"));
                
            });
        });
        console.log(ordenes);
        
    }
    function CreateReparto(entregasZona){
      var parms =JSON.stringify(entregasZona);  
      var veId = JSON.stringify(vehiculoId);
      var personalIds = JSON.stringify(selectedPersonal);
      fecha = <?php echo $stringDate; ?> ;
      console.log("VehiculoId:" + veId);
      console.log(fecha);
      
      //Obtener los ordenes para las entregas.
      var ordenes = new Array();
        $('#MenuContainer').each(function(){
            $(this).find('li').each(function(e){
                ordenes.push($(this).data("key"));
                
            });
        });
       ordenEntregas = JSON.stringify(ordenes);
        
      $.get('index.php?r=dia/create-dia-reparto', {parms : parms,veId,personalIds,ordenEntregas,fecha}, function(data){  
        console.log(data); 
        },"json ");
       //console.log(entregasZona.length);  
       

    }
    
    function UpdateDia(date){
        //$('#map').empty();
        
        var hola = 0;
        var fromDia = 0;
        var redirected = 0;
        var date2 = new Date(date);
        fecha = date;
        console.log(fecha);
//        var dateString = date2.format("yyyy-md-dd");
        console.log(date);
        $(location).attr('href', 'http://localhost/SmartDelivery/frontend/web/index.php?r=dia/dia&fromDia=0&date='+date);
//        $.get('index.php?r=dia/dia', {fromDia : fromDia} ,function(data){  
//            console.log(data); 
//        });
    }
    
    function VaciarPersonal(){
        selectedPersonal = [];
        
    }
   $ ("#modal").removeData ('modal');

    
   
 </script>

