<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */

    $this->title = $model->z_id;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zonas'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #map {
        height:10%;
    }
 </style>
<html>
    <head>
        <title>Zona</title>
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/OpenLayers.js"></script>
        <script src="js/mapHelper.js" type="text/javascript"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.6.0/ol.css" type="text/css">

    </head>

    <body>
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
        <p>    
            <div class="container-fluid">

                <div class="row-fluid">
                    <div class="span12">
                      <div id="map" class="map"></div>
                    </div>
                </div>

            </div>
        </p> 

        <p>
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
        </p>


        <script>
            $( document ).ready(function() {
                console.log( "ready!" );
                var wkt = "<?php echo $model->z_wkt; ?>" ;

                var latlongfeature= createLayer(wkt);
                var map = createMap(latlongfeature.lat,latlongfeature.long,14,'map');
                addLayer(map,latlongfeature.vector);
            }); 
        </script>

    </body>
</html>
