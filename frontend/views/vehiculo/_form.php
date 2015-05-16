<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehiculo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 've_id')->textInput() ?>

    <?= $form->field($model, 've_matricula')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 've_seguro')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 've_movil')->textInput() ?>

    <?= $form->field($model, 'tv_id')->textInput() ?>

    <?= $form->field($model, 've_entregaslimite')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
