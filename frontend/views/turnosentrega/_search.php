<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TurnosEntregaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnos-entrega-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'te_id') ?>

    <?= $form->field($model, 'te_nombre') ?>

    <?= $form->field($model, 'te_horainicio') ?>

    <?= $form->field($model, 'te_horafin') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
