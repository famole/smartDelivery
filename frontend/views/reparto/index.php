<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\enum\EnumPinType;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RepartoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>   
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.7.0/ol.js"></script>
<script type="text/javascript" src="js/sortable/Sortable.js"></script>

<style>
    #popup {
    padding-bottom: 45px;
    
  }
  .popover-content {
    min-width: 230px;
  }
</style>

<div class="bs-example">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#sectionA">Mapa</a></li>
        <li><a data-toggle="tab" href="#sectionB">Repartos</a></li>
      
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
            <div id="popup" style ="with:100px"></div>   
        </div>
        <div id="sectionB" class="tab-pane fade ">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                <?= Html::a('Crear Reparto', 'index.php?r=dia/dia&fromDia=1&date=', ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'rep_id',
                    [
                        'label' => 'Vehiculo',
                        'value' => 've.ve_matricula',
                    ],
                    
                    'rep_fhini',
                    'rep_fhfin',
                    [
                        'label' => 'Estado',
                        'value' => 'est.est_nom',
                    ],
                    
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>


<script type="text/javascript">
    var entregas = eval(<?php echo $entregasJson; ?>) ;  
    var pinType; 
    
    var map = createNiceMap(-6252731.917154272,-4150822.2589118066,14,'sectionA');
    
    for (indice = 0; indice < entregas.length; ++indice) {
       
        var point = new OpenLayers.LonLat(entregas[indice].lon,entregas[indice].lat);
        var point2 = point;
        point2.transform('EPSG:4326','EPSG:3857');
        console.log(point2.lon);
        console.log(point2.lat);
        switch (entregas[indice].estado){
            case "Cancelado":
                pinType = <?php echo '"' .EnumPinType::Orange. '"';?>;
                break;
            case "Entregado":
                pinType = <?php echo '"' .EnumPinType::Green. '"';?>;
                break;
            case "Pendiente-Armar":
                pinType = <?php echo '"' .EnumPinType::Yellow. '"';?>;
                break;
            case "Pendiente-Reparto":
                pinType = <?php echo '"' .EnumPinType::Blue. '"';?>;
                break;
            
        }
        var pointLayer = dibujarIcono(point2.lon,point2.lat,entregas[indice],pinType);
        map.addLayer(pointLayer);
    
    } 
    popup(map);
    
</script>
