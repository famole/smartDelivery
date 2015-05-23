<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'per_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'per_nom')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'per_priape')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'per_segape')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'per_tel')->textInput() ?>

    <?= $form->field($model, 'pc_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
