<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Reparto */

$this->title = 'Update Reparto: ' . ' ' . $model->rep_id;
$this->params['breadcrumbs'][] = ['label' => 'Repartos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rep_id, 'url' => ['view', 'id' => $model->rep_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reparto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
