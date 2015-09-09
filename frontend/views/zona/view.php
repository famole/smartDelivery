<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */

    $this->title = $model->z_nombre;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zonas'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #map {
        height:10%;
    }
 </style>

<title>Zona</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>   
<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
<!--<script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>-->
<script type="text/javascript" src="js/OpenLayers.js"></script>
<script src="js/mapHelper.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.7.0/ol.js"></script>




    <div class="zona-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'z_id',
                'z_nombre',

            ],
        ]) ?>
    </div>
      
    <div id="map" class="map"></div>
               

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->z_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->z_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar la zona?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
       


<script>
        $( document ).ready(function() {
            console.log( "ready!" );
            var wkt = "<?php echo $model->z_wkt; ?>" ;
            var z_id = "<?php echo $model->z_id; ?>";
            var z_nombre = "<?php echo $model->z_nombre; ?>";
            var zona = new Array();
            zona.z_id = z_id;
            zona.wkt = wkt;
            zona.z_nombre = z_nombre;
            
            
            console.log(wkt);
            var latlongfeature= createLayer(zona);
//            console.log(latlongfeature.long);
//            console.log(latlongfeature.lat);
            var map = createNiceMap(-6252731.917154272,-4150822.2589118066,14,'map');
            //var map = createNiceMap(latlongfeature.long,latlongfeature.lat,14,'map');
            //var map = createMap(latlongfeature.lat,latlongfeature.long,14,'map');
            map.addLayer(latlongfeature.vector);
        }); 
</script>


