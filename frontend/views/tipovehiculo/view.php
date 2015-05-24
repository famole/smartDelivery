<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoVehiculo */

$this->title = $model->tv_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Vehiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-vehiculo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tv_id',
            'tv_nombre',
        ],
    ]) ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->tv_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->tv_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Esta seguro que desea eliminar el Tipo de Vehiculo?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
