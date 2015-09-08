<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use frontend\enum\EnumBaseStatus;

/* @var $this yii\web\View */
/* @var $model frontend\models\Reparto */

$this->title = 'Reparto: ' . $model->rep_id;
$this->params['breadcrumbs'][] = ['label' => 'Repartos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reparto-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rep_id',
            [
                'attribute' => 'Vehiculo',
                'value' => $model->ve->ve_matricula,
                   
            ],
            'rep_fhini',
            'rep_fhfin',
            [
                'attribute' => 'Estado',
                'value' => $model->est->est_nom,
                   
            ],
            'est_observacion',
        ],
    ]) ?>
    
    <div class="form-group">
        <h4>Entregas</h4>
        <hr>
        <?= 
            GridView::widget([
            'dataProvider' => $entregaDataProvider,
            'rowOptions'=>function($model){
                    if($model->estados->est_nom == EnumBaseStatus::Cancelado){
                        return ['class' => 'danger'];
                    }
            },
            'columns' => [
                [
                    'attribute' => '',
                    'format' => 'raw',
                    'value' => function ($model2, $url) {
                        if ($model2->estados->est_nom !== EnumBaseStatus::Cancelado && $model2->estados->est_nom !== EnumBaseStatus::Finalizado ){
                            return Html::a('<span class="glyphicon glyphicon-remove-sign" style = "cursor: pointer;"></span>', 'index.php?r=entrega/cancel&id=' . $model2->ent_id . '&repId=' . Yii::$app->getRequest()->getQueryParam('id'));
                            
                        }else{
                            return '';
                        }
                    },
                ],
                'ent_id',
                'ped_id',
                [
                    'attribute' => 'ent_fecha',
                    'format' => ['date','dd-MM-Y'],


                ],
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
                
            ],
        ]); ?>
    </div>
</div>
