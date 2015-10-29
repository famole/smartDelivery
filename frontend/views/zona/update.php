<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\zona */

$this->title = $model->z_nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zonas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->z_nombre, 'url' => ['view', 'id' => $model->z_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="zona-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
