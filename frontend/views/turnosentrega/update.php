<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TurnosEntrega */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Turnos Entrega',
]) . ' ' . $model->te_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Turnos Entregas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->te_id, 'url' => ['view', 'id' => $model->te_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="turnos-entrega-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
