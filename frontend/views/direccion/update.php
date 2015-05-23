<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Direccion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Direccion',
]) . ' ' . $model->dir_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Direccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dir_id, 'url' => ['view', 'id' => $model->dir_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="direccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>