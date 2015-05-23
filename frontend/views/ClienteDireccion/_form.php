<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ClienteDireccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cliente-direccion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cli_id')->textInput() ?>

    <?= $form->field($model, 'dir_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
