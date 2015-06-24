<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */

$this->title = "Vehiculo - ". $model->ve_matricula;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vehiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculo-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            've_id',
            've_matricula',
            've_seguro',
            've_movil',
            'tipoVehiculo.tv_nombre',
            've_entregaslimite',
        ],
    ]) ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->ve_id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->ve_id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar el Vehiculo?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
