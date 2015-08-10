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
                //'ent_pendefinir',
                'te_id',
                [
                    'attribute' => 'estado',
                    'value' => 'estados.est_nom'
                ],

                ['class' => 'yii\grid\ActionColumn',
                 'template' => '{view}{update}{delete}',
                  'buttons' => [
                    'update' => function ($url,$model) {
                        if($model->ent_pendefinir == 1){
                            return Html::a('<span class="glyphicon glyphicon-exclamation-sign"></span>', $url);
                        }else{
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        }
                    }],
                ],
            ],
        ]); ?>
    <?php Pjax::end()?>

</div>
