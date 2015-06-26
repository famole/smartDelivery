<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */

$this->title = $model->z_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zonas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<html>
<head>
    <title>WKT example</title>
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.6.0/ol.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.6.0/ol.js"></script>
    <script type="text/javascript" src="js/OpenLayers.js"></script>

</head>

<body>
<div class="zona-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->z_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->z_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'z_id',
            'z_nombre',
            'z_zona',
            'z_wkt:ntext',
        ],
    ]) ?>

</div>
    
<div id="map" class="smallmap"></div>
    
<script>
var wkt3 = "<?php echo $model->z_wkt; ?>" ;
var wkt2 = "'"+wkt+"'";
document.write("VariableJS = " + wkt2);
var map = new OpenLayers.Map({
            div: "map",
            projection: new OpenLayers.Projection("EPSG:900913"),
            displayProjection: new OpenLayers.Projection("EPSG:4326"),
            layers: [
                new OpenLayers.Layer.OSM()
                ]
        });
        
        var wkt = new OpenLayers.Format.WKT();
        
        
        var vectors = new OpenLayers.Layer.Vector('My Vectors');
        map.addLayer(vectors);
        
  
        var wkt = new OpenLayers.Format.WKT();

        var polygonFeature = wkt.read("POLYGON((-15.8203125 2.4609375, -15.8203125 -10.546875, 6.85546875 -11.25, 8.26171875 -3.33984375, -15.8203125 2.4609375))");
        polygonFeature.geometry.transform(map.displayProjection, map.getProjectionObject());
        vectors.addFeatures([polygonFeature]);

        

      

</script>
    
</body>
</html>
