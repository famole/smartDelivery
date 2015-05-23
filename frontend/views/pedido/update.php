<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\pedido */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Pedido',
]) . ' ' . $model->ped_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ped_id, 'url' => ['view', 'ped_id' => $model->ped_id, 'cli_id' => $model->cli_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pedido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
