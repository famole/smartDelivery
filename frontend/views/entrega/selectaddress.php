<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<?php
use kartik\sidenav\SideNav;
$this->title = 'Seleccionar Direccion';
$this->registerJSFile("https://code.jquery.com/jquery-1.11.2.min.js");
$this->registerJSFile("http://openlayers.org/en/v3.0.0/build/ol.js");
$this->registerJSFile("js/OpenLayers.js");
$this->registerJSFile("js/mapHelper.js");
use yii\helpers\Json;


?>
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
 
<style>
/*  .map {
    height: 80%;
    width: 90%;
  }*/
</style>



<div class="container">
    <h4>No  fue posible resolver la direcci&oacute;n<small><br>Seleccione la ubicaci&oacute;n exacta en el mapa</small></h4>
    <div class="col-md-8"> 
        <div class="map" id="map"></div>
    </div>
    <div class="col-md-4">
        <?php
          echo SideNav::widget([
             'type' => SideNav::TYPE_DEFAULT,
             'encodeLabels' => false,
             'heading' => "Direcciones",
             'containerOptions' => ['id'=>'vhmenu'],
             'items' => $items,

          ]);
        ?>
    </div>
</div>

<script>
    var map=createNiceMap(-6252731.917154272,-4150822.2589118066,14,'map');
    $(document).ready(function(){
       var jsonList = <?php echo $address;?>;
       
       $("li").click(function(){
           var listId=this.id;
           for(i=0;i<2;i++){
                alert(jsonList[i]);
            }
       }) ;
    });
</script>
