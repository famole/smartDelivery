<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClienteDireccion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cliente Direccion',
]) . ' ' . $model->cli_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cliente Direccions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cli_id, 'url' => ['view', 'id' => $model->cli_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cliente-direccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
