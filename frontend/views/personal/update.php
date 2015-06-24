<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personal */

$this->title = 'Actualizar: '. $model->per_nom . ' ' . $model->per_priape;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Personal'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->per_id, 'url' => ['view', 'id' => $model->per_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="personal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
