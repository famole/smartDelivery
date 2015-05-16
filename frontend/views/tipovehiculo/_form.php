<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoVehiculo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-vehiculo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tv_id')->textInput() ?>

    <?= $form->field($model, 'tv_nombre')->textInput(['maxlength' => 45]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
