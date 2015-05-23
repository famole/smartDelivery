<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Direccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="direccion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dir_id')->textInput() ?>

    <?= $form->field($model, 'dir_direccion')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'dir_latlong')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
