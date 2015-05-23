<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ped_id')->textInput() ?>

    <?= $form->field($model, 'cli_id')->textInput() ?>

    <?= $form->field($model, 'ped_fechahora')->textInput() ?>

    <?= $form->field($model, 'ped_direccion')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'ped_observaciones')->textInput(['maxlength' => 1000]) ?>

    <?= $form->field($model, 'ped_ultproc')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
