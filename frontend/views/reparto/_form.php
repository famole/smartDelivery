<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Reparto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reparto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rep_id')->textInput() ?>

    <?= $form->field($model, 've_id')->textInput() ?>

    <?= $form->field($model, 'rep_fhini')->textInput() ?>

    <?= $form->field($model, 'rep_fhfin')->textInput() ?>

    <?= $form->field($model, 'est_id')->textInput() ?>

    <?= $form->field($model, 'est_observacion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
