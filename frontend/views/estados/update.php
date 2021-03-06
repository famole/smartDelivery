<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estados */

$this->title = Yii::t('app', 'Actualizar Estado: ', [
    'modelClass' => 'Estados',
]) . ' ' . $model->est_nom;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estados'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->est_id, 'url' => ['view', 'id' => $model->est_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="estados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
