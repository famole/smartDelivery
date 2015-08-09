<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\pedido */

$this->title = Yii::t('app', 'Actualizar Pedido');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="pedido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
