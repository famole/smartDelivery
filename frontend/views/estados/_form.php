<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'est_id')->textInput() ?>

    <?= $form->field($model, 'est_nom')->textInput(['maxlength' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
