<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vehiculo',
]) . ' ' . $model->ve_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vehiculos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ve_id, 'url' => ['view', 'id' => $model->ve_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vehiculo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
