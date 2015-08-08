<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\enum\EnumStatusType;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estados');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Nuevo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'est_nom',
            
            [
                'attribute' => 'est_type',
                'value' => function($model) {
                    switch($model->est_type){
                        case EnumStatusType::Entrega:
                            return 'Entrega';
                            break;
                        case EnumStatusType::Pedido:
                            return 'Pedido';
                            break;
                        case EnumStatusType::Reparto:
                            return 'Reparto';
                            break;
                        case EnumStatusType::System:
                            return 'Sistema';
                            break;
                        
                    }
               
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
