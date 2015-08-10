<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Entrega */

$this->title = 'Update Entrega: ' . ' ' . $model->ent_id;
$this->params['breadcrumbs'][] = ['label' => 'Entregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ent_id, 'url' => ['view', 'id' => $model->ent_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entrega-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
