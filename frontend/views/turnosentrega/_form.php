<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TurnosEntrega */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnos-entrega-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'te_id')->textInput() ?>

    <?= $form->field($model, 'te_nombre')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'te_horainicio')->textInput() ?>

    <?= $form->field($model, 'te_horafin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
