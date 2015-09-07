<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoVehiculo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tipo Vehiculo',
]) . ' ' . $model->tv_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Vehiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tv_id, 'url' => ['view', 'id' => $model->tv_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="tipo-vehiculo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
