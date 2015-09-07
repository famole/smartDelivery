<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Personalcat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personalcat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pc_id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'pc_desc')->textInput(['maxlength' => 45]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Guardar') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
