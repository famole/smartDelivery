<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\TurnosEntrega */

$this->title = Yii::t('app', 'Create Turnos Entrega');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Turnos Entregas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnos-entrega-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
