<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\numeradores */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Numeradores',
]) . ' ' . $model->num_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Numeradores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->num_id, 'url' => ['view', 'id' => $model->num_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="numeradores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
