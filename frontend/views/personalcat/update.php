<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personalcat */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Personalcat',
]) . ' ' . $model->pc_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Personalcats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pc_id, 'url' => ['view', 'id' => $model->pc_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="personalcat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
