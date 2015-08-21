<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

<div class="bs-example">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#sectionA">Mapa</a></li>
        <li><a data-toggle="tab" href="#sectionB">Repartos</a></li>
      
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
            
        </div>
        <div id="sectionB" class="tab-pane fade ">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                <?= Html::a('Crear Reparto', 'index.php?r=dia/dia&fromDia=0&date=', ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'rep_id',
                    've_id',
                    'rep_fhini',
                    'rep_fhfin',
                    'est_id',
                    // 'est_observacion',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>


<script type="text/javascript">
    
      
    var map = createNiceMap(-6252731.917154272,-4150822.2589118066,14,'sectionA');
    
</script>
