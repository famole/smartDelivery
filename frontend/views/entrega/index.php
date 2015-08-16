<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EntregaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entregas';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> 


<div class="entrega-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id'=>'entregas-grid'])?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions'=>function($model){
                    if($model->ent_pendefinir == 1){
                        return ['class' => 'danger'];
                    }
            },
            'columns' => [
                'ent_id',
                'ped_id',
                [
                    'attribute' => 'ent_fecha',
                    'format' => ['date','dd-MM-Y'],
                    'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'ent_fecha',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                            ]
                            ]),
                  
                ],
                'te_id',
                [
                    'attribute' => 'estado',
                    'value' => function($model){
                        if($model->ent_pendefinir == 1){
                            return $model->ent_errorDesc;
                        }else{
                            return $model->estados->est_nom;
                        }
                    }
                ],
                [
                    'attribute' => '',
                    'format' => 'raw',
                    'value' => function ($model, $url) {  
                        if($model->ent_pendefinir == 1){
                            return Html::a('<span class="glyphicon glyphicon-exclamation-sign" style = "cursor: pointer;"></span>', 'index.php?r=entrega/set-address&id=' . $model->ent_id);
                        }else{
                            return Html::a('<span class="glyphicon glyphicon-eye-open" style = "cursor: pointer;"></span>', $url);                        
                        }

                    },
                ],

            ],
        ]); ?>
    <?php Pjax::end()?>

</div>